<div id="organizerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 hidden shadow-2xl">
    <div class="bg-bg dark:bg-dark-bg w-full max-w-xl rounded-xl p-10 relative">
        <button onclick="closeOrganizerModal()"
            class="absolute top-4 right-4 text-gray-200 rounded-full cursor-pointer hover:text-gray-100 bg-gray-400 dark:bg-gray-600 w-10 h-10 flex justify-center items-center">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-xl font-bold font-heading mb-4 text-primary dark:text-dark-primary">Edit This Event</h2>

        <form action="{{ route('events.update-event', ['id' => $event->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Event Name -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Event Name</label>
                <input type="text" name="event_name" value="{{ $event->event_name }}" required
                    class="form-input">
            </div>

            <!-- Location -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Location</label>
                <input type="text" name="location" value="{{ $event->location }}" required
                    class="form-input">
            </div>

            <!-- Start Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Start Date</label>
                <input type="date" name="start_date"
                    value="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}" required
                    class="form-input">
            </div>

            <!-- End Date -->
            <div class="mb-4">
                <label class="block text-sm font-medium">End Date</label>
                <input type="date" name="end_date"
                    value="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}" required
                    class="form-input">
            </div>

            <!-- Tickets -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Available Tickets</label>
                <input type="number" name="available_tickets" value="{{ $event->available_tickets }}" required min="0"
                    class="form-input">
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-sm font-medium">Status</label>
                <select name="status" required class="form-input">
                    <option value="Avalaible" {{ $event->status === 'Avalaible' ? 'selected' : '' }}>Avalaible</option>
                    <option value="Upcoming" {{ $event->status === 'Upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="Closed" {{ $event->status === 'Closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <!-- Upload Image -->
            <div class="mb-6">
                <label class="block text-sm font-medium">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="file:form-button text-primary dark:text-dark-primary bg-white dark:bg-dark-bg">
            </div>

            <button type="submit"
                class="w-full px-4 py-2.5 bg-accent hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg">
                Save Changes
            </button>
        </form>
    </div>
</div>
