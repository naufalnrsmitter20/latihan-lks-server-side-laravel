<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Medical extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'role',
        'name',
        'user_id',
        'spot_id',
    ];
    /**
     * Get the user that owns the Medical
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the spot that owns the Medical
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class, 'spot_id');
    }
}