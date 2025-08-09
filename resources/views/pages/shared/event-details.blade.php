@php
    use Carbon\Carbon;

    $statusColors = [
        'Available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'Upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'Closed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',

        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
        'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-300',
    ];

    function getTicketColor($tickets)
    {
        if ($tickets >= 140) {
            return 'text-green-600 dark:text-green-400';
        } elseif ($tickets >= 35 && $tickets < 140) {
            return 'text-orange-600 dark:text-orange-400';
        } elseif ($tickets == 0) {
            return 'text-red-600 dark:text-red-400';
        }
        return 'text-gray-600 dark:text-gray-400';
} @endphp
@extends('layouts.app') @section('main') <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-8 px-4">
        <div class="max-w-4xl mx-auto">
            @if ($event)
                <div class="bg-white dark:bg-dark-surface rounded-xl shadow-lg overflow-hidden">
                    @if (isset($event->image))
                        <div class="relative h-56 md:h-72">
                            <img src="{{ $event->image ? asset('/storage/events/' . $event->image) : asset('/images/event-defualt.jpg') }}"
                                alt="{{ $event->event_name }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 right-6">
                                <h1 class="text-2xl md:text-3xl font-bold font-heading text-white mb-2">
                                    {{ $event->event_name }}
                                </h1>
                                <div class="flex items-center gap-2 text-white/90">
                                    <i class="fas fa-map-marker-alt w-4 h-4"></i>
                                    <span class="text-sm font-inter">{{ $event->location }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-accent to-accent-hover px-6 py-12">
                            <h1 class="text-2xl md:text-3xl font-bold font-heading text-white mb-2">
                                {{ $event->event_name }}
                            </h1>
                            <div class="flex items-center gap-2 text-white/90">
                                <i class="fas fa-map-marker-alt w-4 h-4"></i>
                                <span class="text-sm font-inter">{{ $event->location }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="p-6">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-6 border-b border-border dark:border-dark-border">
                            <div class="flex items-center gap-4">
                                <span
                                    class="flex items-center px-3 py-1 text-xs font-medium font-poppins rounded-full
                                    {{ $statusColors[$event->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $event->status }}
                                </span>
                                <span class="text-sm font-inter {{ getTicketColor($event->available_tickets) }}">
                                    {{ $event->available_tickets == 0 ? 'Sold Out' : $event->available_tickets . ' tickets' }}
                                </span>
                            </div>
                            @auth
                                @if (auth()->user()->role == 'speaker')
                                    @php
                                        $hasTicket = \App\Models\Ticket::where('event_id', $event->id)
                                            ->where('user_id', auth()->user()->id)
                                            ->exists();

                                        $hasPendingProposal = \App\Models\Proposal::where('event_id', $event->id)
                                            ->where('speaker_id', auth()->user()->id)
                                            ->where('status', 'pending')
                                            ->exists();

                                        $isAcceptedSpeaker = $eventSessions->contains('speaker_id', auth()->id());
                                        $ifrejectedid = $proposals->contains('speaker_id', auth()->id());
                                        $ifrejectedprop = $proposals->contains('status', 'rejected');

                                    @endphp

                                    @if ($hasTicket)
                                        <button disabled
                                            class="px-6 py-2.5 bg-surface dark:bg-dark-surface text-muted dark:text-dark-muted text-sm font-medium font-poppins rounded-lg cursor-not-allowed">
                                            You Can't apply to this Event
                                        </button>
                                    @elseif ($hasPendingProposal)
                                        <button disabled
                                            class="px-6 py-2.5 bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-900/20 dark:text-yellow-300 dark:border-yellow-800 text-sm font-medium font-poppins rounded-lg cursor-not-allowed">
                                            <i class="fas fa-clock mr-2"></i> Under Review
                                        </button>
                                    @elseif ($isAcceptedSpeaker)
                                        <button disabled
                                            class="px-6 py-2.5 bg-green-100 text-green-800 border border-green-200 dark:bg-green-900/20 dark:text-green-300 dark:border-green-800 text-sm font-medium font-poppins rounded-lg cursor-not-allowed">
                                            <i class="fas fa-check-circle mr-2"></i> Approved
                                        </button>
                                    @elseif ($ifrejectedid && $ifrejectedprop)
                                        <button disabled
                                            class="px-6 py-2.5 bg-red-100 text-red-800 border border-red-200 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800 text-sm font-medium font-poppins rounded-lg cursor-not-allowed">
                                            <i class="fas fa-times-circle mr-2"></i> Rejected
                                        </button>
                                    @else
                                        <button onclick="openSpeakerModal()"
                                            class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                            Apply as Speaker
                                        </button>
                                    @endif
                                @elseif (auth()->user()->role == 'organizer' && auth()->user()->id == $event->organizer->id)
                                    <button onclick="openOrganizerModal()"
                                        class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                        Edit This Event
                                    </button>
                                @elseif(auth()->user()->role == 'user' && auth()->user()->role == 'speaker')
                                    @if ($event->available_tickets > 0)
                                        <form action="{{ route('tickets.BookTicket', ['id' => $event->id]) }}" method="POST"
                                            class="flex items-center justify-center ">
                                            @csrf
                                            <button
                                                class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                                <i class="fas fa-ticket-alt mr-2"></i> Book a Ticket
                                            </button>
                                        </form>
                                    @else
                                        <button disabled
                                            class="flex items-center justify-center px-6 py-2.5 bg-surface dark:bg-dark-surface text-muted dark:text-dark-muted text-sm font-medium font-poppins rounded-lg cursor-not-allowed">
                                            <i class="fas fa-ban mr-2"></i> Sold Out
                                        </button>
                                    @endif
                                @endif
                            @endauth


                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                            <div>
                                <h3
                                    class="text-sm font-semibold font-inter text-secondary dark:text-dark-secondary uppercase tracking-wide mb-2">
                                    <i class="fas fa-calendar-alt mr-2"></i> Date & Time
                                </h3>
                                <p class="text-primary dark:text-dark-primary font-manrope">
                                    {{ Carbon::parse($event->start_date)->format('M d, Y') }}
                                    @if ($event->start_date !== $event->end_date)
                                        - {{ Carbon::parse($event->end_date)->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-semibold font-inter text-secondary dark:text-dark-secondary uppercase tracking-wide mb-2">
                                    <i class="fas fa-user mr-2"></i> Organizer
                                </h3>
                                <p class="text-primary dark:text-dark-primary font-manrope">
                                    {{ $event->organizer->username }}</p>
                            </div>

                        </div>
                        @if (auth()->user()->role == 'organizer' && $event->organizer_id == auth()->id())
                            <div class="mt-6 border-t border-border dark:border-dark-border pt-6">
                                <h3 class="text-lg font-semibold font-heading text-secondary dark:text-dark-secondary mb-4">
                                    <i class="fa-solid fa-hand mr-2"></i> Proposal Requests
                                </h3>

                                <div class="space-y-4">
                                    @foreach ($proposals as $proposal)
                                        <div class="bg-surface dark:bg-dark-bg rounded-lg p-4 shadow-sm">
                                            <div
                                                class="flex relative flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                {{-- Status Badge --}}
                                                <div class="absolute top-2 right-2 z-20">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                        {{ ucfirst($proposal->status) }}
                                                    </span>
                                                </div>

                                                <div>
                                                    {{-- Title --}}
                                                    <h4
                                                        class="text-base font-semibold font-inter text-primary dark:text-dark-primary">
                                                        {{ $proposal->title }}
                                                    </h4>

                                                    {{-- Speaker --}}
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $proposal->speaker->username ?? 'Unknown Speaker' }}
                                                    </p>

                                                    {{-- Description --}}
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-align-left mr-1"></i>
                                                        {{ $proposal->description }}
                                                    </p>

                                                    {{-- CV Download --}}
                                                    @if ($proposal->cv)
                                                        <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                            <i class="fas fa-file-download mr-1"></i>
                                                            <a href="{{ asset('storage/cvs/' . $proposal->cv) }}"
                                                                target="_blank" class="underline hover:text-accent">
                                                                View CV
                                                            </a>
                                                        </p>
                                                    @endif

                                                </div>

                                                {{-- Action Buttons --}}
                                                <div class="flex space-x-2 mt-5 mr-2">
                                                    @if ($proposal->status === 'pending')
                                                        {{-- Approve Button opens modal --}}
                                                        <button type="button"
                                                            onclick="openApproveModal({{ $proposal->id }})"
                                                            class="px-3 py-1 text-xs cursor-pointer bg-emerald-500 hover:bg-emerald-600 text-white rounded-full">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        {{-- Reject Button --}}
                                                        <form
                                                            action="{{ route('organizer.events.proposals.reject', $proposal->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit"
                                                                class="px-3 py-1 text-xs cursor-pointer bg-rose-500 hover:bg-rose-600 text-white rounded-full">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>


                                                <div id="approveModal-{{ $proposal->id }}"
                                                    class="fixed inset-0 z-50 items-center justify-center bg-black/80 {{ old('_from_proposal_id') == $proposal->id && $errors->getBag('approve_' . $proposal->id)->isNotEmpty() ? 'flex' : 'hidden' }}">
                                                    <div
                                                        class="bg-bg dark:bg-dark-bg w-full max-w-md rounded-xl p-6 relative shadow-xl">
                                                        <button onclick="closeApproveModal({{ $proposal->id }})"
                                                            class="absolute top-4 right-4 text-gray-200 rounded-full cursor-pointer hover:text-gray-100 bg-gray-400 dark:bg-gray-600 w-10 h-10 flex justify-center items-center">
                                                            <i class="fas fa-times"></i>
                                                        </button>

                                                        <h2
                                                            class="text-lg font-bold mb-4 text-primary dark:text-dark-primary">
                                                            Approve Proposal
                                                        </h2>

                                                        <form
                                                            action="{{ route('organizer.events.proposals.approve', $proposal->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <input type="hidden" name="status" value="approved">
                                                            <input type="hidden" name="_from_proposal_id"
                                                                value="{{ $proposal->id }}">

                                                            <!-- Session Date Input -->
                                                            <div class="mb-4">
                                                                <label for="session_date_{{ $proposal->id }}"
                                                                    class="block text-sm font-medium text-secondary dark:text-dark-secondary mb-1">
                                                                    Date
                                                                </label>
                                                                <input type="date" id="session_date_{{ $proposal->id }}"
                                                                    name="session_date"
                                                                    min="{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d') }}"
                                                                    max="{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d') }}"
                                                                    value="{{ old('session_date', \Carbon\Carbon::parse($event->start_date)->format('Y-m-d')) }}"
                                                                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">

                                                                @error('session_date', 'approve_' . $proposal->id)
                                                                    <span
                                                                        class="text-sm text-red-500">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Start Time Input -->
                                                            <div class="mb-4">
                                                                <label for="start_time_{{ $proposal->id }}"
                                                                    class="block text-sm font-medium text-secondary dark:text-dark-secondary mb-1">
                                                                    Start Time
                                                                </label>
                                                                <input type="time" id="start_time_{{ $proposal->id }}"
                                                                    name="start_time" step="60"
                                                                    value="{{ old('start_time') }}"
                                                                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
                                                                @error('start_time', 'approve_' . $proposal->id)
                                                                    <span
                                                                        class="text-sm text-red-500">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- End Time Input -->
                                                            <div class="mb-4">
                                                                <label for="end_time_{{ $proposal->id }}"
                                                                    class="block text-sm font-medium text-secondary dark:text-dark-secondary mb-1">
                                                                    End Time
                                                                </label>
                                                                <input type="time" id="end_time_{{ $proposal->id }}"
                                                                    name="end_time" step="60"
                                                                    value="{{ old('end_time') }}"
                                                                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
                                                                @error('end_time', 'approve_' . $proposal->id)
                                                                    <span
                                                                        class="text-sm text-red-500">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <div class="flex justify-end space-x-2">
                                                                <button type="button"
                                                                    onclick="closeApproveModal({{ $proposal->id }})"
                                                                    class="px-4 py-2 rounded-md bg-gray-300 dark:bg-gray-700 text-black dark:text-white hover:bg-gray-400 dark:hover:bg-gray-600">
                                                                    Cancel
                                                                </button>
                                                                <button type="submit"
                                                                    class="px-4 py-2 rounded-md bg-emerald-600 hover:bg-emerald-700 text-white">
                                                                    Confirm
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        @if ($eventSessions)
                            <div class="mt-6 border-t border-border dark:border-dark-border pt-6">
                                <h3
                                    class="text-lg font-semibold font-heading text-secondary dark:text-dark-secondary mb-4">
                                    <i class="fas fa-microphone-alt mr-2"></i> Event Sessions
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($eventSessions as $session)
                                        <div class="bg-surface dark:bg-dark-bg rounded-lg p-4 shadow-sm">
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                <div>
                                                    <h4
                                                        class="text-base font-semibold font-inter text-primary dark:text-dark-primary">
                                                        {{ $session->proposal->title ?? 'Session Title' }}
                                                    </h4>

                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-user mr-1"></i>
                                                        {{ $session->speaker->username ?? 'Speaker Name' }}
                                                    </p>
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ Carbon::parse($session->start_date)->format('M d, Y H:i') }}
                                                        -
                                                        {{ Carbon::parse($session->end_date)->format('H:i') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-inter text-muted dark:text-dark-muted">
                                                        Duration:
                                                        {{ Carbon::parse($session->start_date)->diffInMinutes($session->end_date) }}
                                                        min
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                <div class="mt-6 bg-white dark:bg-dark-surface rounded-xl shadow-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold font-heading text-secondary dark:text-dark-secondary mb-4">
                            <i class="fas fa-map-marked-alt mr-2"></i> Event Location
                        </h3>
                        <div id="map" style="height: 400px;"></div>
                        <p id="coordinates" class="mt-2"></p>
                        <a id="googleMapsLink" href="#" target="_blank"></a>
                        <button id="openGoogleMapsBtn"
                            class="cursor-pointer dark:text-dark-primary light:text-blue-500 btn btn-primary mt-2">
                            Open in Google Maps
                        </button>
                    </div>
                </div>
            @else
                <div class="text-center py-16">
                    <div class="max-w-md mx-auto">
                        <i class="fas fa-exclamation-circle w-16 h-16 text-muted dark:text-dark-muted mb-4"></i>
                        <h2 class="text-3xl font-semibold font-heading text-secondary dark:text-dark-secondary mb-2">
                            Event Not Found
                        </h2>
                        <p class="text-muted dark:text-dark-muted font-manrope mb-6 text-xl">
                            The event you're looking for doesn't exist or may have been removed.
                        </p>
                        <a href="{{ route('events') }}"
                            class="flex items-center justify-center px-6 py-3 bg-accent hover:bg-accent-hover text-white font-medium font-poppins rounded-lg transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i> Browse All Events
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <x-modals.speaker-modal :event="$event" />
    <x-modals.organizer-modal :event="$event" />



    <script>
        function openSpeakerModal() {
            document.getElementById('speakerModal').classList.remove('hidden');
        }

        function closeSpeakerModal() {
            document.getElementById('speakerModal').classList.add('hidden');
        }

        function openOrganizerModal() {
            document.getElementById('organizerModal').classList.remove('hidden');
        }

        function closeOrganizerModal() {
            document.getElementById('organizerModal').classList.add('hidden');
        }

        function openApproveModal(id) {
            document.getElementById('approveModal-' + id).classList.remove('hidden');
        }

        function closeApproveModal(id) {
            document.getElementById('approveModal-' + id).classList.add('hidden');
        }

        function openApproveModal(id) {
            const modal = document.getElementById(`approveModal-${id}`);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeApproveModal(id) {
            const modal = document.getElementById(`approveModal-${id}`);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            @if ($errors->any() && old('_from_proposal_id'))
                openApproveModal({{ old('_from_proposal_id') }});
            @endif
        });

        // Default coordinates (Cairo)
        // Get coordinates from backend, default to Cairo if null
        // Get coordinates from backend, default to Cairo if null
        const eventLat = {{ $event->latitude ?? 30.0444 }};
        const eventLng = {{ $event->longitude ?? 31.2357 }};

        // Initialize the map
        const map = L.map('map').setView([eventLat, eventLng], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Place a marker at the event location
        const marker = L.marker([eventLat, eventLng]).addTo(map);

        // Update coordinates text and Google Maps link
        updateLocation(eventLat, eventLng);

        function updateLocation(lat, lng) {
            document.getElementById('coordinates').innerText =
                `Latitude: ${lat.toFixed(6)}, Longitude: ${lng.toFixed(6)}`;

            const mapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;
            document.getElementById('googleMapsLink').href = mapsUrl;

            // Set button click to open Google Maps in new tab
            document.getElementById('openGoogleMapsBtn').addEventListener('click', () => {
                window.open(mapsUrl, '_blank');
            });
        }
    </script>



@endsection
