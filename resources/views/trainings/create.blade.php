<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Entrenamiento</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
</head>
<body>
    <h1>Crear Entrenamiento</h1>
    
    <!-- Formulario de entrenamiento -->
    <form id="training-form" action="{{ route('training.store') }}" method="POST">
    @csrf 
        <label for="name">Nombre del Entrenamiento:</label>
        <input type="text" id="name" name="name" required>

        <label for="activity">Tipo de Actividad:</label>
    <select id="activity" name="activity_id" required>
        <option value="">Selecciona una actividad</option>
        @foreach($activities as $activity)
            <option value="{{ $activity->activity_id }}">{{ $activity->name_activity }}</option>
        @endforeach
    </select>
    <label for="level">Nivel:</label>
    <select id="level" name="level" required>
        <option value="básico">Básico</option>
        <option value="intermedio">Intermedio</option>
        <option value="avanzado">Avanzado</option>
    </select>

        <label for="description">Descripción:</label>
        <textarea id="description" name="description"></textarea>

        <!-- Contenedor para horarios dinámicos -->
        <div id="schedules-container">
            <h3>Horarios</h3>
            <button type="button" onclick="addSchedule()">Agregar horario</button>
        </div>

        <!-- Contenedor para abonos dinámicos -->
        <div id="subscriptions-container">
            <h3>Abonos</h3>
            <button type="button" onclick="addSubscription()">Agregar abono</button>
        </div>

        <!-- Botón para enviar el formulario -->
        <button type="submit">Crear Entrenamiento</button>

    </form>

    
    <script src="{{ asset('js/priceButton.js') }}"></script>
    <script src="{{ asset('js/scheduleButton.js') }}"></script>
    
</body>
</html>
