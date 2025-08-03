@extends('layouts.app')
@php
    $events = [
        [
            'id' => 1,
            'eventName' => 'Live Talk Night',
            'location' => 'Alexandria',
            'start-date' => '2025-08-20',
            'end-date' => '2025-08-24',
            'available_tickets' => 'Available',
            'status' => 'Active',
            'organizer_name' => 'Ahmed Khaled',
        ],
        [
            'id' => 2,
            'eventName' => 'Live Talk Night',
            'location' => 'Alexandria',
            'start-date' => '2025-08-20',
            'end-date' => '2025-08-24',
            'available_tickets' => 'Available',
            'status' => 'Active',
            'organizer_name' => 'Ahmed Khaled',
        ],
        [
            'id' => 3,
            'eventName' => 'Summer Festival',
            'location' => 'Cairo',
            'start-date' => '2025-08-18',
            'end-date' => '2025-08-20',
            'available_tickets' => 'Limited',
            'status' => 'Upcoming',
            'organizer_name' => 'Event Pro',
            'image' => 'images/Concert.jpg',
        ],
        [
            'id' => 4,
            'eventName' => 'Night Beats',
            'location' => 'Alexandria',
            'start-date' => '2025-09-01',
            'end-date' => '2025-09-02',
            'available_tickets' => 'Sold Out',
            'status' => 'Closed',
            'organizer_name' => 'Sound Wave',
            'image' => 'images/Concert.jpg',
        ],
        [
            'id' => 5,
            'eventName' => 'Tech Summit 2025',
            'location' => 'Cairo',
            'start-date' => '2025-08-25',
            'end-date' => '2025-08-27',
            'available_tickets' => 'Available',
            'status' => 'Active',
            'organizer_name' => 'Future Tech',
        ],
        [
            'id' => 6,
            'eventName' => 'Culture Connect',
            'location' => 'Alexandria',
            'start-date' => '2025-09-10',
            'end-date' => '2025-09-12',
            'available_tickets' => 'Few Left',
            'status' => 'Upcoming',
            'organizer_name' => 'Culture Org',
            'image' => 'images/Concert.jpg',
        ],
        [
            'id' => 7,
            'eventName' => 'Startup Demo Day',
            'location' => 'Cairo',
            'start-date' => '2025-08-22',
            'end-date' => '2025-08-22',
            'available_tickets' => 'Available',
            'status' => 'Upcoming',
            'organizer_name' => 'Startup Egypt',
            'image' => 'images/Concert.jpg',
        ],
    ];

    $search = request('search');
    if ($search) {
        $events = array_filter($events, function ($event) {
            $search = strtolower(request('search'));
            return str_contains(strtolower($event['eventName']), $search) ||
                str_contains(strtolower($event['location']), $search) ||
                str_contains(strtolower($event['organizer_name']), $search) ||
                str_contains(strtolower($event['status']), $search);
        });
    }

@endphp


@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-16 px-4 text-foreground dark:text-dark-foreground">
        <div class="max-w-7xl mx-auto space-y-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 dark:text-white">
                    All Events
                </h2>

                <form action="" method="get" class="w-full md:w-auto mr-8">
                    <div class="relative">
                        <input type="text" placeholder="Search events..." name="search" value="{{ request('search') }}"
                            class="w-full md:w-72 px-5 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-surface text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition">
                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </form>
            </div>

            <div class="columns-3 gap-4 space-y-10">
                @foreach ($events as $event)
                    <x-card :eventid="$event['id']" :eventName="$event['eventName']" :date="$event['start-date']" :endDate="$event['end-date']" :location="$event['location']" :image="$event['image'] ?? ''"
                        :tickets="$event['available_tickets']" :status="$event['status']" :organizer="$event['organizer_name']" />
                @endforeach
            </div>
            @if (empty($events))
                <div class="text-center text-gray-500 dark:text-gray-400 w-full">
                    No events found matching "{{ request('search') }}"
                </div>
            @endif


        </div>
    </div>
@endsection
