<div id="organizerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 hidden">
    <div class="bg-white dark:bg-dark-bg w-full max-w-2xl rounded-2xl p-8 shadow-2xl relative mx-4">
        <!-- Close Button -->
        <button onclick="closeOrganizerModal()"
            class="absolute top-4 right-4 text-white bg-gray-600 dark:bg-gray-500 hover:bg-gray-700 dark:hover:bg-gray-400 transition-colors rounded-full w-10 h-10 flex items-center justify-center focus:outline-none">
            <i class="fas fa-times text-lg"></i>
        </button>

        <!-- Title -->
        <h2 class="text-2xl font-semibold font-heading mb-6 text-primary dark:text-dark-primary">Edit Event</h2>

        <!-- Form -->
        <form action="{{ route('events.update-event', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Event Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Event Name</label>
                <input type="text" name="event_name" value="{{ $event->event_name }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
            </div>

            <!-- Location -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                <input type="text" name="location" value="{{ $event->location }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
            </div>

            <!-- Start Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                <input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
            </div>

            <!-- End Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                <input type="date" name="end_date" value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
            </div>

            <!-- Tickets -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Available Tickets</label>
                <input type="number" name="available_tickets" value="{{ $event->available_tickets }}" min="0" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                <select name="status" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-accent focus:outline-none">
                    <option value="Avalaible" {{ $event->status === 'Avalaible' ? 'selected' : '' }}>Available</option>
                    <option value="Upcoming" {{ $event->status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="Closed" {{ $event->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Upload Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
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
