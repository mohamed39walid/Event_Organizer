@extends('layouts.app')

@php
    use Carbon\Carbon;

    $search = request('search');
    $filteredTickets = $tickets
        ->when($search, function ($query) use ($search) {
            return $query->filter(function ($ticket) use ($search) {
                $searchTerm = strtolower($search);
                return str_contains(strtolower($ticket->event->event_name), $searchTerm) ||
                    str_contains(strtolower($ticket->event->location), $searchTerm);
            });
        })
        ->sortByDesc('created_at');
@endphp

@section('main')
    <div class="max-w-7xl mx-auto space-y-8 min-h-screen mt-10 px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold font-heading tracking-tight text-primary dark:text-dark-primary">
                    My Tickets
                </h1>
                <p class="mt-2 text-muted dark:text-dark-muted font-manrope">
                    Manage your event bookings
                </p>
            </div>

            <!-- Search Form -->
            <form method="GET" class="w-full sm:w-auto" role="search" aria-label="Search tickets">
                <div class="relative">
                    <label for="search" class="sr-only">Search tickets</label>
                    <input type="search" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Search events or locations..."
                        class="w-full md:w-72 px-5 py-3 pl-12 rounded-lg border border-border dark:border-dark-border bg-surface dark:bg-dark-surface text-primary dark:text-dark-primary placeholder-muted dark:placeholder-dark-muted focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-200 font-urbanist"
                        autocomplete="off">
                    <div
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 text-muted dark:text-dark-muted pointer-events-none">
                        <i class="fas fa-search text-sm"></i>
                    </div>
                </div>
            </form>
        </header>

        <!-- Tickets Grid -->
        <main>
            @if ($filteredTickets->isNotEmpty())
                <div class="grid gap-6 sm:gap-8">
                    @foreach ($filteredTickets as $ticket)
                        <article
                            class="group bg-surface dark:bg-dark-surface rounded-xl shadow-sm hover:shadow-lg border border-border/50 dark:border-dark-border/50 transition-all duration-300 overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <!-- Ticket Header -->
                                <header class="flex justify-between items-start mb-6">
                                    <div class="flex-1">
                                        <h2
                                            class="text-xl sm:text-2xl font-bold font-heading text-secondary dark:text-dark-secondary mb-2 transition-colors">
                                            {{ $ticket->event->event_name }}
                                        </h2>
                                        <div
                                            class="flex items-center gap-2 text-sm text-muted dark:text-dark-muted font-urbanist">
                                            <i class="fas fa-calendar-alt text-sm"></i>
                                            <span>Booked {{ $ticket->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Ticket Status Badge -->
                                    <div class="ml-4 flex-shrink-0">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium font-poppins bg-success/10 text-success dark:bg-dark-success/10 dark:text-dark-success border border-success/20 dark:border-dark-success/20">
                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                            Confirmed
                                        </span>
                                    </div>
                                </header>

                                <!-- Event Details -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                                    <!-- Location -->
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <i class="fas fa-map-marker-alt text-accent text-lg"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-muted dark:text-dark-muted font-urbanist uppercase tracking-wide">
                                                Location
                                            </p>
                                            <p class="text-primary dark:text-dark-primary font-manrope font-medium">
                                                {{ $ticket->event->location }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Dates -->
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <i class="fas fa-calendar-week text-accent text-lg"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-muted dark:text-dark-muted font-urbanist uppercase tracking-wide">
                                                Event Dates
                                            </p>
                                            <div class="space-y-1 font-manrope">
                                                <p class="text-primary dark:text-dark-primary font-medium">
                                                    <span class="text-muted dark:text-dark-muted">From:</span>
                                                    {{ Carbon::parse($ticket->event->start_date)->format('M j, Y') }}
                                                </p>
                                                <p class="text-primary dark:text-dark-primary font-medium">
                                                    <span class="text-muted dark:text-dark-muted">To:</span>
                                                    {{ Carbon::parse($ticket->event->end_date)->format('M j, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <footer class="pt-6 border-t border-border/30 dark:border-dark-border/30">
                                    <form action="{{ route('tickets.UnBookTicket', $ticket->id) }}" method="POST"
                                        class="w-full"
                                        onsubmit="return confirm('Are you sure you want to unbook this ticket? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full cursor-pointer sm:w-auto px-6 py-3 bg-error hover:bg-error/90 dark:bg-dark-error dark:hover:bg-dark-error/90 text-white rounded-lg font-medium font-poppins transition-all duration-200 hover:shadow-lg hover:shadow-error/25 dark:hover:shadow-dark-error/25 focus:outline-none focus:ring-2 focus:ring-error/50 focus:ring-offset-2 focus:ring-offset-surface dark:focus:ring-offset-dark-surface transform"
                                            aria-label="Unbook {{ $ticket->event->event_name }}">
                                            Unbook Ticket
                                        </button>
                                    </form>
                                </footer>
                            </div>
                        </article>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="mx-auto max-w-md">
                        <i class="fas fa-folder-open text-5xl text-muted dark:text-dark-muted mb-6"></i>
                        <h3 class="text-xl font-bold font-heading text-secondary dark:text-dark-secondary mb-2">
                            No tickets found
                        </h3>
                        <p class="text-muted dark:text-dark-muted font-manrope mb-6">
                            {{ $search ? 'No tickets match your search criteria.' : "You haven't booked any tickets yet." }}
                        </p>
                        @if ($search)
                            <a href="{{ route('tickets.my-tickets') }}"
                                class="inline-flex items-center px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium font-poppins transition-colors focus:outline-none focus:ring-2 focus:ring-accent/50 focus:ring-offset-2 focus:ring-offset-bg dark:focus:ring-offset-dark-bg">
                                <i class="fas fa-arrow-left mr-2"></i> View all tickets
                            </a>
                        @else
                            <a href="{{ route('events') }}"
                                class="inline-flex items-center px-4 py-2 bg-accent hover:bg-accent-hover text-white rounded-lg font-medium font-poppins transition-colors focus:outline-none focus:ring-2 focus:ring-accent/50 focus:ring-offset-2 focus:ring-offset-bg dark:focus:ring-offset-dark-bg">
                                <i class="fas fa-calendar-alt mr-2"></i> Browse Events
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </main>
    </div>
@endsection
