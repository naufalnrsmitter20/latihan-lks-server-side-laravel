<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prakerin extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'industry_name',
        'industry_desc',
        'user_id',
        'status',
        'industry_id',
        'prakerin_period_id',
    ];
    /**
     * Get all of the comments for the Prakerin
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): BelongsTo
    {
        return $this->BelongsTo(User::class, "user_id");
    }
    public function prakerin_periods(): BelongsTo
    {
        return $this->belongsTo(PrakerinPeriod::class, "prakerin_period_id");
    }
    
    public function industries(): BelongsTo
    {
        return $this->belongsTo(Industry::class, 'industry_id');
    }
    
}