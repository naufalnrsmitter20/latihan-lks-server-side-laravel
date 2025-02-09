<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Validator extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'role',
        'name',
    ];
    /**
     * Get the user that owns the Validator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the validation that owns the Validator
     *
     * @return \Illuminate\Database\Eloquent\Relations\Hasmany
     */
    public function validations(): HasMany
    {
        return $this->hasMany(Validation::class);
    }
}
