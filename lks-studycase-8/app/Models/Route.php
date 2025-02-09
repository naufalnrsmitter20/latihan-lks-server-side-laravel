<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        "from_place_id",
        "to_place_id"
    ];
    public function schedules(): BelongsToMany
    {
        return $this->belongsToMany(Schedule::class, 'schedule_route')->withTimestamps();
    }

    public function from_place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'from_place_id');
    }
    public function to_place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'to_place_id');
    }
}
