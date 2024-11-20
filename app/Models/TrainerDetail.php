<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class TrainerDetail extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'user_id', 
        'certification', 
        'biography', 
    ];
    

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function parks()
    {
        return $this->belongsToMany(Park::class, 'trainers_have_parks')
                    ->withPivot('is_default')
                    ->withTimestamps();
    }

    // Método para obtener el parque predeterminado
    public function defaultPark()
    {
        return $this->parks()->wherePivot('is_default', true)->first();
    }

}



