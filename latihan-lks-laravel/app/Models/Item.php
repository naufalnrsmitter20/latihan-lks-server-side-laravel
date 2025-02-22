<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "slug",
        "item_number",
        "desc"
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}