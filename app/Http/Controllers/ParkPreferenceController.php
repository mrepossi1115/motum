<?php
// app/Http/Controllers/ParkPreferenceController.php

namespace App\Http\Controllers;

use App\Models\Park;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParkPreferenceController extends Controller
{
    public function index()
    {
        // Lista de parques disponibles
        $parks = Park::all();
        return view('trainer.add_park', compact('parks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'park_id' => 'required|exists:parks,id',
        ]);

        $trainerDetail = Auth::user()->trainerDetail;

        // Verificar si el entrenador ya tiene un parque predeterminado
        $hasDefault = $trainerDetail->parks()->wherePivot('is_default', true)->exists();

        // Si no tiene parque predeterminado, el nuevo será el predeterminado
        $trainerDetail->parks()->attach($request->park_id, ['is_default' => !$hasDefault]);

        return redirect()->route('trainer.dashboard')->with('success', 'Parque añadido como preferencia.');
    }

    public function setDefault(Request $request)
    {
        $request->validate([
            'park_id' => 'required|exists:parks,id',
        ]);

        $trainerDetail = Auth::user()->trainerDetail;

        // Desmarcar cualquier parque existente como predeterminado
        $trainerDetail->parks()->updateExistingPivot($trainerDetail->parks()->pluck('park_id'), ['is_default' => false]);

        // Marcar el parque seleccionado como predeterminado
        $trainerDetail->parks()->updateExistingPivot($request->park_id, ['is_default' => true]);

        return redirect()->route('trainer.dashboard')->with('success', 'Parque predeterminado actualizado.');
    }


    public function add()
    {
        return view('trainer.add_park');
    }

    public function storeFromAutocomplete(Request $request)
    {
        $data = $request->validate([
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

        // Asociar el parque con el entrenador
        $trainerDetail = Auth::user()->trainerDetail;
        $trainerDetail->parks()->attach($park->id, ['is_default' => false]);

        return response()->json(['success' => true, 'redirect' => route('trainer.dashboard')]);
    }
}

