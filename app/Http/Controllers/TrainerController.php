<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TrainerDetail;
use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainerController extends Controller
{
    public function create()
    {
        return view('auth.register_trainer');
    }

    public function dashboard()
{
    $user = Auth::user()->load('trainerDetail.parks.trainings.schedules', 'trainerDetail.parks.trainings.activity');

    // Crear un array para almacenar los entrenamientos agrupados por día de la semana y horario
    $groupedTrainings = [];

    foreach ($user->trainerDetail->parks as $park) {
        foreach ($park->trainings as $training) {
            foreach ($training->schedules as $schedule) {
                // Agrupación por día y hora
                $dayOfWeek = $schedule->day_of_week;
                $time = $schedule->time;

                // Inicializar la agrupación si no existe para el día y la hora
                if (!isset($groupedTrainings[$park->id][$dayOfWeek])) {
                    $groupedTrainings[$park->id][$dayOfWeek] = [];
                }
                
                // Agregar entrenamiento al horario correspondiente
                $groupedTrainings[$park->id][$dayOfWeek][$time][] = $training;
            }
        }
    }

    return view('trainer.dashboard', compact('user', 'groupedTrainings'));
}


  
    
  public function saveTrainer(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
                'certification' => 'nullable|string',
                'biography' => 'nullable|string',
                'park.name' => 'required|string',
                'park.location' => 'required|string',
                'park.latitude' => 'required|numeric',
                'park.longitude' => 'required|numeric',
                'park.opening_hours' => 'nullable|array',
            ]);

            // Crear o encontrar el parque
            $latitude = round($data['park']['latitude'], 6);
            $longitude = round($data['park']['longitude'], 6);

            $park = Park::firstOrCreate(
                [
                    'name' => $data['park']['name'],
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ],
                [
                    'location' => $data['park']['location'],
                    'opening_hours' => isset($data['park']['opening_hours']) ? json_encode($data['park']['opening_hours']) : null,
                ]
            );

            // Crear el usuario
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'entrenador',
            ]);

            // Crear los detalles del entrenador
            $trainerDetail = TrainerDetail::create([
                'user_id' => $user->id,
                'certification' => $data['certification'],
                'biography' => $data['biography'],
            ]);

            // Asociar el parque como parque predeterminado
            $trainerDetail->parks()->attach($park->id, ['is_default' => true]);

            // Autenticar y redirigir al dashboard
            Auth::login($user);

            return response()->json(['redirect' => route('trainer.dashboard')]);
        } catch (\Exception $e) {
            Log::error('Error al registrar el entrenador: ' . $e->getMessage());
            return response()->json(['error' => 'Ocurrió un error al registrar el entrenador.'], 500);
        }
    }
    public function getParkDetails(Park $park)
{
    // Obtener los detalles del parque seleccionado
    $parkDetails = [
        'name' => $park->name,
        'location' => $park->location,
        'opening_hours' => $park->opening_hours ? json_decode($park->opening_hours) : null,
    ];

    return response()->json($parkDetails);
}
public function weeklySchedule(Request $request)
{
    // Obtener la semana seleccionada o la semana actual
    $startOfWeek = $request->has('week') ? Carbon::parse($request->week) : Carbon::now()->startOfWeek();

    // Fechas de lunes a domingo para la semana actual
    $weekDates = [];
    for ($i = 0; $i < 7; $i++) {
        $weekDates[] = $startOfWeek->copy()->addDays($i);
    }

    // Cargar el usuario y sus entrenamientos con horarios y actividades
    $user = Auth::user()->load('trainerDetail.parks.trainings.schedules', 'trainerDetail.parks.trainings.activity');

    // Agrupar entrenamientos por día y hora
    $groupedTrainings = [];
    foreach ($user->trainerDetail->parks as $park) {
        foreach ($park->trainings as $training) {
            foreach ($training->schedules as $schedule) {
                $dayOfWeek = $schedule->day_of_week;
                $time = $schedule->time;

                if (!isset($groupedTrainings[$dayOfWeek])) {
                    $groupedTrainings[$dayOfWeek] = [];
                }

                $groupedTrainings[$dayOfWeek][$time][] = $training;
            }
        }
    }

    return view('trainer.weekly_schedule', compact('weekDates', 'groupedTrainings', 'user', 'startOfWeek'));
}
}