<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'activity_id';
    protected $fillable = [
        'name_activity',    
        'description_park',
    ];

    public function trainings()
    {
        return $this->hasMany(Training::class, 'activity_id', 'activity_id');
    }

}

