<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vote extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kota_id',
        'provinsi_id',
        'votetype_id',
        'tipe_pemilihan',
        'min_age',
        'status',
        'start_date',
        'end_date',
    ];
    /**
     * Get all of the kandidats for the Vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kandidats(): HasMany
    {
        return $this->hasMany(Kandidat::class);
    }
    /**
     * Get the kota that owns the Vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'kota_id');
    }
    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }
    /**
     * Get the votetype that owns the Vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function votetype(): BelongsTo
    {
        return $this->belongsTo(Votetype::class, 'votetype_id');
    }
    public function userVote(): HasMany
    {
        return $this->hasMany(UserVote::class);
    }
    /**
     * Get all of the partais for the Vote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function partais(): HasMany
    {
        return $this->hasMany(Partai::class);
    }
}
