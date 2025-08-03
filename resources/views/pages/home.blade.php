@extends('layouts.app')

@php
    $events = [
        [
            'eventName' => 'Summer Festival',
            'date' => '2025-08-18',
            'location' => 'Cairo',
            'image' => 'images/register.webp',
        ],
        [
            'eventName' => 'Live Concert',
            'date' => '2025-08-20',
            'location' => 'Alexandria',
            'image' => 'images/Concert.jpg',
        ],
    ];
@endphp

@section('main')
    <section class="min-h-[calc(100vh-80px)] flex items-center bg-bg dark:bg-dark-bg px-6">
        <div class="max-w-7xl mx-auto w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <div class="text-center lg:text-left">

                    <h1 class="text-5xl lg:text-6xl font-bold text-primary dark:text-dark-primary mb-6">
                        Discover Amazing
                        <span class="text-accent">Events</span>
                    </h1>

                    <p class="text-xl text-muted dark:text-dark-muted mb-8 max-w-lg">
                        Connect with inspiring speakers and changemakers. Join meaningful discussions that shape the future.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#events"
                            class="px-8 py-3 bg-accent hover:bg-accent-hover text-white font-semibold rounded-lg transition-colors">
                            Explore Latest Events
                        </a>

                    </div>
                </div>
                <div class="flex justify-center lg:justify-end">
                    <img src="{{ asset('images/hero-talks.png') }}" alt="Event Talks Illustration"
                        class="max-w-full h-auto rounded-lg shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="py-20 bg-surface dark:bg-dark-surface px-6">
        <div class="max-w-6xl mx-auto">

            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-primary dark:text-dark-primary mb-4">
                    Latest <span class="text-accent">Events</span>
                </h2>
                <p class="text-lg text-muted dark:text-dark-muted max-w-2xl mx-auto">
                    Join our curated selection of events designed to inspire and connect you with like-minded individuals.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach ($events as $event)
                    <x-card :eventName="$event['eventName']" :date="$event['date']" :location="$event['location']" :image="$event['image']" />
                @endforeach
            </div>

            <div class="text-center">
                <a href="{{ route('events') }}"
                    class="inline-flex items-center px-8 py-4 bg-error hover:bg-error/90 text-white font-semibold rounded-lg transition-colors">
                    <i class="fas fa-eye mr-2"></i>
                    Show All Events
                </a>
            </div>
        </div>
    </section>
@endsection
