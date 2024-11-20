<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Plaza</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Buscar Plaza</h1>

    <!-- Campo de entrada para buscar la plaza -->
    <label for="park-search">Buscar Plaza:</label>
    <input type="text" id="park-search" placeholder="Nombre de la plaza">

    <!-- Div para mostrar los resultados de la búsqueda -->
    <div id="results"></div>

    <!-- Botón para guardar en la base de datos, inicialmente oculto -->
    <button id="save-button" style="display: none;" onclick="savePark()">Guardar en base de datos</button>

    <!-- Div para el mapa -->
    <div id="map" style="width: 100%; height: 400px; margin-top: 20px;"></div>

    <!-- Cargar el archivo JavaScript y la API de Google Maps con callback -->
    <script src="{{ asset('js/parkSearch.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.places_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
</body>
</html>
