<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Votetype extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
    ];
    /**
     * Get the vote associated with the VoteType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vote(): HasOne
    {
        return $this->hasOne(Vote::class);
    }
}
