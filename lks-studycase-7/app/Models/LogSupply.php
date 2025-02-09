<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogSupply extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'gasdang_id',
        'supplier_id',
        'bahan_id',
        'qty',
        'received_at',
    ];
    /**
     * Get the gasdang that owns the LogSupply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gasdang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gasdang_id');
    }
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }
    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}
