<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    protected $fillable = ['project_id', 'year', 'oil_price', 'gas_price', 'gnl_price', 'gas_domestic_price', 'inflation', 'exchange_rate'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
