<?php

namespace App\Models;

use App\Models\Chart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QtyTelur extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'telur_id',
        'qty',
        'total_price',
    ];
    /**
     * Get the telur that owns the QTYTelur
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function telur(): BelongsTo
    {
        return $this->belongsTo(Telur::class, 'telur_id');
    }
    public function charts(): HasMany
    {
        return $this->hasMany(Chart::class);
    }
}
