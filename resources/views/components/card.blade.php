@php
    use Carbon\Carbon;

    $statusColors = [
        'Active' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'Upcoming' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        'Closed' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    ];

    $ticketColors = [
        'Available' => 'text-green-600 dark:text-green-400',
        'Limited' => 'text-orange-600 dark:text-orange-400',
        'Few Left' => 'text-orange-600 dark:text-orange-400',
        'Sold Out' => 'text-red-600 dark:text-red-400',
    ];
@endphp

<div class="w-full max-w-sm bg-surface dark:bg-dark-surface rounded-4xl shadow-lg overflow-hidden h-fit  ">
    <div class="relative">
        <div class="absolute inset-0 bg-black/20 dark:bg-black/50 rounded-4xl rounded-t-4xl z-10"></div>

        @if ($image)
            <img src="{{ asset($image) }}" alt="{{ $eventName }}" class="w-full h-[250px] rounded-4xl object-cover">
        @endif

        <div class="absolute top-4 right-4 z-20">
            <span
                class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $status }}
            </span>
        </div>
    </div>

    <div class="p-6">
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

        <div class="space-y-2 mb-4">
            <div class="flex justify-between items-center text-sm">
                <span class="text-muted dark:text-dark-muted">Duration:</span>
                <span class="text-foreground dark:text-dark-foreground">
                    {{ Carbon::parse($date)->format('M d') }} - {{ Carbon::parse($endDate)->format('M d') }}
                </span>
            </div>

            <div class="flex justify-between items-center text-sm">
                <span class="text-muted dark:text-dark-muted">Organizer:</span>
                <span class="text-foreground dark:text-dark-foreground">{{ $organizer }}</span>
            </div>

            <div class="flex justify-between items-center text-sm">
                <span class="text-muted dark:text-dark-muted">Tickets:</span>
                <span class="font-medium {{ $ticketColors[$tickets] ?? 'text-gray-600' }}">
                    {{ $tickets }}
                </span>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 dark:border-gray-700 w-full">
            @if ($tickets === 'Sold Out' || $status === 'Closed')
                <button disabled
                    class="w-full py-2 px-4 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 rounded-lg cursor-not-allowed">
                    {{ $tickets === 'Sold Out' ? 'Sold Out' : 'Event Closed' }}
                </button>
            @else
                <form action="{{ route('tickets.BookTicket', ['id' => 1]) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full py-2 px-4 bg-accent hover:bg-accent/90 cursor-pointer text-white rounded-lg transition-colors text-center">
                        Book Now
                    </button>
                </form>
            @endif
        </div>
    </div>

</div>
