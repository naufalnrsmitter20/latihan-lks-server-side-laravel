<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'title',
        "description",
        "slug",
        "author",
        "scoreCount",
    ];
    /**
     * Get the user that owns the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get all of the versions for the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function versions(): HasMany
    {
        return $this->hasMany(Version::class);
    }
    /**
     * Get all of the scores for the Game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }
}
