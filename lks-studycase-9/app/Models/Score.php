<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'player_id',
        'game_id',
        "score",

    ];

    public $timestamps = true;
    /**
     * Get the game that owns the Score
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    /**
     * Get the user that owns the Score
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}
