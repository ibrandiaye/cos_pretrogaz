<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PetroleumCodeTranche extends Model
{
    protected $fillable = [
        'petroleum_code_id', 'order', 'threshold_max', 'state_share', 'contractor_share',
    ];

    protected $casts = [
        'threshold_max' => 'decimal:4',
        'state_share' => 'decimal:2',
        'contractor_share' => 'decimal:2',
    ];

    public function petroleumCode(): BelongsTo
    {
        return $this->belongsTo(PetroleumCode::class);
    }
}
