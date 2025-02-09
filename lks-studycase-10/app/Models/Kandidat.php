<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kandidat extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_kandidat',
        'no_urut',
        'image',
        'role',
        'partai_id',
        'vote_id',
    ];
    /**
     * Get the vote that owns the Kandidat
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vote(): BelongsTo
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }
    /**
     * Get all of the partais for the Kandidat
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partai(): BelongsTo
    {
        return $this->BelongsTo(Partai::class);
    }
    public function userVote(): HasMany
    {
        return $this->hasMany(UserVote::class);
    }
}