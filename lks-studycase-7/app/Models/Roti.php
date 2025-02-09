<?php

namespace App\Models;

use App\Models\Bahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Roti extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'qty',
        'price',
    ];
    public function bahans(): BelongsToMany
    {
        return $this->belongsToMany(Bahan::class, 'bahan_roti', 'roti_id', 'bahan_id')
            ->withTimestamps()
            ->withPivot("quantity_used");
    }
}
