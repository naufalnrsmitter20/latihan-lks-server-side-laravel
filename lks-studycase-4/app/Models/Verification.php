<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Verification extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama_kegiatan',
        'start_at',
        'end_at',
        'status',
        'ruang_id',
        'siswa_id',
        'admin_id',
    ];

    /**
     * Get the user that owns the Verification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
