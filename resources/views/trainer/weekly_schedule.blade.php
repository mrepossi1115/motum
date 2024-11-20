<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Semanal</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        .week-navigation { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .day-column { width: 14%; display: inline-block; vertical-align: top; background: #fff; padding: 10px; border-radius: 5px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        .day-column h3 { font-size: 16px; color: #555; }
        .class { background-color: #e6f7ff; padding: 10px; margin-bottom: 10px; border-radius: 5px; cursor: pointer; }
        .class:hover { background-color: #cceeff; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calendario Semanal de Clases</h1>

        <!-- Navegación de la semana -->
        <div class="week-navigation">
            <a href="{{ route('trainer.weekly_schedule', ['week' => $startOfWeek->copy()->subWeek()->format('Y-m-d')]) }}">Semana Anterior</a>
            <span>{{ $startOfWeek->format('d M Y') }} - {{ $startOfWeek->copy()->endOfWeek()->format('d M Y') }}</span>
            <a href="{{ route('trainer.weekly_schedule', ['week' => $startOfWeek->copy()->addWeek()->format('Y-m-d')]) }}">Semana Siguiente</a>
        </div>

        <!-- Mostrar cada día de la semana y sus clases -->
        <div style="display: flex; justify-content: space-between;">
            @foreach($weekDates as $date)
                <div class="day-column">
                    <h3>{{ $date->translatedFormat('l, d M') }}</h3>

                    @php
                        $dayOfWeek = $date->translatedFormat('l'); // Nombre del día de la semana
                    @endphp

                    <!-- Verificar si hay clases programadas para este día de la semana -->
                    @if(isset($groupedTrainings[$dayOfWeek]))
                        <!-- Recorremos los horarios de cada día -->
                        @foreach($groupedTrainings[$dayOfWeek] as $time => $trainings)
                            @foreach($trainings as $training)
                                <div class="class" onclick="showClassDetails('{{ $training->id }}')">
                                    <strong>{{ $training->name }}</strong><br>
                                    {{ $time }}<br>
                                    Actividad: {{ $training->activity->name_activity ?? 'Sin actividad' }}<br>
                                    Nivel: {{ ucfirst($training->level) }}
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <p>No hay clases programadas</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function showClassDetails(trainingId) {
            // Aquí puedes implementar una ventana modal o redirección a los detalles de la clase
            alert("Detalles de la clase: " + trainingId);
        }
    </script>
</body>
</html>

</html>
