<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opex extends Model
{
    protected $fillable = [
        'project_id', 'year',
        'location_flng', 'location_fpso', 'opex_puits',
        'maintenance_installations', 'autres_opex',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function total(): float
    {
        return $this->location_flng + $this->location_fpso + $this->opex_puits
             + $this->maintenance_installations + $this->autres_opex;
    }
}
