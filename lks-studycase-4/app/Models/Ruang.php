<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruang extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_ruang',
    ];

    /**
     * Get the user that owns the Ruang
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /**
     * Get all of the comments for the Ruang
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(Verification::class, "ruang_id");
    }
}
