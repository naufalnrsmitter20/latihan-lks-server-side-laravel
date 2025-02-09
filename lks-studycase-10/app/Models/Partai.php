<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partai extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_partai',
        'logo',
        'no_urut',
        "kandidat_id",
        "vote_id"
    ];
    /**
     * Get all of the kandidats for the Partai
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kandidats(): HasMany
    {
        return $this->hasMany(Kandidat::class);
    }
    /**
     * Get the vote that owns the Partai
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }
}
