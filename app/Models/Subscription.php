<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_id',
        'frequency',
        'price',
    ];

    /**
     * Relación de muchos a uno con entrenamiento.
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
