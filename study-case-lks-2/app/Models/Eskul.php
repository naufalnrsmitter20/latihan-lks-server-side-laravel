<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Eskul extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'name',
        'desc',
        'status',
        "user",
    ];

    /**
     * Get the user that owns the Eskul
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "users_eskuls")->withTimestamps();
    }

}