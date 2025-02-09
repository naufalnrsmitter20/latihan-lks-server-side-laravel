<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kota extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_kota',
        'provinsi_id',
    ];
    /**
     * Get the vote associated with the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }
    /**
     * Get all of the users for the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biodatas(): HasMany
    {
        return $this->hasMany(Biodata::class);
    }
    /**
     * Get the provinsi that owns the Kota
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provinsi_id');
    }
}
