<!-- resources/views/trainer/add_park.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Parque de Preferencia</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #333; }
        .section { background: #fff; padding: 20px; margin: 10px 0; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        #map { width: 100%; height: 400px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Parque de Preferencia</h1>

        <form id="add-park-form">
            @csrf <!-- Token CSRF -->

            <!-- Campo de búsqueda de parque con autocomplete -->
            <label for="park-search">Buscar Parque:</label>
            <input type="text" id="park-search" placeholder="Nombre del parque" required>

            <!-- Mapa para mostrar el parque seleccionado -->
            <div id="map"></div>

            <button type="button" onclick="savePark(event)">Agregar Parque</button>
        </form>
    </div>

    <script src="{{ asset('js/addPark.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.places_api_key') }}&libraries=places&callback=initAutocomplete" async defer></script>
</body>
</html>
