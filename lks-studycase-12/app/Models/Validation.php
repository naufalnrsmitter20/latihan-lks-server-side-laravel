<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Validation extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'society_id',
        'validator_id',
        'job_category_id',
        'status',
        'work_experience',
        'job_position',
        'reason_accepted',
        'validator_notes',
    ];
    /**
     * Get the validator that owns the Validation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator(): BelongsTo
    {
        return $this->belongsTo(validator::class, 'validator_id');
    }
    /**
     * Get the job_category that owns the Validation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function job_category(): BelongsTo
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    /**
     * Get the society that owns the Validation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function society(): BelongsTo
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
}
