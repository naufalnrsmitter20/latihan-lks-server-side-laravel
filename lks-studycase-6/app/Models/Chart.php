<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chart extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'qty_telur_id',
        'qty_kemasan_id',
        'transaction_id',
        'total_amount',
        'user_id',
    ];

    /**
     * Get the qty_telur that owns the Chart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qty_telur(): BelongsTo
    {
        return $this->belongsTo(QtyTelur::class, 'qty_telur_id');
    }
    public function qty_kemasan(): BelongsTo
    {
        return $this->belongsTo(QtyKemasan::class, 'qty_kemasan_id');
    }

    /**
     * The transaction that belong to the Chart
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'chart_transaction', 'transaction_id', 'chart_id')->withPivot(["total_amount"])->withTimestamps();
    }
}
