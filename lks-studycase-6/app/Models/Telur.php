<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Telur extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'stock',
        'price',
    ];
    public function qtytelurs(): HasMany
    {
        return $this->hasMany(QTYTelur::class);
    }
}
