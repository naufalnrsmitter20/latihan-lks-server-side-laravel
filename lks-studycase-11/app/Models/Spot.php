<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Spot extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'address',
        'serve',
        'capacity',
        'regional_id',
    ];
    /**
     * The vaccines that belong to the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vaccines(): BelongsToMany
    {
        return $this->belongsToMany(Vaccine::class)->withTimestamps();
    }
    /**
     * Get all of the medicals for the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicals(): HasMany
    {
        return $this->hasMany(Medical::class,);
    }
    /**
     * Get all of the vaccinations for the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class);
    }
    /**
     * Get the regional that owns the Spot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }
}