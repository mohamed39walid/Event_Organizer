@extends('layouts.app')

@php
    $search = strtolower(request('search'));
    $filteredproposals = $proposals->filter(function ($proposal) use ($search) {
        return str_contains(strtolower($proposal->title), $search) ||
            str_contains(strtolower($proposal->description), $search) ||
            str_contains(strtolower($proposal->event->event_name), $search) ||
            str_contains(strtolower($proposal->event->location), $search) ||
            str_contains(strtolower($proposal->event->start_date), $search) ||
            str_contains(strtolower($proposal->event->end_date), $search) ||
            str_contains(strtolower(optional($proposal->speaker)->fullname ?? ''), $search) ||
            str_contains(strtolower($proposal->status), $search);
    });
@endphp


@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-16 px-4 text-foreground dark:text-dark-foreground">
        <div class="max-w-7xl mx-auto space-y-10">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 dark:text-white">
                    My proposals
                </h2>

                <div class="flex flex-col md:flex-row items-center gap-4">
                    <form action="" method="get" class="w-full md:w-auto">
                        <div class="relative">
                            <input type="text" placeholder="Search proposal..." name="search"
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
                @if ($filteredproposals->isNotEmpty())
                    @foreach ($filteredproposals as $proposal)
                        <div class="p-4 mb-4 bg-dark-secondary dark:bg-secondary rounded-2xl">
                            <h2 class="text-lg font-semibold">{{ $proposal->title }}</h2>
                            <p>Description: {{ $proposal->description }}</p>
                            <p>Event Name: {{ $proposal->event->event_name }}</p>
                            <p>
                                CV:
                                <a href="{{ asset('storage/' . $proposal->cv) }}" target="_blank"
                                    class="text-blue-500 underline">
                                    View CV
                                </a>
                            </p>
                            <p>Speaker Name: {{ $proposal->speaker->fullname }}</p>
                            <p>Start Date: {{ $proposal->event->start_date }}</p>
                            <p>End Date: {{ $proposal->event->end_date }}</p>
                            <p>Location: {{ $proposal->event->location }}</p>
                            <p>proposal ID: {{ $proposal->id }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="text-center mt-20">No proposal called '{{ request('search') }}' found</p>
                @endif

            </div>

        </div>
    </div>
@endsection
