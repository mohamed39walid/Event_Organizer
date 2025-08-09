@extends('layouts.app')

@section('main')
<div class="min-h-[calc(100vh-140px)] flex justify-center items-center px-4">
    <div
        class="bg-surface dark:bg-dark-surface w-full min-h-[600px] max-w-3xl text-white py-10 px-10 rounded-2xl flex flex-col">
        <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold mb-6">Create New Event</h1>

        <form action="{{ route('organizer.events.store-event') }}" enctype="multipart/form-data" method="POST"
            class="space-y-6 px-4">
            @csrf

            <div class="mt-5">
                <label for="event_name" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                    Event Name
                </label>
                <input id="event_name" name="event_name" type="text" value="{{ old('event_name') }}"
                    placeholder="e.g., Live Talk Night"
                    class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('event_name') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                @error('event_name')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror
            </div>


            <div class="mt-5">
                <label for="available_tickets" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                    Available Tickets
                </label>
                <input id="available_tickets" name="available_tickets" type="number" min="1"
                    value="{{ old('available_tickets') }}" placeholder="e.g., 100"
                    class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('available_tickets') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                @error('available_tickets')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col md:flex-row justify-between w-full gap-6 mt-6">
                <div class="w-full">
                    <label for="start_date" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        Start Date
                    </label>
                    <input id="start_date" name="start_date" type="date" min="{{ now()->toDateString() }}"
                        value="{{ old('start_date', now()->toDateString()) }}"
                        class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('start_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('start_date')
                    <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label for="end_date" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        End Date
                    </label>
                    <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}"
                        class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('end_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('end_date')
                    <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image
                    (optional)</label>
                <input type="file" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                @error('image')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Map Section -->
            <div class="mt-5">
                <label for="addressInput" class="block text-primary dark:text-dark-primary font-semibold mb-2">Event Location</label>
                <input id="addressInput" type="text" placeholder="Enter the event location"
                    class="w-full rounded-md border text-primary dark:text-dark-primary p-3 mb-1 border-gray-300" />
                @error('location')
                <p class="text-sm text-error dark:text-dark-error mb-1">{{ $message }}</p>
                @enderror
                <div id="map" style="height: 400px; width: 100%; border-radius: 0.5rem;"></div>

                <!-- Hidden inputs for coordinates -->
                <input class="location_input" type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                @error('latitude')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror

                <input class="location_input" type="hidden" name="longitude" id="longitude"
                    value="{{ old('longitude') }}">
                @error('longitude')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror

                <!-- Selected location display -->
                <div class="mt-3 flex items-center justify-between">
                    <div id="selectedLocation" class="text-sm text-gray-300">No location selected yet</div>
                    <a id="googleMapsLink" href="#" target="_blank"
                        class="text-blue-500 hover:text-blue-400 underline text-sm hidden">
                        Open in Google Maps
                    </a>
                </div>
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit"
                    class="cursor-pointer border rounded-full py-3 px-6 text-xl font-bold text-dark-primary dark:text-primary hover:text-primary hover:dark:text-dark-primary bg-primary dark:bg-dark-primary hover:bg-transparent transition-all duration-300 w-full md:w-1/4">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Include Leaflet CSS/JS and Geocoder -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Default coordinates (Cairo)
    const defaultLat = 30.0444;
    const defaultLng = 31.2357;

    // Use old input lat/lng if available, otherwise default
let currentLat = parseFloat("{{ old('latitude', '30.0444') }}") || 30.0444;
let currentLng = parseFloat("{{ old('longitude', '31.2357') }}") || 31.2357;


    // Initialize the map
    const map = L.map('map').setView([currentLat, currentLng], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Create a draggable marker
    const marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);

    const googleMapsLink = document.getElementById('googleMapsLink');
    const selectedLocation = document.getElementById('selectedLocation');
    const addressInput = document.getElementById('addressInput');
    const locationInput = document.getElementById('location');

    // Initialize geocoder
    const geocoder = L.Control.Geocoder.nominatim({
        geocodingQueryParams: {
            'accept-language': 'en',
            limit: 5
        }
    });

    // Add geocoder control to map (search box on map top-right)
    L.Control.geocoder({
        position: 'topright',
        placeholder: 'Search for location...',
        defaultMarkGeocode: false,
        geocoder: geocoder
    }).on('markgeocode', function(e) {
        const { center, name } = e.geocode;
        map.setView(center, 15);
        marker.setLatLng(center);
        updateLocation(center.lat, center.lng, name);
        addressInput.value = name;
        locationInput.value = name;
    }).addTo(map);

    // Update location function (updates hidden inputs, location input, display and link)
    function updateLocation(lat, lng, name = '') {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;

        if (name) {
            selectedLocation.textContent = name;
            locationInput.value = name;
        } else {
            selectedLocation.textContent = `Coordinates: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
        }

        googleMapsLink.href = `https://www.google.com/maps?q=${lat},${lng}&ll=${lat},${lng}&z=15`;
        googleMapsLink.classList.remove('hidden');
    }

    // Marker drag event
    marker.on('dragend', function(e) {
        const { lat, lng } = e.target.getLatLng();
        updateLocation(lat, lng);

        geocoder.reverse({ lat, lng }, map.options.crs.scale(map.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocation(lat, lng, results[0].name);
                addressInput.value = results[0].name;
                locationInput.value = results[0].name;
            }
        });
    });

    // Map click event to move marker and update location
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);

        geocoder.reverse(e.latlng, map.options.crs.scale(map.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocation(e.latlng.lat, e.latlng.lng, results[0].name);
                addressInput.value = results[0].name;
                locationInput.value = results[0].name;
            }
        });
    });

    // Search input (above map) enter key triggers search
    addressInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchLocation(addressInput.value.trim());
        }
    });

    // Search location function
    function searchLocation(query) {
        if (!query) return;

        geocoder.geocode(query, function(results) {
            if (results.length > 0) {
                const { center, name } = results[0];
                map.setView(center, 15);
                marker.setLatLng(center);
                updateLocation(center.lat, center.lng, name);
                addressInput.value = name;
                locationInput.value = name;
            } else {
                selectedLocation.textContent = 'Location not found';
                googleMapsLink.classList.add('hidden');
            }
        });
    }

    // If old location exists, fill location input
    @if(old('location'))
        locationInput.value = "{{ old('location') }}";
        addressInput.value = "{{ old('location') }}";
    @endif

    // Initialize display with current values if exist
    if (currentLat && currentLng) {
        updateLocation(currentLat, currentLng, locationInput.value);
    } else {
        selectedLocation.textContent = "No location selected yet";
        googleMapsLink.classList.add('hidden');
    }
});
</script>
@endsection