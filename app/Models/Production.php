<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Production extends Model
{
    protected $fillable = ['project_id', 'year', 'oil', 'gas', 'gnl'];

    public function project(): BelongsTo { return $this->belongsTo(Project::class); }
}
