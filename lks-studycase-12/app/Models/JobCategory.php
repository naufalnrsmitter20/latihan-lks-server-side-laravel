<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobCategory extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'job_category',
    ];
    /**
     * Get all of the validations for the JobCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function validations(): HasMany
    {
        return $this->hasMany(Validation::class);
    }
    /**
     * Get all of the job_vacancies for the JobCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function job_vacancies(): HasMany
    {
        return $this->hasMany(JobVacancy::class);
    }
}
