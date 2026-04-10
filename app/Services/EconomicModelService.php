<?php

namespace App\Services;

use App\Models\Project;
use App\Models\PetroleumCode;
use App\Models\Cashflow;

class EconomicModelService
{
    /**
     * Run a full simulation for a project, optionally with overridden prices/production.
     */
    public function runSimulation(Project $project, array $overrides = [], string $scenario = 'base'): array
    {
        $params = $project->parameter;
        $capexes = $project->capexes->keyBy('year');
        $opexes = $project->opexes->keyBy('year');
        $productions = $project->productions->keyBy('year');
        $prices = $project->prices->keyBy('year');

        if (!$params) {
            return ['error' => 'Missing parameters'];
        }

        // Load petroleum code config (dynamic)
        $petroleumCode = $project->petroleumCode;
        if (!$petroleumCode) {
            // Fallback: try to match by code_petrolier string
            $petroleumCode = PetroleumCode::where('short_name', $project->code_petrolier)->first();
        }
        if (!$petroleumCode) {
            return ['error' => 'Missing petroleum code configuration'];
        }
        $petroleumCode->load('tranches');

        $blocType = $params->bloc_type ?? 'offshore_profond';

        // Get rates from petroleum code
        $royaltyOilRate = $petroleumCode->getRoyaltyOilRate($blocType) / 100;
        $royaltyGasRate = (float) $petroleumCode->royalty_gas_rate / 100;
        $costRecoveryCeiling = $petroleumCode->getCostRecoveryCeiling($blocType);
        $exportTaxRate = (float) $petroleumCode->taxe_export / 100;
        $celRate = (float) $petroleumCode->cel / 100;
        $bltRate = (float) $petroleumCode->business_license_tax / 100;
        $isRate = (float) $petroleumCode->taux_is / 100;
        $whtRate = (float) $petroleumCode->wht_dividendes / 100;

        $yearlyCashflows = [];
        $cumulativeRevenue = 0;
        $cumulativeCost = 0;
        $npv = 0;
        $discountRate = (float) $params->discount_rate / 100;
        $petrosenParticipation = (float) $params->petrosen_participation / 100;

        // Petrosen loan tracking
        $petrosenLoanBalance = (float) $params->petrosen_loan_amount;
        $petrosenInterestRate = (float) $params->petrosen_interest_rate / 100;
        $petrosenGrace = (int) $params->petrosen_grace_period;
        $petrosenMaturity = (int) $params->petrosen_maturity;
        $petrosenCapitalizedInterest = 0;

        // Depreciation tracking
        $depreciationSchedule = [];
        $depExploration = (int) $petroleumCode->depreciation_exploration;
        $depInstallations = (int) $petroleumCode->depreciation_installations;
        $depPipelineFpso = (int) $petroleumCode->depreciation_pipeline_fpso;

        // NOL carry-forward tracking
        $nolYears = (int) $petroleumCode->nol_years;
        $nolCarryForward = [];

        for ($y = 1; $y <= $project->duration; $y++) {
            $capex = $capexes->get($y);
            $opex = $opexes->get($y);
            $production = $productions->get($y);
            $price = $prices->get($y);

            $capexTotal = $capex ? $capex->total() : 0;
            $opexTotal = $opex ? $opex->total() : 0;

            // Apply scenario overrides
            $oilPriceMult = $overrides['oil_price_mult'] ?? 1.0;
            $gasPriceMult = $overrides['gas_price_mult'] ?? 1.0;
            $productionMult = $overrides['production_mult'] ?? 1.0;

            $oilProd = $production ? (float) $production->oil * $productionMult : 0;
            $gasProd = $production ? (float) $production->gas * $productionMult : 0;
            $gnlProd = $production ? (float) $production->gnl * $productionMult : 0;

            $oilPrice = $price ? (float) $price->oil_price * $oilPriceMult : 0;
            $gasPrice = $price ? (float) $price->gas_price * $gasPriceMult : 0;
            $gnlPrice = $price ? (float) $price->gnl_price * $gasPriceMult : 0;

            // === 1. GROSS REVENUES ===
            $revenueOil = $oilProd * $oilPrice;
            $revenueGas = $gasProd * $gasPrice;
            $revenueGnl = $gnlProd * $gnlPrice * 52; // 52 MMBTU/tonne
            $grossRevenue = $revenueOil + $revenueGas + $revenueGnl;

            // === 2. ROYALTIES ===
            $royaltyPetrol = $revenueOil * $royaltyOilRate;
            $royaltyGaz = ($revenueGas + $revenueGnl) * $royaltyGasRate;
            $royalties = $royaltyPetrol + $royaltyGaz;

            // === 3. TAXES BEFORE COST RECOVERY ===
            $exportTax = $grossRevenue * $exportTaxRate;
            $celTax = $grossRevenue * $celRate;
            $businessLicenseTax = $grossRevenue * $bltRate;
            $netRevenue = $grossRevenue - $royalties - $exportTax;

            // === 4. DEPRECIATION ===
            if ($capex && $capexTotal > 0) {
                $exploration = (float) ($capex->exploration ?? 0);
                $development = (float) ($capex->development ?? 0);
                $pipelineFpso = (float) ($capex->pipeline_fpso ?? 0);
                $installations = (float) ($capex->installations ?? 0);
                $divers = (float) ($capex->divers ?? 0);

                if ($exploration > 0) {
                    $depreciationSchedule[] = ['amount' => $exploration, 'start_year' => $y, 'duration' => $depExploration];
                }
                if ($development > 0) {
                    $depreciationSchedule[] = ['amount' => $development, 'start_year' => $y, 'duration' => $depInstallations];
                }
                if ($pipelineFpso > 0) {
                    $depreciationSchedule[] = ['amount' => $pipelineFpso, 'start_year' => $y, 'duration' => $depPipelineFpso];
                }
                if ($installations > 0) {
                    $depreciationSchedule[] = ['amount' => $installations, 'start_year' => $y, 'duration' => $depInstallations];
                }
                if ($divers > 0) {
                    $depreciationSchedule[] = ['amount' => $divers, 'start_year' => $y, 'duration' => $depInstallations];
                }
            }

            $yearlyDepreciation = 0;
            foreach ($depreciationSchedule as $item) {
                if ($y >= $item['start_year'] && $y < $item['start_year'] + $item['duration']) {
                    $yearlyDepreciation += $item['amount'] / $item['duration'];
                }
            }

            // === 5. COST RECOVERY ===
            $currentYearCosts = $capexTotal + $opexTotal;
            $cumulativeCost += $currentYearCosts;
            $crCeiling = $netRevenue * $costRecoveryCeiling / 100;
            $costRecovery = min($cumulativeCost, max(0, $crCeiling));
            $cumulativeCost -= $costRecovery;

            // === 6. PROFIT OIL ===
            $profitOil = max(0, $netRevenue - $costRecovery);

            // === 7. PROFIT OIL SPLIT (dynamic from PetroleumCode) ===
            $cumulativeRevenue += $grossRevenue;
            $rFactor = null;

            if ($petroleumCode->profit_split_method === 'r_factor') {
                // R-Factor indicator
                $totalCumulCost = $cumulativeCost + $costRecovery;
                $rFactor = $totalCumulCost > 0 ? $cumulativeRevenue / $totalCumulCost : 0;
                $indicator = $rFactor;
            } else {
                // Production-based indicator (bbl/day)
                $indicator = $production ? (float) ($production->oil ?? 0) * $productionMult / 365 * 1000 : 0;
            }

            [$stateShare, $contractorShare] = $petroleumCode->getProfitOilSplit($profitOil, $indicator);

            // PETROSEN share of contractor portion
            $petrosenProfitShare = $contractorShare * $petrosenParticipation;
            $operatorShare = $contractorShare * (1 - $petrosenParticipation);

            // Carried interest
            $stateCarried = (float) $params->state_participation / 100 * $grossRevenue;
            $stateShare += $stateCarried;

            // === 8. INCOME TAX (IS) ===
            $taxableIncome = $operatorShare - $yearlyDepreciation;

            // NOL carry-forward
            $remainingNol = [];
            foreach ($nolCarryForward as $nol) {
                if ($y - $nol['year_created'] <= $nolYears && $taxableIncome > 0) {
                    $deduct = min($nol['amount'], $taxableIncome);
                    $taxableIncome -= $deduct;
                    $nol['amount'] -= $deduct;
                    if ($nol['amount'] > 0) {
                        $remainingNol[] = $nol;
                    }
                } elseif ($y - $nol['year_created'] <= $nolYears) {
                    $remainingNol[] = $nol;
                }
            }
            $nolCarryForward = $remainingNol;

            if ($taxableIncome < 0) {
                $nolCarryForward[] = ['amount' => abs($taxableIncome), 'year_created' => $y];
                $taxableIncome = 0;
            }

            $incomeTax = $taxableIncome * $isRate;
            $operatorNet = $operatorShare - $incomeTax;

            // === 9. WHT ON DIVIDENDS ===
            $whtDividendes = max(0, $operatorNet) * $whtRate;

            // === 10. PETROSEN LOAN SERVICE ===
            $petrosenInterest = 0;
            $petrosenPrincipal = 0;
            if ($petrosenLoanBalance > 0 && $y > $petrosenGrace) {
                $petrosenInterest = $petrosenLoanBalance * $petrosenInterestRate;
                if ($y == $petrosenGrace + 1 && $petrosenCapitalizedInterest > 0) {
                    $petrosenLoanBalance += $petrosenCapitalizedInterest;
                    $petrosenCapitalizedInterest = 0;
                }
                $amortYears = max(1, $petrosenMaturity - $petrosenGrace);
                $petrosenPrincipal = $params->petrosen_loan_amount / $amortYears;
                $petrosenPrincipal = min($petrosenPrincipal, $petrosenLoanBalance);
                $petrosenLoanBalance -= $petrosenPrincipal;
            } elseif ($petrosenLoanBalance > 0) {
                $petrosenInterest = $petrosenLoanBalance * $petrosenInterestRate;
                $petrosenCapitalizedInterest += $petrosenInterest;
            }

            // === 11. PROJECT CASHFLOW ===
            $projectCashflow = $operatorNet - $whtDividendes - $capexTotal - $opexTotal * (1 - $petrosenParticipation);

            // === 12. DISCOUNTED CASHFLOW ===
            $discountFactor = 1 / pow(1 + $discountRate, $y);
            $discountedCashflow = $projectCashflow * $discountFactor;
            $npv += $discountedCashflow;

            $yearlyCashflows[$y] = [
                'year' => $y,
                'gross_revenue' => round($grossRevenue, 2),
                'royalties' => round($royalties, 2),
                'net_revenue' => round($netRevenue, 2),
                'recoverable_costs' => round($currentYearCosts, 2),
                'cost_recovery' => round($costRecovery, 2),
                'profit_oil' => round($profitOil, 2),
                'r_factor' => $rFactor !== null ? round($rFactor, 4) : null,
                'state_share' => round($stateShare, 2),
                'petrosen_share' => round($petrosenProfitShare + $petrosenInterest, 2),
                'operator_share' => round($operatorNet, 2),
                'income_tax' => round($incomeTax, 2),
                'cel' => round($celTax, 2),
                'export_tax' => round($exportTax, 2),
                'wht_dividendes' => round($whtDividendes, 2),
                'business_license_tax' => round($businessLicenseTax, 2),
                'depreciation' => round($yearlyDepreciation, 2),
                'capex_total' => round($capexTotal, 2),
                'opex_total' => round($opexTotal, 2),
                'project_cashflow' => round($projectCashflow, 2),
                'discounted_cashflow' => round($discountedCashflow, 2),
            ];
        }

        $irr = $this->calculateIRR(array_column($yearlyCashflows, 'project_cashflow'));
        $npv10 = $this->calculateNPV(array_column($yearlyCashflows, 'project_cashflow'), 0.10);

        return [
            'yearly' => $yearlyCashflows,
            'summary' => [
                'npv' => round($npv, 2),
                'npv10' => round($npv10, 2),
                'irr' => $irr !== null ? round($irr * 100, 2) : null,
                'total_gross_revenue' => round(array_sum(array_column($yearlyCashflows, 'gross_revenue')), 2),
                'total_state' => round(array_sum(array_column($yearlyCashflows, 'state_share')), 2),
                'total_petrosen' => round(array_sum(array_column($yearlyCashflows, 'petrosen_share')), 2),
                'total_operator' => round(array_sum(array_column($yearlyCashflows, 'operator_share')), 2),
                'total_taxes' => round(
                    array_sum(array_column($yearlyCashflows, 'income_tax')) +
                    array_sum(array_column($yearlyCashflows, 'cel')) +
                    array_sum(array_column($yearlyCashflows, 'export_tax')) +
                    array_sum(array_column($yearlyCashflows, 'royalties')) +
                    array_sum(array_column($yearlyCashflows, 'wht_dividendes')) +
                    array_sum(array_column($yearlyCashflows, 'business_license_tax')),
                    2
                ),
            ],
            'scenario' => $scenario,
        ];
    }

    public function saveSimulation(Project $project, array $results, string $scenario = 'base'): void
    {
        $project->cashflows()->where('scenario', $scenario)->delete();

        foreach ($results['yearly'] as $data) {
            Cashflow::create(array_merge($data, [
                'project_id' => $project->id,
                'scenario' => $scenario,
            ]));
        }
    }

    public function runMultiScenario(Project $project): array
    {
        return [
            'base' => $this->runSimulation($project, [], 'base'),
            'lowPrice' => $this->runSimulation($project, ['oil_price_mult' => 0.7, 'gas_price_mult' => 0.8], 'lowPrice'),
            'highPrice' => $this->runSimulation($project, ['oil_price_mult' => 1.3, 'gas_price_mult' => 1.3], 'highPrice'),
            'lowProd' => $this->runSimulation($project, ['production_mult' => 0.7], 'lowProd'),
            'highProd' => $this->runSimulation($project, ['production_mult' => 1.3], 'highProd'),
        ];
    }

    public function getIRR(array $cashflows): ?float
    {
        $irr = $this->calculateIRR($cashflows);
        return $irr !== null ? round($irr * 100, 2) : null;
    }

    private function calculateNPV(array $cashflows, float $rate): float
    {
        $npv = 0;
        foreach ($cashflows as $i => $cf) {
            $npv += $cf / pow(1 + $rate, $i + 1);
        }
        return $npv;
    }

    private function calculateIRR(array $cashflows, float $tolerance = 0.0001, int $maxIter = 1000): ?float
    {
        $low = -0.99;
        $high = 10.0;
        $npvAtLow = $this->calculateNPV($cashflows, $low);

        for ($i = 0; $i < $maxIter; $i++) {
            $mid = ($low + $high) / 2;
            $npvAtMid = $this->calculateNPV($cashflows, $mid);

            if (abs($npvAtMid) < $tolerance || ($high - $low) / 2 < $tolerance) {
                return $mid;
            }

            if (($npvAtMid > 0) === ($npvAtLow > 0)) {
                $low = $mid;
                $npvAtLow = $npvAtMid;
            } else {
                $high = $mid;
            }
        }

        return null;
    }
}
