<?php

namespace App\Models;

use App\Models\User;
use App\Models\Society;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consultation extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'status',
        'disease_history',
        'current_symptoms',
        'doctor_notes',
        'society_id',
        'doctor_id',
    ];
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}