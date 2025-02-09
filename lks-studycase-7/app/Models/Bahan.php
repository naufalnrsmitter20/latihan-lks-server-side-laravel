<?php

namespace App\Models;

use App\Models\Roti;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bahan extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'qty',
        'price',
    ];
    /**
     * The rotis that belong to the Bahan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rotis(): BelongsToMany
    {
        return $this->belongsToMany(Roti::class, 'bahan_roti', 'roti_id', 'bahan_id')
            ->withTimestamps()
            ->withPivot("quantity_used");
    }
}
