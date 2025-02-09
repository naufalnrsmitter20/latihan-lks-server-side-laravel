<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'type',
        'line',
        'from_place_id',
        'to_place_id',
        'travel_time',
        'departure_time',
        'arrival_time',
        'distance',
        'speed',
    ];

    /**
     * Get the from_place that owns the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'from_place_id');
    }
    public function to_place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'to_place_id');
    }
    /**
     * The places that belong to the Schedule
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'schedule_route')->withTimestamps();
    }
}
