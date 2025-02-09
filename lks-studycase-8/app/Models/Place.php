<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'image_path',
        'description',
    ];

    /**
     * Get all of the schedules for the Place
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }
}
