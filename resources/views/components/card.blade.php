@php
    use Carbon\Carbon;

    $statusColors = [
        'Available' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'Upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'Closed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    ];

    switch (true) {
        case $tickets == 0:
            $ticketColor = 'text-red-600 dark:text-red-400';
            break;
        case $tickets <= 10:
            $ticketColor = 'text-orange-700 dark:text-orange-500';
            break;
        case $tickets <= 30:
            $ticketColor = 'text-yellow-600 dark:text-yellow-400';
            break;
        case $tickets <= 99:
            $ticketColor = 'text-blue-600 dark:text-blue-400';
            break;
        case $tickets <= 199:
            $ticketColor = 'text-green-600 dark:text-green-400';
            break;
        default:
            $ticketColor = 'text-emerald-600 dark:text-emerald-400';
    }
@endphp
{{-- Adam Ahmed -> Added A little animation on the cards --}}
<div
    class="w-full max-w-sm bg-surface dark:bg-dark-surface rounded-4xl shadow-lg overflow-hidden h-fit
            transform transition-transform duration-300 hover:-translate-y-2 hover:scale-[1.00] hover:shadow-2xl">

    {{-- <div class="w-full max-w-sm bg-surface dark:bg-dark-surface rounded-4xl shadow-lg overflow-hidden h-fit"> --}}
    <div class="relative">
        <div class="absolute inset-0 bg-black/20 dark:bg-black/50 rounded-t-4xl z-10"></div>

        @if ($image)
            <img src="{{ asset('storage/events/' . $image) }}" alt="{{ $eventName ?? 'Event image' }}"
                class="w-full h-[200px] object-cover rounded-t-4xl transition-transform duration-300 hover:scale-105">
        @endif

@auth
    @if (auth()->user()->username == $organizer)
        <div
            class="cursor-pointer absolute top-4 left-4 z-20 w-10 h-10 flex justify-center items-center bg-white/30 rounded-full text-red-900 hover:text-red-400">
            <form id="delete-event-form" action="{{ route('organizer.events.destroy', ['id' => $eventid]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" id="delete-event-btn">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    @endif
@endauth


        <div class="absolute top-4 right-4 z-20">
            <span
                class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $status }}
            </span>
        </div>
    </div>

    <div class="pb-8 px-8 {{ $image ? 'pt-8' : 'pt-14' }}">
        <div class="flex items-center gap-4 mb-4">
            <div class="flex flex-col items-center justify-center w-16 h-16 bg-accent/10 dark:bg-accent/20 rounded-2xl">
                <span class="text-sm font-medium text-accent dark:text-accent">
                    {{ Carbon::parse($date)->format('M') }}
                </span>
                <span class="text-xl font-bold text-accent dark:text-accent">
                    {{ Carbon::parse($date)->format('d') }}
                </span>
            </div>

            <div class="flex-1">
                <h3 class="font-heading text-secondary dark:text-dark-secondary text-lg font-semibold line-clamp-2">
                    {{ $eventName }}
                </h3>
                <p class="text-sm text-muted dark:text-dark-muted mt-1">
                    <i class="fa-solid fa-location-dot mr-1"></i>{{ $location }}
                </p>
            </div>
        </div>

        <div class="space-y-2 mb-4 text-sm">
            <div class="flex justify-between items-center">
                <span class="text-muted dark:text-dark-muted">Duration:</span>
                <span class="font-medium text-accent dark:text-accent">
                    {{ Carbon::parse($date)->format('M d') }} → {{ Carbon::parse($endDate)->format('M d') }}
                </span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-muted dark:text-dark-muted">Organizer:</span>
                <span class="text-foreground dark:text-dark-foreground">{{ $organizer }}</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-muted dark:text-dark-muted">Tickets:</span>
                <span class="font-medium font-inter {{ $ticketColor }}">
                    @if ($tickets === 0 || $tickets === '0')
                        Sold Out
                    @else
                        {{ $tickets }} left
                    @endif
                </span>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 w-full">
            @auth
                @if (auth()->user()->role === 'organizer')
                    <a href="{{ route('event-details', ['id' => $eventid]) }}"
                        class="block w-full py-2 px-4 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-center transition ">
                        Show Event
                    </a>
                @elseif (auth()->user()->role === 'user' || auth()->user()->role === 'speaker')
                    <div class="flex gap-4">
                        @if ($tickets === 'Sold Out' || $status === 'Closed')
                            <button disabled aria-disabled="true"
                                class="w-full py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 rounded-lg cursor-not-allowed">
                                {{ $tickets === 'Sold Out' ? 'Sold Out' : 'Event Closed' }}
                            </button>
                        @else
                            @if (!auth()->user()->tickets->contains('event_id', $eventid))
                                <form action="{{ route('tickets.BookTicket', ['id' => $eventid]) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full py-2 cursor-pointer px-4 bg-accent hover:bg-accent/90 text-white rounded-lg transition-colors text-center hover:ring-2 hover:ring-accent/40 focus:outline-none focus:ring-2 focus:ring-accent">
                                        Book Now
                                    </button>
                                </form>
                            @endif
                            @php
                                $user = auth()->user();
                                $ticket = $user->tickets->firstWhere('event_id', $eventid);
                            @endphp

                            @if ($ticket)
                                <form action="{{ route('tickets.UnBookTicket', ['id' => $ticket->id]) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-2 cursor-pointer px-4 bg-orange-900 hover:bg-orange-900/90 text-white rounded-lg transition-colors text-center hover:ring-2 hover:ring-accent/40 focus:outline-none focus:ring-2 focus:ring-accent">
                                        Unbook
                                    </button>
                                </form>
                            @endif
                        @endif

                        <a href="{{ route('event-details', ['id' => $eventid]) }}"
                            class="w-full py-2 px-4 cursor-pointer bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-center transition ">
                            Show Event
                        </a>
                    </div>
                @elseif (auth()->user()->role === 'speaker')
                    <a href="{{ route('event-details', ['id' => $eventid]) }}"
                        class="block w-full py-2 px-4 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-center transition ">
                        Show Event
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}"
                    class="block w-full py-2 px-4 bg-accent hover:bg-accent/90 text-white rounded-lg text-center transition hover:ring-2 hover:ring-accent">
                    Login to Book
                </a>
            @endauth
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('delete-event-form');

    form.addEventListener('submit', function (e) {
        e.preventDefault(); // prevent default form submit

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // submit the form if confirmed
            }
        });
    });
});
</script>