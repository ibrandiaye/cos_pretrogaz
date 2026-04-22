<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parameter extends Model
{
    protected $fillable = [
        'project_id', 'taux_is', 'tva', 'cel', 'taxe_export',
        'redevance_petrole', 'redevance_gaz', 'taxe_carbone',
        'wht_dividendes', 'business_license_tax',
        'petrosen_participation', 'state_participation', 'cost_recovery_ceiling',
        'bloc_type',
        'bonus_signature', 'bonus_production',
        'petrosen_loan_amount', 'petrosen_interest_rate', 'petrosen_grace_period', 'petrosen_maturity',
        'discount_rate',
        'depreciation_exploration', 'depreciation_installations', 'depreciation_pipeline_fpso',
        'nol_years', 'abandonment_provision',
    ];

    protected $casts = [
        'taux_is' => 'decimal:2',
        'tva' => 'decimal:2',
        'cel' => 'decimal:2',
        'taxe_export' => 'decimal:2',
        'redevance_petrole' => 'decimal:2',
        'redevance_gaz' => 'decimal:2',
        'wht_dividendes' => 'decimal:2',
        'business_license_tax' => 'decimal:4',
        'petrosen_participation' => 'decimal:2',
        'state_participation' => 'decimal:2',
        'cost_recovery_ceiling' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'abandonment_provision' => 'decimal:2',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
