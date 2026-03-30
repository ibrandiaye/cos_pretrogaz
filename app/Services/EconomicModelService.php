<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Cashflow;
use Illuminate\Support\Collection;

class EconomicModelService
{
    // R-factor tranches from Article 23 of 2019 Petroleum Code (Senegal)
    private const R_FACTOR_TRANCHES_2019 = [
        ['max' => 1.0, 'state' => 0.40, 'contractors' => 0.60],
        ['max' => 2.0, 'state' => 0.45, 'contractors' => 0.55],
        ['max' => 3.0, 'state' => 0.55, 'contractors' => 0.45],
        ['max' => PHP_FLOAT_MAX, 'state' => 0.60, 'contractors' => 0.40],
    ];

    // Fixed tranches for 1998 code (simplified)
    private const FIXED_TRANCHES_1998 = [
        ['max' => PHP_FLOAT_MAX, 'state' => 0.50, 'contractors' => 0.50],
    ];

    /**
     * Run a full simulation for a project, optionally with overridden prices/production.
     * Returns array of yearly cashflow data and summary metrics.
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

        $yearlyCashflows = [];
        $cumulativeRevenue = 0;
        $cumulativeCost = 0;
        $npv = 0;
        $discountRate = (float) $params->discount_rate / 100;

        // Petrosen loan tracking
        $petrosenLoanBalance = (float) $params->petrosen_loan_amount;
        $petrosenInterestRate = (float) $params->petrosen_interest_rate / 100;
        $petrosenGrace = (int) $params->petrosen_grace_period;
        $petrosenMaturity = (int) $params->petrosen_maturity;

        for ($y = 1; $y <= $project->duration; $y++) {
            $capex = $capexes->get($y);
            $opex = $opexes->get($y);
            $production = $productions->get($y);
            $price = $prices->get($y);

            $capexTotal = $capex ? $capex->total() : 0;
            $opexTotal = $opex ? $opex->total() : 0;

            // Apply scenario overrides (price/production multipliers)
            $oilPriceMult = $overrides['oil_price_mult'] ?? 1.0;
            $gasPriceMult = $overrides['gas_price_mult'] ?? 1.0;
            $productionMult = $overrides['production_mult'] ?? 1.0;

            $oilProd = $production ? (float) $production->oil * $productionMult : 0;
            $gasProd = $production ? (float) $production->gas * $productionMult : 0;
            $gnlProd = $production ? (float) $production->gnl * $productionMult : 0;

            $oilPrice = $price ? (float) $price->oil_price * $oilPriceMult : 0;
            $gasPrice = $price ? (float) $price->gas_price * $gasPriceMult : 0;
            $gnlPrice = $price ? (float) $price->gnl_price : 0;

            // === 1. GROSS REVENUES ===
            // Note: production in Mbbl → revenue in M$
            $revenueOil = $oilProd * $oilPrice;
            $revenueGas = $gasProd * $gasPrice * 1000; // Bcf → MMBTU (×1000)
            $revenueGnl = $gnlProd * $gnlPrice * 1000;
            $grossRevenue = $revenueOil + $revenueGas + $revenueGnl;

            // === 2. ROYALTIES & TAXES BEFORE COST RECOVERY ===
            $royaltyPetrol = $grossRevenue > 0 ? ($revenueOil / $grossRevenue) * (float) $params->redevance_petrole / 100 * $grossRevenue : 0;
            $royaltyGaz = $grossRevenue > 0 ? (($revenueGas + $revenueGnl) / $grossRevenue) * (float) $params->redevance_gaz / 100 * $grossRevenue : 0;
            $royalties = $royaltyPetrol + $royaltyGaz;

            $exportTax = $grossRevenue * (float) $params->taxe_export / 100;
            $celTax = $grossRevenue * (float) $params->cel / 100;

            $netRevenue = $grossRevenue - $royalties - $exportTax;

            // === 3. COST RECOVERY ===
            $currentYearCosts = $capexTotal + $opexTotal;
            $cumulativeCost += $currentYearCosts;
            $recoverableCosts = $cumulativeCost; // simplified (all costs recoverable)
            $crCeiling = $netRevenue * (float) $params->cost_recovery_ceiling / 100;
            $costRecovery = min($recoverableCosts, $crCeiling);
            $cumulativeCost -= $costRecovery; // reduce carried costs by what was recovered

            // === 4. PROFIT OIL ===
            $profitOil = max(0, $netRevenue - $costRecovery);

            // === 5. R-FACTOR (Code 2019 only) ===
            $rFactor = null;
            if ($project->code_petrolier === '2019' && $cumulativeCost > 0) {
                $rFactor = $cumulativeRevenue / max(1, $cumulativeCost + $capexTotal);
            }

            // === 6. PROFIT OIL SPLIT ===
            [$stateShare, $contractorShare] = $this->getProfitOilSplit(
                $profitOil,
                $project->code_petrolier,
                $rFactor
            );

            // PETROSEN's share of contractor portion
            $petrosenParticipation = (float) $params->petrosen_participation / 100;
            $petrosenProfitShare = $contractorShare * $petrosenParticipation;
            $operatorShare = $contractorShare * (1 - $petrosenParticipation);

            // Add state participation (carried interest, if any)
            $stateCarried = (float) $params->state_participation / 100 * $grossRevenue;
            $stateShare += $stateCarried;

            // === 7. INCOME TAX (IS) ===
            $taxableIncome = max(0, $operatorShare - $opexTotal);
            $incomeTax = $taxableIncome * (float) $params->taux_is / 100;
            $operatorNet = $operatorShare - $incomeTax;

            // === 8. PETROSEN LOAN SERVICE ===
            $petrosenInterest = 0;
            $petrosenPrincipal = 0;
            if ($petrosenLoanBalance > 0 && $y > $petrosenGrace) {
                $petrosenInterest = $petrosenLoanBalance * $petrosenInterestRate;
                $amortYears = max(1, $petrosenMaturity - $petrosenGrace);
                $petrosenPrincipal = $params->petrosen_loan_amount / $amortYears;
                $petrosenPrincipal = min($petrosenPrincipal, $petrosenLoanBalance);
                $petrosenLoanBalance -= $petrosenPrincipal;
            } elseif ($petrosenLoanBalance > 0) {
                $petrosenInterest = $petrosenLoanBalance * $petrosenInterestRate;
            }

            // === 9. PROJECT CASHFLOW (Operator perspective) ===
            $projectCashflow = $operatorNet - $capexTotal - $opexTotal * (1 - $petrosenParticipation);

            // === 10. DISCOUNTED CASHFLOW ===
            $discountFactor = 1 / pow(1 + $discountRate, $y);
            $discountedCashflow = $projectCashflow * $discountFactor;
            $npv += $discountedCashflow;

            $cumulativeRevenue += $grossRevenue;

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
                    array_sum(array_column($yearlyCashflows, 'royalties')),
                    2
                ),
            ],
            'scenario' => $scenario,
        ];
    }

    /**
     * Save simulation results to the database.
     */
    public function saveSimulation(Project $project, array $results, string $scenario = 'base'): void
    {
        // Clear old results for this scenario
        $project->cashflows()->where('scenario', $scenario)->delete();

        foreach ($results['yearly'] as $year => $data) {
            Cashflow::create(array_merge($data, [
                'project_id' => $project->id,
                'scenario' => $scenario,
            ]));
        }
    }

    /**
     * Run multiple scenario simulations.
     */
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

    // ----------------------------------------------------------------
    //  PRIVATE HELPERS
    // ----------------------------------------------------------------

    private function getProfitOilSplit(float $profitOil, string $code, ?float $rFactor): array
    {
        $tranches = $code === '2019'
            ? self::R_FACTOR_TRANCHES_2019
            : self::FIXED_TRANCHES_1998;

        $r = $rFactor ?? 0;

        foreach ($tranches as $tranche) {
            if ($r < $tranche['max']) {
                return [
                    $profitOil * $tranche['state'],
                    $profitOil * $tranche['contractors'],
                ];
            }
        }

        // Default fallback
        return [$profitOil * 0.50, $profitOil * 0.50];
    }

    private function calculateNPV(array $cashflows, float $rate): float
    {
        $npv = 0;
        foreach ($cashflows as $i => $cf) {
            $npv += $cf / pow(1 + $rate, $i + 1);
        }
        return $npv;
    }

    /**
     * Calculate IRR using bisection method.
     * Returns null if no real IRR exists.
     */
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

        return null; // No convergence
    }
}
