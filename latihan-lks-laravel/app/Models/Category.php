<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "category_name",
        "slug"
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, foreignKey: "category_id");
    }
}