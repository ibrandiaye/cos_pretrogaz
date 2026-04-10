<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abex extends Model
{
    protected $fillable = ['project_id', 'year', 'cout_abandon'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function total(): float
    {
        return $this->cout_abandon;
    }
}
