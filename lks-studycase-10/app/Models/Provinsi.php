<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provinsi extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_provinsi',
    ];
    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }
    public function biodatas(): HasMany
    {
        return $this->hasMany(Biodata::class);
    }
    /**
     * Get all of the provinsis for the Provinsi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kotas(): HasMany
    {
        return $this->hasMany(Kota::class);
    }
}
