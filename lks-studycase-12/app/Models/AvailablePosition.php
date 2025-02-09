<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailablePosition extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'job_vacancy_id',
        'position',
        'capacity',
        'apply_capacity',
    ];
    /**
     * Get all of the job_apply_positions for the AvailablePosition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_apply_positions(): HasMany
    {
        return $this->hasMany(JobApplyPosition::class);
    }
    /**
     * Get the job_vacancy that owns the AvailablePosition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
