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

    $statusColors = [
        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'approved' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
        'rejected' => 'bg-rose-100 text-rose-800 dark:bg-rose-900 dark:text-rose-300',
    ];
@endphp

@section('main')
    <div class="max-w-7xl mx-auto space-y-8 min-h-screen mt-10">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <h2 class="text-3xl font-bold font-heading tracking-tight">
                My Proposals
            </h2>
            <form action="" method="get" class="w-full sm:w-auto">
                <div class="relative">
                    <input type="text" placeholder="Search proposals..." name="search" value="{{ request('search') }}"
                        class="w-full md:w-72 px-5 py-2 rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-dark-surface text-gray-800 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent transition">
                    <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </form>
        </div>

        <!-- Proposals List -->
        <div class="grid gap-6">
            @if ($filteredproposals->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400 w-full">
                    No proposals found{{ request('search') ? ' for "' . request('search') . '"' : '' }}.
                </div>
            @else
                @foreach ($filteredproposals as $proposal)
                    <div
                        class="bg-dark-secondary dark:bg-secondary rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6">
                        <div class="space-y-4 relative">
                            <div class="flex justify-between items-start">
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $proposal->title }}
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Description:</span>
                                        {{ Str::limit($proposal->description, 150) }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Event:</span>
                                        {{ $proposal->event->event_name }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Speaker:</span>
                                        {{ optional($proposal->speaker)->fullname ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Location:</span>
                                        {{ $proposal->event->location }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">Start Date:</span>
                                        {{ $proposal->event->start_date }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        <span class="font-medium">End Date:</span>
                                        {{ $proposal->event->end_date }}
                                    </p>
                                </div>
                            </div>

                            <div class="absolute top-2 right-2 z-20">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$proposal->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($proposal->status) }}
                                </span>
                            </div>

                            <div>
                                <a href="{{ asset('storage/' . $proposal->cv) }}" target="_blank"
                                    class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                    View CV
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
