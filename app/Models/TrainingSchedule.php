<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;
    protected $table = 'training_schedules';

    protected $fillable = [
        'training_id',
        'day_of_week',
        'time',
    ];

    /**
     * Relación de muchos a uno con entrenamiento.
     */
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
