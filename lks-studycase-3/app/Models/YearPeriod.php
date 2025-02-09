<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class YearPeriod extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'year',
        'max_period',
    ];

    /**
     * Get all of the prakerinPeriod for the YearPeriod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prakerin_periods(): HasMany
    {
        return $this->hasMany(PrakerinPeriod::class);
    }
}