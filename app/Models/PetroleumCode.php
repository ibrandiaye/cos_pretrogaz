<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetroleumCode extends Model
{
    protected $fillable = [
        'name', 'short_name', 'description', 'profit_split_method',
        'royalty_oil_rates', 'royalty_gas_rate', 'cost_recovery_ceilings',
        'taux_is', 'cel', 'taxe_export', 'wht_dividendes', 'business_license_tax', 'tva',
        'petrosen_participation_default', 'state_participation_default',
        'depreciation_exploration', 'depreciation_installations', 'depreciation_pipeline_fpso',
        'nol_years', 'is_system',
    ];

    protected $casts = [
        'royalty_oil_rates' => 'array',
        'cost_recovery_ceilings' => 'array',
        'is_system' => 'boolean',
        'royalty_gas_rate' => 'decimal:2',
        'taux_is' => 'decimal:2',
        'cel' => 'decimal:2',
        'taxe_export' => 'decimal:2',
        'wht_dividendes' => 'decimal:2',
        'business_license_tax' => 'decimal:4',
        'tva' => 'decimal:2',
        'petrosen_participation_default' => 'decimal:2',
        'state_participation_default' => 'decimal:2',
    ];

    public function tranches(): HasMany
    {
        return $this->hasMany(PetroleumCodeTranche::class)->orderBy('order');
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get royalty rate for oil based on bloc type.
     */
    public function getRoyaltyOilRate(string $blocType): float
    {
        $rates = $this->royalty_oil_rates;
        return (float) ($rates[$blocType] ?? $rates['offshore_profond'] ?? 8);
    }

    /**
     * Get cost recovery ceiling based on bloc type.
     */
    public function getCostRecoveryCeiling(string $blocType): float
    {
        $ceilings = $this->cost_recovery_ceilings;
        return (float) ($ceilings[$blocType] ?? $ceilings['offshore_profond'] ?? 65);
    }

    /**
     * Get the profit oil split for given R-Factor or production level.
     */
    public function getProfitOilSplit(float $profitOil, float $indicator): array
    {
        foreach ($this->tranches as $tranche) {
            if ($indicator < (float) $tranche->threshold_max) {
                return [
                    $profitOil * (float) $tranche->state_share / 100,
                    $profitOil * (float) $tranche->contractor_share / 100,
                ];
            }
        }

        // Fallback: last tranche or 50/50
        $last = $this->tranches->last();
        if ($last) {
            return [
                $profitOil * (float) $last->state_share / 100,
                $profitOil * (float) $last->contractor_share / 100,
            ];
        }

        return [$profitOil * 0.50, $profitOil * 0.50];
    }
}
