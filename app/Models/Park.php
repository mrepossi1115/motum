<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'opening_hours',
    ];

    public function trainerDetails()
    {
        return $this->belongsToMany(TrainerDetail::class, 'trainers_have_parks')
                    ->withPivot('is_default')
                    ->withTimestamps();
    }
    public function trainings()
    {
        return $this->hasMany(Training::class, 'park_id');
    }
}
