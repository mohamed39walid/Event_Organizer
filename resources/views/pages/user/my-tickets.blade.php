@extends('layouts.app')

@php
    use Carbon\Carbon;

    $filteredTickets = $tickets->filter(function ($ticket) {
        $search = request('search');
        return str_contains(strtolower($ticket->event->event_name), strtolower($search)) ||
            str_contains(strtolower($ticket->event->location), strtolower($search));
    });
@endphp

@section('main')
    <div class="max-w-7xl mx-auto space-y-8 min-h-screen mt-10">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <h2 class="text-3xl font-bold font-heading tracking-tight">
                My Tickets
            </h2>
            <form action="" method="get" class="w-full sm:w-auto">
                <div class="relative">
                    <input type="text" placeholder="Search tickets..." name="search" value="{{ request('search') }}"
                        class="w-full md:w-72 px-5 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-surface text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition">
                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </form>
        </div>

        <!-- Tickets List -->
        <div class="grid gap-6">
            @foreach ($filteredTickets as $ticket)
                <div
                    class="bg-dark-secondary dark:bg-secondary rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-start">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $ticket->event->event_name }}
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Location:</span>
                                    {{ $ticket->event->location }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Start Date:</span>
                                    {{ Carbon::parse($ticket->event->start_date)->format('M d') }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">End Date:</span>
                                    {{ Carbon::parse($ticket->event->end_date)->format('M d') }}
                                </p>
                            </div>
                        </div>
                        <form action="{{ route('tickets.UnBookTicket', ['id' => $ticket->id]) }}" method="POST"
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2 cursor-pointer px-4 bg-orange-900 hover:bg-orange-900/90 text-white rounded-lg transition-colors text-center hover:ring-2 hover:ring-accent/40 focus:outline-none focus:ring-2 focus:ring-accent">
                                Unbook
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if (empty($filteredTickets))
                <div class="text-center text-gray-500 dark:text-gray-400 w-full">
                    No tickets found matching "{{ request('search') }}"
                </div>
            @endif
        </div>
    </div>
@endsection
