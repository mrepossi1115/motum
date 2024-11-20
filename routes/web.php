<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParkPreferenceController;
// routes/web.php
Route::get('/', function () {
    // Ruta inicial donde se muestra la opción de elegir entre iniciar sesión o registrarse
    return view('auth.welcome');
})->name('welcome');

// Ruta para la vista de inicio de sesión
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Ruta para procesar el inicio de sesión
Route::post('/login', [AuthController::class, 'login']);

// Ruta para la vista de registro de alumnos
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Ruta para procesar el registro de alumnos
Route::post('/register', [AuthController::class, 'register']);

// Ruta para la vista de registro de entrenadores
Route::get('/register/trainer', [AuthController::class, 'showTrainerRegister'])->name('registerTrainer');
// Ruta para procesar el registro de entrenadores
Route::post('/register/trainer', [AuthController::class, 'registerTrainer']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/alumno', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

Route::get('/dashboard/entrenador', [TrainerController::class, 'dashboard'])->name('trainer.dashboard');
//Ruta oara guardar el entrenador con la plaza
Route::post('/save-trainer', [TrainerController::class, 'saveTrainer'])->name('save.trainer');


Route::middleware('auth')->group(function () {
    Route::get('/trainer/training/create', [TrainingController::class, 'create'])->name('trainings.create');
    Route::post('/trainer/training/guardar', [TrainingController::class, 'saveTraining'])->name('training.store');
});


Route::get('/trainer/parks', [ParkPreferenceController::class, 'index'])->name('trainer.parks.index');
Route::post('/trainer/parks', [ParkPreferenceController::class, 'store'])->name('trainer.parks.store');
Route::post('/trainer/parks/setDefault', [ParkPreferenceController::class, 'setDefault'])->name('trainer.parks.setDefault');

Route::get('/trainer/add-park', [ParkPreferenceController::class, 'add'])->name('trainer.add_park');
Route::post('/trainer/add-park', [ParkPreferenceController::class, 'storeFromAutocomplete'])->name('trainer.add_park.store');

Route::get('/trainer/park-details/{park}', [TrainerController::class, 'getParkDetails'])->name('trainer.park_details');

Route::get('/calendario', [TrainerController::class, 'weeklySchedule'])->name('trainer.weekly_schedule');
