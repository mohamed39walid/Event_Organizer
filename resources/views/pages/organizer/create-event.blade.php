@extends('layouts.app')

@section('main')

<div class="min-h-[calc(100vh-140px)] flex justify-center items-center px-4">
    <div
        class="bg-surface dark:bg-dark-surface w-full min-h-[600px] max-w-3xl text-white py-10 px-10 rounded-2xl flex flex-col">
        <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold mb-6">Create New Event</h1>

        <form action="{{ route('organizer.events.store-event') }}" enctype="multipart/form-data" method="POST"
            class="spacae-y-6 px-4">
            @csrf

            <div class="mt-5">
                <label for="event_name" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                    Event Name
                </label>
                <input id="event_name" name="event_name" type="text" value="{{ old('event_name') }}"
                    placeholder="e.g., Live Talk Night"
                    class="w-full rounded-md border p-3 @error('event_name') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                @error('event_name')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror
            </div>

    <div class="min-h-[calc(100vh-140px)] flex justify-center items-center px-4">
        <div
            class="bg-surface dark:bg-dark-surface w-full min-h-[600px] max-w-3xl text-white py-10 px-10 rounded-2xl flex flex-col">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold mb-6">Create New Event</h1>

            <form action="{{ route('organizer.events.store-event') }}" enctype="multipart/form-data" method="POST"
                class="spacae-y-6 px-4">
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
                <label for="location" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                    Location
                </label>
                <input id="location" name="location" type="text" value="{{ old('location') }}"
                    placeholder="e.g., Cairo International Stadium"
                    class="w-full rounded-md border p-3 @error('location') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                @error('location')
                <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-5">
                <label for="available_tickets" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                    Available Tickets
                </label>
                <input id="available_tickets" name="available_tickets" type="number" min="1"
                    value="{{ old('available_tickets') }}" placeholder="e.g., 100"
                    class="w-full rounded-md border p-3 @error('available_tickets') border-error dark:border-dark-error @else border-gray-300 @enderror" />
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
                        class="w-full rounded-md border p-3 @error('start_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('start_date')
                    <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>

                    <input id="location" name="location" type="text" value="{{ old('location') }}"
                        placeholder="e.g., Cairo International Stadium"
                        class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('location') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('location')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>

                    @enderror
                </div>

                <div class="w-full">
                    <label for="end_date" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        End Date
                    </label>

                    <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}"
                        class="w-full rounded-md border p-3 @error('end_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('end_date')
                    <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>

                    <input id="available_tickets" name="available_tickets" type="number" min="1"
                        value="{{ old('available_tickets') }}" placeholder="e.g., 100"
                        class="w-full rounded-md border text-primary dark:text-dark-primary p-3 @error('available_tickets') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('available_tickets')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>

                    @enderror
                </div>
            </div>


            <div class="mt-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                @error('image')
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image (optional)</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                    @error('image')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>


            <!-- Map Section -->
            <div class="mt-5">
                <label class="block text-primary dark:text-dark-primary font-semibold mb-2">Event Location</label>

                <!-- Map container -->
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
@endsection




<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<style>
    /* Custom styles for the map */
    #map {
        z-index: 1;
        background-color: #f0f0f0;
    }

    /* Search input styling */
    .location_input,
    textarea,
    select {
        color: #000 !important;
    }

    .leaflet-control-geocoder {
        margin-top: 10px !important;
        margin-right: 10px !important;
    }

    /* Suggestions dropdown */
    .leaflet-control-geocoder-form {
        width: 300px;
    }

    .leaflet-control-geocoder-form input {
        color: #000 !important;
        padding: 8px 12px !important;
    }

    /* Error states */
    .border-error,
    .dark .border-dark-error {
        border-color: #ef4444;
    }

    .text-error,
    .dark .text-dark-error {
        color: #ef4444;
    }
</style>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Geocoder JS -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Default coordinates (Cairo)
    const defaultLat = 30.0444;
    const defaultLng = 31.2357;

    // Initialize the map
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Create a marker
    const marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);
    
    const googleMapsLink = document.getElementById('googleMapsLink');
    const selectedLocation = document.getElementById('selectedLocation');

    // Initialize geocoder
    const geocoder = L.Control.Geocoder.nominatim({
        geocodingQueryParams: {
            'accept-language': 'en', // Force English results
            countrycodes: '', // Search globally
            limit: 5
        }
    });

    // Add geocoder control to map
    L.Control.geocoder({
        position: 'topright',
        placeholder: 'Search for location...',
        defaultMarkGeocode: false,
        geocoder: geocoder
    }).on('markgeocode', function(e) {
        const {center, name} = e.geocode;
        map.setView(center, 15);
        marker.setLatLng(center);
        updateLocation(center.lat, center.lng, name);
    }).addTo(map);

    // Function to update location information
    function updateLocation(lat, lng, name = '') {
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = lng;
        
        if (name) {
            selectedLocation.textContent = name;
        } else {
            selectedLocation.textContent = `Coordinates: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
        }
        
        // Update Google Maps link
        googleMapsLink.href = `https://www.google.com/maps?q=${lat},${lng}&ll=${lat},${lng}&z=15`;
        googleMapsLink.classList.remove('hidden');
    }

    // Handle marker drag
    marker.on('dragend', function(e) {
        const {lat, lng} = e.target.getLatLng();
        updateLocation(lat, lng);
        
        // Reverse geocode to get address
        geocoder.reverse({lat, lng}, map.options.crs.scale(map.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocation(lat, lng, results[0].name);
            }
        });
    });

    // Handle map click
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);
    });

    // Manual search implementation
    document.getElementById('searchButton').addEventListener('click', function() {
        const query = document.getElementById('addressInput').value.trim();
        if (!query) return;

        geocoder.geocode(query, function(results) {
            if (results.length > 0) {
                const {center, name} = results[0];
                map.setView(center, 15);
                marker.setLatLng(center);
                updateLocation(center.lat, center.lng, name);
                document.getElementById('addressInput').value = name;
            } else {
                selectedLocation.textContent = 'Location not found';
            }
        });
    });

    // Set initial location
    updateLocation(defaultLat, defaultLng, 'Default location: Cairo, Egypt');
});
</script>