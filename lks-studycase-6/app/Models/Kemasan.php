<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kemasan extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'stock',
        'price',
    ];
    /**
     * Get all of the comments for the Kemasan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qtykemasans(): HasMany
    {
        return $this->hasMany(QTYKemasan::class);
    }
}
