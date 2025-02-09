<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Industry extends Model
{
    protected $fillable = [
        "industry_name",
        "industry_desc",
        "teacher_id"
    ];
    /**
     * Get all of the comments for the Industry
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prakerins(): HasMany
    {
        return $this->hasMany(Prakerin::class);
    }
    public function teachers(): BelongsTo
    {
        return $this->BelongsTo(User::class, "teacher_id");
    }
}