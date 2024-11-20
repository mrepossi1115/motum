let autocomplete;
let map;
let marker;
let selectedPlaceId = null;
let selectedParkData = {}; // Objeto para almacenar los datos del parque

function initAutocomplete() {
    const input = document.getElementById("park-search");

    // Configura el autocompletado
    autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['establishment'],
        componentRestrictions: { country: "AR" },
    });

    // Inicializa el mapa centrado en una ubicación predeterminada (ej. Buenos Aires)
    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.6037, lng: -58.3816 },
        zoom: 12,
    });

    // Crea un marcador pero no lo muestra aún
    marker = new google.maps.Marker({
        map: map,
        visible: false,
    });

    // Escucha la selección de un lugar
    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        if (place.place_id) {
            selectedPlaceId = place.place_id;
            selectedParkData = {
                name: place.name,
                location: place.formatted_address,
                latitude: place.geometry.location.lat(),
                longitude: place.geometry.location.lng(),
                opening_hours: place.opening_hours ? place.opening_hours.weekday_text : null
            };

            console.log("Datos del parque seleccionados:", selectedParkData);
            showParkOnMap(selectedParkData); // Muestra el parque en el mapa
        } else {
            alert("Por favor, selecciona una plaza válida.");
            selectedPlaceId = null;
            selectedParkData = {};
        }
    });
}

// Función para mostrar el parque en el mapa
function showParkOnMap(parkData) {
    const location = {
        lat: parkData.latitude,
        lng: parkData.longitude
    };
    map.setCenter(location);
    map.setZoom(15);
    marker.setPosition(location);
    marker.setVisible(true);
}

// Función para enviar el formulario y guardar el entrenamiento
function saveTraining(event) {
    event.preventDefault();

    if (!selectedPlaceId) {
        alert("Por favor, selecciona una plaza válida antes de guardar.");
        return;
    }

    const trainingData = {
        name: document.getElementById("name").value,
        description: document.getElementById("description").value,
        park: selectedParkData, // Incluye los datos completos del parque
        day_of_week: Array.from(document.querySelectorAll("select[name='day_of_week[]']")).map(select => select.value),
        time: Array.from(document.querySelectorAll("input[name='time[]']")).map(input => input.value),
        frequency: Array.from(document.querySelectorAll("select[name='frequency[]']")).map(select => select.value),
        subscription_price: Array.from(document.querySelectorAll("input[name='subscription_price[]']")).map(input => parseFloat(input.value))
    };

    fetch('/save-training', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(trainingData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }
        return response.json();
    })
    .then(data => {
        console.log(data.message);
        // Puedes agregar aquí cualquier acción adicional como limpiar el formulario
    })
    .catch(error => {
        console.error('Error al guardar el entrenamiento:', error);
    });
}

