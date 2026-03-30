<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opex extends Model
{
    protected $fillable = ['project_id', 'year', 'exploitation', 'maintenance', 'location'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }

    public function total(): float
    {
        return $this->exploitation + $this->maintenance + $this->location;
    }
}
