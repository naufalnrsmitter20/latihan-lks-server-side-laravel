<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QtyKemasan extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'kemasan_id',
        'qty',
        'total_price',
    ];
    public function kemasan(): BelongsTo
    {
        return $this->belongsTo(Kemasan::class, 'kemasan_id');
    }
    /**
     * Get all of the charts for the QTYKemasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class);
    }
}
