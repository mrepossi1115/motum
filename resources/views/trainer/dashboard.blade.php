<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Entrenador</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        .section { background: #fff; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .section h2 { color: #555; }
        .info { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenido, {{ Auth::user()->name }}</h1>

        <!-- Información del entrenador -->
        <div class="section">
            <h2>Información del Entrenador</h2>
            <p class="info"><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p class="info"><strong>Certificación:</strong> {{ Auth::user()->trainerDetail->certification ?? 'No especificada' }}</p>
            <p class="info"><strong>Biografía:</strong> {{ Auth::user()->trainerDetail->biography ?? 'No especificada' }}</p>
        </div>

        <!-- Selección y detalles del parque -->
        <div class="section">
            <h2>Parques Preferidos</h2>

            <label for="park-select">Selecciona tu parque preferido:</label>
            <select id="park-select" onchange="showParkDetails()">
                @foreach($user->trainerDetail->parks as $park)
                    <option value="{{ $park->id }}" {{ $park->pivot->is_default ? 'selected' : '' }}>
                        {{ $park->name }}
                    </option>
                @endforeach
            </select>
            <a href="{{ route('trainer.add_park') }}">Agregar Nuevo Parque de Preferencia</a>

            <!-- Mostrar los detalles de cada parque y sus entrenamientos, inicialmente ocultos -->
            @foreach($user->trainerDetail->parks as $park)
                <div id="park-details-{{ $park->id }}" class="park-details" style="display: {{ $park->pivot->is_default ? 'block' : 'none' }}">
                    <h3>Detalles del Parque</h3>
                    <p><strong>Nombre:</strong> {{ $park->name }}</p>
                    <p><strong>Ubicación:</strong> {{ $park->location }}</p>
                    @if($park->opening_hours)
                        <p><strong>Horarios de Apertura:</strong></p>
                        <ul>
                            @foreach(json_decode($park->opening_hours) as $dayHours)
                                <li>{{ $dayHours }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Horarios de apertura no especificados.</p>
                    @endif
                </div>

                <!-- Lista de entrenamientos asociados a cada parque -->
                <div id="training-list-{{ $park->id }}" class="training-list" style="display: {{ $park->pivot->is_default ? 'block' : 'none' }}">
                    <h3>Entrenamientos en este Parque</h3>
                    <a href="{{ route('trainings.create') }}">Agregar Entrenamiento</a>
                    <ul>
                        @forelse($park->trainings as $training)
                            <li>
                                <strong>{{ $training->name }}</strong><br>
                                Actividad: {{ $training->activity->name_activity ?? 'Sin actividad' }}<br>
                                Nivel: {{ ucfirst($training->level) }}<br>
                                Descripción: {{ $training->description ?? 'Sin descripción' }}
                            </li>
                        @empty
                            <li>No hay entrenamientos en este parque.</li>
                        @endforelse
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function showParkDetails() {
            const selectedParkId = document.getElementById("park-select").value;

            // Ocultar todos los detalles de parques y entrenamientos
            document.querySelectorAll(".park-details, .training-list").forEach(section => {
                section.style.display = "none";
            });

            // Mostrar solo los detalles del parque y entrenamientos seleccionados
            document.getElementById("park-details-" + selectedParkId).style.display = "block";
            document.getElementById("training-list-" + selectedParkId).style.display = "block";
        }
    </script>
</body>
</html>