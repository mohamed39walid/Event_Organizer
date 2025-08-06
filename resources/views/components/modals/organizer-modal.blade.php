{{-- Adam Ahmed Edited the modal  --}}
<div id="organizerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 {{ session('errors') ? '' : 'hidden' }}">
    <div class="bg-white dark:bg-dark-bg w-full max-w-2xl rounded-2xl p-8 shadow-2xl relative mx-4">
        <!-- Close Button -->
        <button onclick="closeOrganizerModal()"
            class="absolute top-4 right-4 text-white bg-gray-600 dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-400 transition-colors rounded-full w-10 h-10 flex items-center justify-center focus:outline-none">
            <i class="fas fa-times text-lg"></i>
        </button>

        <!-- Title -->
        <h2 class="text-2xl font-semibold font-heading mb-6 text-primary dark:text-dark-primary">Edit Event</h2>

        <!-- Display success/error messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif



        <!-- Form -->
        <form action="{{ route('events.update-event', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Event Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Name</label>
                <input type="text" name="event_name" value="{{ old('event_name', $event->event_name) }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                @error('event_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ old('start_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                @error('start_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ old('end_date', \Carbon\Carbon::parse($event->end_date)->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                @error('end_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tickets -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Available Tickets</label>
                <input type="number" name="available_tickets" value="{{ old('available_tickets', $event->available_tickets) }}" min="1" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                @error('available_tickets')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                    <option value="Available" {{ old('status', $event->status) === 'Available' ? 'selected' : '' }}>Available</option>
                    <option value="Upcoming" {{ old('status', $event->status) === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="Closed" {{ old('status', $event->status) === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full py-3 rounded-lg bg-accent hover:bg-accent-hover text-white text-sm font-semibold transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    function openOrganizerModal() {
        document.getElementById('organizerModal').classList.remove('hidden');
        @if(session('errors'))
            window.history.replaceState({}, document.title, window.location.pathname);
        @endif
    }

    function closeOrganizerModal() {
        document.getElementById('organizerModal').classList.add('hidden');
        @if(session('errors'))
            window.history.replaceState({}, document.title, window.location.pathname);
        @endif
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('errors'))
            openOrganizerModal();
        @endif
    });
</script>
@endsection