<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'park_id',
        'trainer_id',
        'activity_id',
        'description',
        

    ];

    /**
     * Relación de uno a muchos con los horarios de entrenamiento.
     */
    public function schedules()
    {
        return $this->hasMany(TrainingSchedule::class);
    }

    /**
     * Relación de uno a muchos con los abonos.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Relación de muchos a uno con parques.
     */
    public function park()
    {
        return $this->belongsTo(Park::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'activity_id');
    }

}
