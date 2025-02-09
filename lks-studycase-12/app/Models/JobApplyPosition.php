<?php

namespace App\Models;

use App\Models\Society;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplyPosition extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'date',
        'society_id',
        'job_vacancy_id',
        'available_position_id',
        'job_apply_society_id',
        'status',
    ];
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    /**
     * Get the job_apply_society that owns the JobApplyPosition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_apply_society(): BelongsTo
    {
        return $this->belongsTo(JobApplySociety::class, 'job_apply_society_id');
    }
    /**
     * Get the available_position that owns the JobApplyPosition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function available_position(): BelongsTo
    {
        return $this->belongsTo(AvailablePosition::class, 'available_position_id');
    }
    /**
     * Get the job_vacancy that owns the JobApplyPosition
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_vacancy(): BelongsTo
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
