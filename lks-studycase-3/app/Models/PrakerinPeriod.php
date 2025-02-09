<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrakerinPeriod extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'year_period_id',
        'period_status',
    ];
    /**
     * Get all of the comments for the PrakerinPeriod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class);
    }
    /**
     * Get the yearPeriod that owns the PrakerinPeriod
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function yearPeriod(): BelongsTo
    {
        return $this->belongsTo(YearPeriod::class, 'year_period_id');
    }
}