{{-- Adam Ahmed Edited the modal --}}
@if (Auth::user() && Auth::user()->role == 'organizer')
<div id="organizerModal"
    class="fixed inset-0 z-50 items-center justify-center bg-black/80
    {{ session('errors') && !str_starts_with(array_keys(session('errors')->getBags())[0] ?? '', 'approve_') ? 'flex' : 'hidden' }}">
    <div class="bg-white dark:bg-dark-bg w-full max-w-2xl rounded-2xl p-8 shadow-2xl relative mx-4 max-h-[90vh] overflow-y-auto">
        <!-- Close Button -->
        <button onclick="closeOrganizerModal()"
            class="sticky top-2 right-2 ml-auto text-white bg-gray-600 dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-400 transition-colors rounded-full w-10 h-10 flex items-center justify-center focus:outline-none z-10">
            <i class="fas fa-times text-lg"></i>
        </button>

        <div class="space-y-4">
            <!-- Title -->
            <h2 class="text-2xl font-semibold font-heading mb-6 text-primary dark:text-dark-primary">Edit Event</h2>

            <!-- Form -->
            <form action="{{ route('organizer.events.update-event', ['id' => $event->id]) }}" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Event Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Name</label>
                    <input type="text" name="event_name" value="{{ old('event_name', $event->event_name) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                    @error('event_name', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                {{-- <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location', $event->location) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">

                    @error('location', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div> --}}

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                    <input type="date" name="start_date"
                        value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">

                    @error('start_date', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                    <input type="date" name="end_date"
                        value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d')) }}"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">

                    @error('end_date', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tickets -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Available
                        Tickets</label>
                    <input type="number" name="available_tickets"
                        value="{{ old('available_tickets', $event->available_tickets) }}" min="1"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">

                    @error('available_tickets', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                        <option value="Available" {{ old('status', $event->status) === 'Available' ? 'selected' : ''
                            }}>Available</option>
                        <option value="Upcoming" {{ old('status', $event->status) === 'Upcoming' ? 'selected' : '' }}>
                            Upcoming</option>
                        <option value="Closed" {{ old('status', $event->status) === 'Closed' ? 'selected' : '' }}>
                            Closed</option>
                    </select>
                    @error('status', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Image -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                    @error('image', 'organizer')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Map Section -->
                <div class="mt-5">
                    <label class="block text-primary dark:text-dark-primary font-semibold mb-2">Event Location</label>

                    <!-- Search Box -->
                    <div class="relative mb-4">
                        <input type="text" id="addressInput" placeholder="Search for a location..."
                            name="location" class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                    </div>

                    <!-- Map container -->
                    <div id="editMap" style="height: 400px; width: 100%; border-radius: 0.5rem;"></div>

                    <!-- Hidden inputs for coordinates -->
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $event->latitude) }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $event->longitude) }}">

                    <!-- Selected location display -->
                    <div class="mt-3 flex items-center justify-between">
                        <div id="selectedLocation" class="text-sm text-gray-600 dark:text-gray-300">
                            @if($event->latitude && $event->longitude)
                                Current location: {{ $event->latitude }}, {{ $event->longitude }}
                            @else
                                No location selected yet
                            @endif
                        </div>
                        <a id="googleMapsLink" href="#" target="_blank"
                            class="text-blue-500 hover:text-blue-400 underline text-sm {{ $event->latitude && $event->longitude ? '' : 'hidden' }}">
                            Open in Google Maps
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit"
                        class="cursor-pointer w-full py-3 rounded-lg bg-accent hover:bg-accent-hover text-white text-sm font-semibold transition-colors">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
<!-- Leaflet Geocoder CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

<style>
    /* Custom styles for the map */
    #editMap {
        z-index: 1;
        background-color: #f0f0f0;
    }

    /* Search input styling */
    input, textarea, select {
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
    .border-error, .dark .border-dark-error {
        border-color: #ef4444;
    }

    .text-error, .dark .text-dark-error {
        color: #ef4444;
    }

    /* Modal scrollbar styling */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .dark .overflow-y-auto::-webkit-scrollbar-track {
        background: #2d3748;
    }

    .dark .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #4a5568;
    }

    .dark .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #718096;
    }
</style>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<!-- Leaflet Geocoder JS -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
let editMapInstance = null;

// Initialize edit map function
function initEditMap() {
    // Prevent double initialization
    if (editMapInstance) {
        editMapInstance.invalidateSize();
        return;
    }

    // Use existing coordinates if available, otherwise default to Cairo
    const initialLat = {{ $event->latitude ?? '30.0444' }};
    const initialLng = {{ $event->longitude ?? '31.2357' }};

    // Initialize the map
    editMapInstance = L.map('editMap').setView([initialLat, initialLng], 13);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(editMapInstance);

    // Create a marker
    const marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(editMapInstance);

    const googleMapsLink = document.getElementById('googleMapsLink');
    const selectedLocation = document.getElementById('selectedLocation');
    const addressInput = document.getElementById('addressInput');
    const searchButton = document.getElementById('searchButton');

    // Initialize geocoder
    const geocoder = L.Control.Geocoder.nominatim({
        geocodingQueryParams: {
            'accept-language': 'en', // Force English results
            countrycodes: '', // Search globally
            limit: 5
        }
    });

    // Add geocoder control to map
    const control = L.Control.geocoder({
        position: 'topright',
        placeholder: 'Search for location...',
        defaultMarkGeocode: false,
        geocoder: geocoder,
        errorMessage: 'Nothing found.'
    }).on('markgeocode', function(e) {
        const {center, name} = e.geocode;
        editMapInstance.setView(center, 15);
        marker.setLatLng(center);
        updateLocation(center.lat, center.lng, name);
        addressInput.value = name;
    }).addTo(editMapInstance);

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
        geocoder.reverse({lat, lng}, editMapInstance.options.crs.scale(editMapInstance.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocation(lat, lng, results[0].name);
                addressInput.value = results[0].name;
            }
        });
    });

    // Handle map click
    editMapInstance.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);

        // Reverse geocode to get address
        geocoder.reverse(e.latlng, editMapInstance.options.crs.scale(editMapInstance.getZoom()), function(results) {
            if (results.length > 0) {
                updateLocation(e.latlng.lat, e.latlng.lng, results[0].name);
                addressInput.value = results[0].name;
            }
        });
    });

    // Manual search implementation
    searchButton.addEventListener('click', function() {
        const query = addressInput.value.trim();
        if (!query) return;

        geocoder.geocode(query, function(results) {
            if (results.length > 0) {
                const {center, name} = results[0];
                editMapInstance.setView(center, 15);
                marker.setLatLng(center);
                updateLocation(center.lat, center.lng, name);
                addressInput.value = name;
            } else {
                selectedLocation.textContent = 'Location not found';
                googleMapsLink.classList.add('hidden');
            }
        });
    });

    // Handle Enter key in search input
    addressInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchButton.click();
        }
    });

    // Set initial location if coordinates exist
    @if($event->latitude && $event->longitude)
        updateLocation(initialLat, initialLng);
        googleMapsLink.href = `https://www.google.com/maps?q=${initialLat},${initialLng}&ll=${initialLat},${initialLng}&z=15`;
    @else
        updateLocation(initialLat, initialLng, 'Default location: Cairo, Egypt');
    @endif

    // Initialize address input with current location if available
    @if($event->location)
        addressInput.value = '{{ $event->location }}';
    @endif

    // Force map to render properly
    setTimeout(() => {
        editMapInstance.invalidateSize();
    }, 250);
}

function openOrganizerModal() {
    const modal = document.getElementById('organizerModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    @if (session('errors'))
        window.history.replaceState({}, document.title, window.location.pathname);
    @endif

    // Initialize map after modal is visible
    setTimeout(() => {
        initEditMap();
    }, 100);
}

function closeOrganizerModal() {
    const modal = document.getElementById('organizerModal');
    modal.classList.remove('flex');
    modal.classList.add('hidden');

    @if (session('errors'))
        window.history.replaceState({}, document.title, window.location.pathname);
    @endif
}

// Handle modal initialization on page load
document.addEventListener('DOMContentLoaded', function() {
    @if ($errors->getBag('organizer')->any())
        // If there are validation errors, show modal immediately
        openOrganizerModal();
    @endif
});

// Handle escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('organizerModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeOrganizerModal();
        }
    }
});

// Handle click outside modal to close
document.getElementById('organizerModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeOrganizerModal();
    }
});
</script>
@endsection
@endif
