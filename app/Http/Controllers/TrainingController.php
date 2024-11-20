<?php
namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TrainingController extends Controller
{
    public function create()
    {
        $activities = Activity::all();
        return view('trainings.create', compact('activities'));
    }

    public function saveTraining(Request $request)
    {
        try {
            // Validación de los datos
            $data = $request->validate([
                'name' => 'required|string',
                'description' => 'nullable|string',
                'activity_id' => 'required|exists:activities,activity_id',
                'level' => 'required|in:básico,intermedio,avanzado',
                'day_of_week' => 'required|array',
                'day_of_week.*' => 'required|string',
                'time' => 'required|array',
                'time.*' => 'required|string',
                'frequency' => 'required|array',
                'frequency.*' => 'required|string',
                'subscription_price' => 'required|array',
                'subscription_price.*' => 'required|numeric',
            ]);

            // Obtener el entrenador autenticado y el parque de referencia predeterminado
            $trainer = Auth::user();
            $defaultPark = $trainer->trainerDetail->parks()->wherePivot('is_default', true)->first();

            if (!$defaultPark) {
                return back()->withErrors(['error' => 'No tienes un parque de referencia configurado.']);
            }

            // Crear el entrenamiento asociado al parque y al entrenador
            $training = Training::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'trainer_id' => $trainer->id,
                'park_id' => $defaultPark->id,
                'activity_id' => $data['activity_id'],
                'level' => $data['level'],
            ]);

            // Guardar los horarios y abonos
            foreach ($data['day_of_week'] as $index => $dayOfWeek) {
                $time = $data['time'][$index];
                $training->schedules()->create([
                    'day_of_week' => $dayOfWeek,
                    'time' => $time,
                ]);
            }

            foreach ($data['frequency'] as $index => $frequency) {
                $price = $data['subscription_price'][$index];
                $training->subscriptions()->create([
                    'frequency' => $frequency,
                    'price' => $price,
                ]);
            }

            return redirect()->route('trainer.dashboard')->with('success', 'Entrenamiento creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar entrenamiento: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al guardar el entrenamiento.']);
        }
    }
}
