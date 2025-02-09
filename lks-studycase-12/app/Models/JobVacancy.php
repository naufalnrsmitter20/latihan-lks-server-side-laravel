<?php

namespace App\Models;

use App\Models\JobApplyPosition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobVacancy extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'job_category_id',
        'company',
        'address',
        'description',
    ];
    public function job_apply_positions(): HasMany
    {
        return $this->hasMany(JobApplyPosition::class);
    }
    /**
     * Get all of the available_positions for the JobVacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function available_positions(): HasMany
    {
        return $this->hasMany(AvailablePosition::class);
    }
    /**
     * Get the job_category that owns the JobVacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    /**
     * Get all of the job_apply_societies for the JobVacancy
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_apply_societies(): HasMany
    {
        return $this->hasMany(JobApplySociety::class);
    }
}
