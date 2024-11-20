// registerTrainer.js

let autocomplete;
let map;
let marker;
let selectedPlaceId = null;
let selectedParkData = {};

function initAutocomplete() {
    const input = document.getElementById("park-search");

    autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['establishment'],
        componentRestrictions: { country: "AR" },
    });

    map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -34.6037, lng: -58.3816 },
        zoom: 12,
    });

    marker = new google.maps.Marker({
        map: map,
        visible: false,
    });

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();

        if (place.place_id) {
            selectedPlaceId = place.place_id;
            selectedParkData = {
                name: place.name,
                location: place.formatted_address,
                latitude: place.geometry.location.lat(),
                longitude: place.geometry.location.lng(),
                opening_hours: place.opening_hours ? place.opening_hours.weekday_text : null,
            };

            showParkOnMap(selectedParkData); // Muestra el parque en el mapa
        } else {
            alert("Por favor, selecciona un parque válido.");
            selectedPlaceId = null;
            selectedParkData = {};
        }
    });
}

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

function saveTrainer(event) {
    event.preventDefault();

    if (!selectedPlaceId) {
        alert("Por favor, selecciona un parque válido antes de guardar.");
        return;
    }

    const trainerData = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        password: document.getElementById("password").value,
        password_confirmation: document.getElementById("password_confirmation").value,
        certification: document.getElementById("certification").value,
        biography: document.getElementById("biography").value,
        park: selectedParkData
    };

    fetch('/save-trainer', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(trainerData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.redirect) {
            console.log("Redirigiendo al dashboard:", data.redirect);
            window.location.href = data.redirect;
        } else if (data.error) {
            alert("Error al registrar: " + data.error);
        }
    })
    .catch(error => {
        console.error('Error al registrar el entrenador:', error);
    });
}
