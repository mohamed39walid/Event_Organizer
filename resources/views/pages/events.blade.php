@extends('layouts.app')

@php
    $events = [
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
        [
            'eventName' => 'Summer Festival',
            'date' => '2025-08-18',
            'location' => 'Cairo',
            'image' => 'images/register.webp',
        ],
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
        [
            'eventName' => 'Summer Festival',
            'date' => '2025-08-18',
            'location' => 'Cairo',
            'image' => 'images/register.webp',
        ],
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
        [
            'eventName' => 'Summer Festival',
            'date' => '2025-08-18',
            'location' => 'Cairo',
            'image' => 'images/register.webp',
        ],
        [
            'eventName' => 'Live Talk Night',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
    ];
@endphp

@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-16 px-4 text-foreground dark:text-dark-foreground">
        <div class="max-w-7xl mx-auto space-y-10">

            {{-- Header & Search --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 dark:text-white">
                    All Events
                </h2>

                <form action="" class="w-full md:w-auto mr-14">
                    @csrf
                    <div class="relative">
                        <input type="text" placeholder="Search events..."
                            class="w-full md:w-72 px-5 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-surface text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition">
                        <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </form>
            </div>

            {{-- Event Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($events as $event)
                    <x-card :eventName="$event['eventName']" :date="$event['date']" :location="$event['location']" :image="$event['image']" />
                @endforeach
            </div>

        </div>
    </div>
@endsection
