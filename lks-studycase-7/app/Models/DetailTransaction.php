<?php

namespace App\Models;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailTransaction extends Model
{
    use HasFactory, Notifiable;
    protected $table = 'detail_transactions';
    protected $casts = [
        "roti" => "array"
    ];
    protected $fillable = [
        'name',
        'qty',
        'price',
        'transaction_id',
        'customer_id',
        'roti_id',
        'subtotal',
    ];
    /**
     * Get the user that owns the DetailTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    /**
     * Get the transaction associated with the DetailTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * Get the roti that owns the DetailTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roti(): BelongsTo
    {
        return $this->belongsTo(Roti::class, 'roti_id');
    }
}
