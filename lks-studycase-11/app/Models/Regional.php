<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regional extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'province',
        'district',
    ];
    /**
     * Get all of the spots for the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function spots(): HasMany
    {
        return $this->hasMany(Spot::class);
    }
    /**
     * Get all of the societies for the Regional
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function societies(): HasMany
    {
        return $this->hasMany(Society::class);
    }
}