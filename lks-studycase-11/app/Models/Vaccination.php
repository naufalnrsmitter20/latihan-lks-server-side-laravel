<?php

namespace App\Models;

use App\Models\Spot;
use App\Models\User;
use App\Models\Society;
use App\Models\Vaccine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaccination extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'dose',
        'date',
        'society_id',
        'spot_id',
        'vaccine_id',
        'doctor_id',
        'officer_id',
    ];
    /**
     * Get the society that owns the Vaccination
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    public function spot(): BelongsTo
    {
        return $this->belongsTo(Spot::class, 'spot_id');
    }
    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class, 'vaccine_id');
    }
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
    public function officer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}