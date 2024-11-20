<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TrainerDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function showTrainerRegister()
    {
        $parks = \App\Models\Park::all(); // Listado de parques
        return view('auth.register_trainer', compact('parks'));
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'entrenador') {
                return redirect()->route('trainer.dashboard'); // Dashboard para entrenadores
            }
            return redirect()->route('student.dashboard'); // Dashboard para alumnos
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'alumno',
        ]);

        Auth::login($user);
        return redirect()->route('student.dashboard');
    }

    public function registerTrainer(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'certification' => 'nullable|string',
            'biography' => 'nullable|string',
            'park_id' => 'nullable|exists:parks,id',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'entrenador',
        ]);

        TrainerDetail::create([
            'user_id' => $user->id,
            'certification' => $data['certification'],
            'biography' => $data['biography'],
            'park_id' => $data['park_id'],
        ]);

        Auth::login($user);
        return redirect()->route('trainer.dashboard');
    }
}
