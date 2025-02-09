<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Society extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'id_card_number',
        'password',
        'name',
        'born_date',
        'gender',
        'address',
        'regional_id',
        'login_tokens',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * Get all of the validations for the Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function validations(): HasMany
    {
        return $this->hasMany(Validation::class);
    }
    /**
     * Get the regional that owns the Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }
    /**
     * Get all of the job_apply_societies for the Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_apply_societies(): HasMany
    {
        return $this->hasMany(JobApplySociety::class);
    }
    /**
     * Get all of the job_apply_positions for the Society
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_apply_positions(): HasMany
    {
        return $this->hasMany(JobApplyPosition::class);
    }
}
