<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:trainers',
            'password' => 'required|string|min:8|confirmed',
            'certification' => 'nullable|string|max:255',
            'biography' => 'nullable|string',
            'park_name' => 'required|string|max:255',
            'park_location' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'opening_hours' => 'nullable|string',
        ]);

        // Buscar o crear el parque preferido
        $park = Park::firstOrCreate(
            [
                'name' => $request->input('park_name'),
                'location' => $request->input('park_location'),
                'latitude' => round($request->input('latitude'), 6),
                'longitude' => round($request->input('longitude'), 6),
            ],
            [
                'opening_hours' => $request->input('opening_hours'),
            ]
        );

        // Registrar al entrenador y vincularlo con el parque preferido
        $trainer = Trainer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'certification' => $request->certification,
            'biography' => $request->biography,
            'preferred_park_id' => $park->id,
        ]);

        auth()->login($trainer); // Iniciar sesión automáticamente

        return redirect()->route('trainer.dashboard');
    }
}
