@php
    use Carbon\Carbon;

    $events = [
        [
            'id' => 1,
            'eventName' => 'Live Talk Night',
            'location' => 'Alexandria',
            'start-date' => '2025-08-20',
            'end-date' => '2025-08-24',
            'available_tickets' => 100,
            'status' => 'Active',
            'organizer_name' => 'Ahmed Khaled',
            'sessions' => [
                [
                    'title' => 'Keynote: Future of AI',
                    'start_time' => '2025-08-20 10:00',
                    'end_time' => '2025-08-20 11:30',
                    'speaker' => 'Dr. Sarah Ahmed',
                ],
                [
                    'title' => 'Panel: Tech Innovations',
                    'start_time' => '2025-08-20 14:00',
                    'end_time' => '2025-08-20 15:30',
                    'speaker' => 'Mohamed Ali',
                ],
            ],
        ],

    ];

    $eventID = request('id');
    $event = collect($events)->firstWhere('id', $eventID);

    $statusColors = [
        'Active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'Upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'Closed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
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
                    @if (isset($event['image']))
                        <div class="relative h-56 md:h-72">
                            <img src="{{ asset($event['image']) }}" alt="{{ $event['eventName'] }}"
                                class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 right-6">
                                <h1 class="text-2xl md:text-3xl font-bold font-heading text-white mb-2">
                                    {{ $event['eventName'] }}
                                </h1>
                                <div class="flex items-center gap-2 text-white/90">
                                    <i class="fas fa-map-marker-alt w-4 h-4"></i>
                                    <span class="text-sm font-inter">{{ $event['location'] }}</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gradient-to-r from-accent to-accent-hover px-6 py-12">
                            <h1 class="text-2xl md:text-3xl font-bold font-heading text-white mb-2">
                                {{ $event['eventName'] }}
                            </h1>
                            <div class="flex items-center gap-2 text-white/90">
                                <i class="fas fa-map-marker-alt w-4 h-4"></i>
                                <span class="text-sm font-inter">{{ $event['location'] }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="p-6">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 pb-6 border-b border-border dark:border-dark-border">
                            <div class="flex items-center gap-4">
                                <span
                                    class="flex items-center px-3 py-1 text-xs font-medium font-poppins rounded-full
                                    {{ $statusColors[$event['status']] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $event['status'] }}
                                </span>
                                <span class="text-sm font-inter {{ getTicketColor($event['available_tickets']) }}">
                                    {{ $event['available_tickets'] == 0 ? 'Sold Out' : $event['available_tickets'] . ' tickets' }}
                                </span>
                            </div>
                            @auth
                                @if (auth()->user()->role == 'speaker')
                                    <button onclick="openSpeakerModal()"
                                        class="px-6 py-2.5 bg-accent cursor-pointer hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                                        Apply as Speaker
                                    </button>
                                @elseif(auth()->user()->role == 'user')
                                    @if ($event['available_tickets'] > 0)
                                        <form action="{{ route('tickets.BookTicket', ['id' => $event['id']]) }}" method="POST"
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
                                    {{ Carbon::parse($event['start-date'])->format('M d, Y') }}
                                    @if ($event['start-date'] !== $event['end-date'])
                                        - {{ Carbon::parse($event['end-date'])->format('M d, Y') }}
                                    @endif
                                </p>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-semibold font-inter text-secondary dark:text-dark-secondary uppercase tracking-wide mb-2">
                                    <i class="fas fa-user mr-2"></i> Organizer
                                </h3>
                                <p class="text-primary dark:text-dark-primary font-manrope">
                                    {{ $event['organizer_name'] }}</p>
                            </div>

                        </div>

                        @if (!empty($event['sessions']))
                            <div class="mt-6 border-t border-border dark:border-dark-border pt-6">
                                <h3 class="text-lg font-semibold font-heading text-secondary dark:text-dark-secondary mb-4">
                                    <i class="fas fa-microphone-alt mr-2"></i> Event Sessions
                                </h3>
                                <div class="space-y-4">
                                    @foreach ($event['sessions'] as $session)
                                        <div class="bg-surface dark:bg-dark-bg rounded-lg p-4 shadow-sm">
                                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                                <div>
                                                    <h4
                                                        class="text-base font-semibold font-inter text-primary dark:text-dark-primary">
                                                        {{ $session['title'] }}
                                                    </h4>
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-user mr-1"></i> {{ $session['speaker'] }}
                                                    </p>
                                                    <p class="text-sm text-muted dark:text-dark-muted mt-1">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        {{ Carbon::parse($session['start_time'])->format('M d, Y H:i') }} -
                                                        {{ Carbon::parse($session['end_time'])->format('H:i') }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <span class="text-sm font-inter text-muted dark:text-dark-muted">
                                                        Duration:
                                                        {{ Carbon::parse($session['start_time'])->diffInMinutes($session['end_time']) }}
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
                        <div class="h-48 bg-surface dark:bg-dark-bg rounded-lg shadow-lg flex items-center justify-center">
                            <div class="text-center">
                                <i class="fas fa-map-marked-alt w-8 h-8 text-muted dark:text-dark-muted mb-2"></i>
                                <p class="text-sm text-muted dark:text-dark-muted font-inter">
                                    Interactive map for {{ $event['location'] }}
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

    <div id="speakerModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 hidden shadow-2xl">
        <div class="bg-bg dark:bg-dark-bg w-full max-w-xl rounded-xl p-10 relative">
            <button onclick="closeSpeakerModal()"
                class="absolute top-4 right-4 text-gray-200 rounded-full cursor-pointer hover:text-gray-100 bg-gray-400 dark:bg-gray-600 w-10 h-10 flex justify-center items-center">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="text-xl font-bold font-heading mb-4 text-primary dark:text-dark-primary">Request to be a Speaker</h2>

            <form action="{{ route('speaker.createproposal', ['id' => $event['id']]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                        Talk Title
                    </label>
                    <input type="text" name="title" required
                        class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                        Description
                    </label>
                    <textarea name="description" required rows="4"
                        class="w-full px-4 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium font-inter text-secondary dark:text-dark-secondary mb-1">
                        Upload CV (PDF)
                    </label>
                    <input type="file" name="cv" accept="application/pdf" required
                        class="w-full file:px-4 file:py-1 cursor-pointer file:border-none file:rounded-lg file:bg-accent file:text-white text-primary dark:text-dark-primary bg-white dark:bg-dark-bg">
                </div>

                <button type="submit"
                    class="w-full px-4 cursor-pointer py-2.5 bg-accent hover:bg-accent-hover text-white text-sm font-medium font-poppins rounded-lg transition-colors duration-200">
                    Submit Proposal
                </button>
            </form>
        </div>
    </div>

    <script>
        function openSpeakerModal() {
            document.getElementById('speakerModal').classList.remove('hidden');
        }

        function closeSpeakerModal() {
            document.getElementById('speakerModal').classList.add('hidden');
        }
    </script>

@endsection
