<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Entrenador</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Registro de Entrenador</h1>

    <form id="trainer-form">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Correo Electrónico:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Confirmar Contraseña:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <label for="certification">Certificación:</label>
        <input type="text" id="certification" name="certification">

        <label for="biography">Biografía:</label>
        <textarea id="biography" name="biography"></textarea>

        <!-- Campo de búsqueda de parque -->
        <label for="park-search">Buscar Parque:</label>
        <input type="text" id="park-search" placeholder="Nombre del parque">

        <!-- Mapa para mostrar el parque seleccionado -->
        <div id="map" style="width: 100%; height: 400px; margin-top: 20px;"></div>

        <button type="button" onclick="saveTrainer(event)">Guardar Entrenador</button>
    </form>

    <script src="{{ asset('js/registerTrainer.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.places_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
</body>
</html>
