<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Capex extends Model
{
    protected $fillable = ['project_id', 'year', 'exploration', 'development', 'pipeline_fpso', 'installations', 'divers'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function total(): float
    {
        return $this->exploration + $this->development + $this->pipeline_fpso + $this->installations + $this->divers;
    }
}
