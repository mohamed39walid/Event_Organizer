@php
    use Carbon\Carbon;

    $statusColors = [
        'Avalaible' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
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
    }
@endphp
@extends('layouts.app')

@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-8 px-4">
        <div class="max-w-4xl mx-auto">
            @if ($event)
                <div class="bg-white dark:bg-dark-surface rounded-xl shadow-lg overflow-hidden">
                    @if (isset($event->image))
                        <div class="relative h-56 md:h-72">
                            <img src="{{ asset($event->image) }}" alt="{{ $event->event_name }}"
                                class="w-full h-full object-cover">
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
                                    <button onclick="openSpeakerModal()"
                                        class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                        Apply as Speaker
                                    </button>
                                @elseif (auth()->user()->role == 'organizer' && auth()->user()->id == $event->organizer->id)
                                    <button onclick="openOrganizerModal()"
                                        class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                        Edit This Event
                                    </button>
                                @elseif(auth()->user()->role == 'user')
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
                        @if ($proposals && auth()->user()->role == 'organizer')
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
                                                            <a href="{{ asset('storage/' . $proposal->cv) }}"
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
                                                            class="px-3 py-1 text-xs bg-emerald-500 hover:bg-emerald-600 text-white rounded-full">
                                                            <i class="fa-solid fa-check"></i>
                                                        </button>

                                                        {{-- Reject Button --}}
                                                        <form
                                                            action="{{ route('events.proposals.reject', $proposal->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit"
                                                                class="px-3 py-1 text-xs bg-rose-500 hover:bg-rose-600 text-white rounded-full">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>

                                                {{-- Approve Modal --}}
                                                <div id="approveModal-{{ $proposal->id }}"
                                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 hidden">
                                                    <div
                                                        class="bg-bg dark:bg-dark-bg w-full max-w-md rounded-xl p-6 relative shadow-xl">
                                                        <button onclick="closeApproveModal({{ $proposal->id }})"
                                                            class="absolute top-4 right-4 text-gray-200 rounded-full cursor-pointer hover:text-gray-100 bg-gray-400 dark:bg-gray-600 w-10 h-10 flex justify-center items-center">
                                                            <i class="fas fa-times"></i>
                                                        </button>

                                                        <h2
                                                            class="text-lg font-bold mb-4 text-primary dark:text-dark-primary">
                                                            Approve Proposal</h2>

                                                        <form
                                                            action="{{ route('events.proposals.approve', $proposal->id) }}"
                                                            method="POST">
                                                            @csrf @method('PUT')
                                                            <input type="hidden" name="status" value="approved">

                                                            <div class="mb-4">
                                                                <label for="start_date_{{ $proposal->id }}"
                                                                    class="block text-sm font-medium text-secondary dark:text-dark-secondary mb-1">
                                                                    Start Date
                                                                </label>
                                                                <input type="date" id="start_date_{{ $proposal->id }}"
                                                                    name="start_date" min="{{ now()->toDateString() }}"
                                                                    required
                                                                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="end_date_{{ $proposal->id }}"
                                                                    class="block text-sm font-medium text-secondary dark:text-dark-secondary mb-1">
                                                                    End Date
                                                                </label>
                                                                <input type="date" id="end_date_{{ $proposal->id }}"
                                                                    name="end_date" min="{{ now()->toDateString() }}"
                                                                    required
                                                                    class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
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


                        @if ($evntSessions)
                            <div class="mt-6 border-t border-border dark:border-dark-border pt-6">
                                <h3
                                    class="text-lg font-semibold font-heading text-secondary dark:text-dark-secondary mb-4">
                                    <i class="fas fa-microphone-alt mr-2"></i> Event Sessions
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($evntSessions as $evntSessions)
                                        <div class="bg-surface dark:bg-dark-bg rounded-lg p-4 shadow-sm">
                                            <div
                                                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                <div>
                                                    <h4
                                                        class="text-base font-semibold font-inter text-primary dark:text-dark-primary">
                                                        {{ $evntSessions->proposal->title }}
                                                    </h4>
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-user mr-1"></i> {{ $evntSessions->proposal->speaker->username }}
                                                    </p>
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ Carbon::parse($evntSessions->start_date)->format('M d, Y') }} -
                                                        {{ Carbon::parse($evntSessions->end_date)->format('M d, Y') }}
                                                    </p>
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
                        <div class="h-48 bg-surface dark:bg-dark-bg rounded-lg shadow-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt w-8 h-8 text-muted dark:text-dark-muted mb-2"></i>
                                <p class="text-sm text-muted dark:text-dark-muted font-inter">
                                    Interactive map for {{ $event->location }}
                                </p>
                                <p class="text-xs text-muted dark:text-dark-muted font-inter mt-1">
                                    Map integration placeholder
                                </p>
                            </div>
                        </div>
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
    </script>

@endsection
