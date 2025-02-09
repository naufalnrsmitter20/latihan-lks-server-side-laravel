<?php

namespace App\Models;

use App\Models\User;
use App\Models\Bahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogUsage extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'gasdang_id',
        'bahan_id',
        'qty',
        'usage_at',
    ];
    public function bahan(): BelongsTo
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
    public function gasdang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'gasdang_id');
    }
}
