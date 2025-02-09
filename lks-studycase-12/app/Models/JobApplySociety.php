<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplySociety extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'notes',
        'date',
        'society_id',
        'job_vacancy_id',
    ];
    /**
     * Get the society that owns the JobApplySociety
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    /**
     * Get all of the job_apply_positions for the JobApplySociety
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_apply_positions(): HasMany
    {
        return $this->hasMany(JobApplyPosition::class);
    }
    /**
     * Get the job_vacancy that owns the JobApplySociety
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
