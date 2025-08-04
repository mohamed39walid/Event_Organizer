@extends('layouts.app')

@php
    $filteredTickets = $tickets->filter(function ($ticket) {
        $search = request('search');
        return str_contains(strtolower($ticket->event->event_name), strtolower($search)) ||
            str_contains(strtolower($ticket->event->location), strtolower($search));
    });
@endphp


@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-16 px-4 text-foreground dark:text-dark-foreground">
        <div class="max-w-7xl mx-auto space-y-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 dark:text-white">
                    My Tickets
                </h2>

                <div class="flex flex-col md:flex-row items-center gap-4">
                    <form action="" method="get" class="w-full md:w-auto">
                        <div class="relative">
                            <input type="text" placeholder="Search ticket..." name="search"
                                value="{{ request('search') }}"
                                class="w-full md:w-72 px-5 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-surface text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition">
                            <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </form>
                </div>
            </div>

            <div>
                @if ($filteredTickets->isNotEmpty())
                    @foreach ($filteredTickets as $ticket)
                        <div class="p-4 mb-4 bg-dark-secondary dark:bg-secondary rounded-2xl">
                            <h2 class="text-lg font-semibold">{{ $ticket->event->event_name }}</h2>
                            <p>Start Date: {{ $ticket->event->start_date }}</p>
                            <p>End Date: {{ $ticket->event->end_date }}</p>
                            <p>Location: {{ $ticket->event->location }}</p>
                            <p>Ticket ID: {{ $ticket->id }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mt-20">No ticket called '{{ request('search') }}' found</p>
                @endif

            </div>

        </div>
    </div>
@endsection
