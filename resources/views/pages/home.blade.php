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
        [
            'eventName' => 'Tech Talk',
            'date' => '2025-08-22',
            'location' => 'Giza',
            'image' => 'images/login.webp',
        ],
    ];
@endphp



@section('main')
    <div
        class="min-h-[calc(100vh-140px)] flex flex-col justify-center items-center px-4 bg-background text-foreground dark:bg-dark-background dark:text-dark-foreground">
        <div class="space-y-6">
            <h1
                class="text-8xl text-center font-instrument sm:text-9xl font-extrabold text-error dark:text-dark-error tracking-tight drop-shadow-lg">
                Home Page
            </h1>


            <div class="flex gap-5">
                @foreach ($events as $event)
                    <x-card :eventName="$event['eventName']" :date="$event['date']" :location="$event['location']" :image="$event['image']" />
                @endforeach
            </div>

            <div class="flex justify-center w-full items-center">
                <a href=""
                    class="cursor-pointer px-4 py-2 bg-error hover:bg-error/90 text-white dark:bg-dark-error dark:hover:bg-dark-error/90 rounded-full shadow transition">
                    Show ALL Events
                </a>
            </div>
        </div>
    </div>
@endsection
