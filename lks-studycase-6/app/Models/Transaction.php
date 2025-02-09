<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'cashier_id',
        'transaction_date',
        'total_final_amount',
        'chart_id',
    ];
    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cashier_id');
    }
    public function charts(): BelongsToMany
    {
        return $this->belongsToMany(Chart::class, 'chart_transaction', 'transaction_id', 'chart_id')->withTimestamps();
    }
}
