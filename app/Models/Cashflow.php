<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cashflow extends Model
{
    protected $fillable = [
        'project_id', 'scenario', 'year',
        'gross_revenue', 'royalties', 'net_revenue',
        'recoverable_costs', 'cost_recovery',
        'profit_oil', 'r_factor',
        'state_share', 'petrosen_share', 'operator_share',
        'income_tax', 'cel', 'export_tax',
        'wht_dividendes', 'business_license_tax', 'depreciation',
        'capex_total', 'opex_total', 'abex_total', 'project_cashflow', 'discounted_cashflow',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
