<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Project extends Model
{
    protected $fillable = [
        'user_id', 'name', 'code_petrolier', 'duration', 'type', 'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parameter(): HasOne
    {
        return $this->hasOne(Parameter::class);
    }

    public function capexes(): HasMany
    {
        return $this->hasMany(Capex::class)->orderBy('year');
    }

    public function opexes(): HasMany
    {
        return $this->hasMany(Opex::class)->orderBy('year');
    }

    public function productions(): HasMany
    {
        return $this->hasMany(Production::class)->orderBy('year');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class)->orderBy('year');
    }

    public function abexes(): HasMany
    {
        return $this->hasMany(Abex::class)->orderBy('year');
    }

    public function cashflows(): HasMany
    {
        return $this->hasMany(Cashflow::class)->orderBy('year');
    }
}
