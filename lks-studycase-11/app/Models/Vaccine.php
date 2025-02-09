<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vaccine extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
    ];
    /**
     * The spots that belong to the Vaccine
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function spots(): BelongsToMany
    {
        return $this->belongsToMany(Spot::class)->withTimestamps();
    }
    /**
     * Get all of the vaccinations for the Vaccine
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class,);
    }
}