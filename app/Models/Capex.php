<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Capex extends Model
{
    protected $fillable = [
        'project_id', 'year',
        'exploration', 'etudes_pre_fid', 'forage_completion',
        'installations_sous_marines', 'pipeline', 'installations_surface',
        'owners_cost', 'imprevus',
    ];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function total(): float
    {
        return $this->exploration + $this->etudes_pre_fid + $this->forage_completion
             + $this->installations_sous_marines + $this->pipeline
             + $this->installations_surface + $this->owners_cost + $this->imprevus;
    }
}
