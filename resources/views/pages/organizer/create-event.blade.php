@extends('layouts.app')

@section('main')
    <div class="min-h-[calc(100vh-140px)] flex justify-center items-center px-4">
        <div
            class="bg-surface dark:bg-dark-surface w-full min-h-[600px] max-w-3xl text-white py-10 px-10 rounded-2xl flex flex-col">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold mb-6">Create New Event</h1>

            <form action="{{ route('events.store-event') }}" enctype="multipart/form-data" method="POST"
                class="spacae-y-6 px-4">
                @csrf

                <div class="mt-5">
                    <label for="event_name" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        Event Name
                    </label>
                    <input id="event_name" name="event_name" type="text" value="{{ old('event_name') }}"
                        placeholder="e.g., Live Talk Night"
                        class="w-full rounded-md border p-3 @error('event_name') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('event_name')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="location" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        Location
                    </label>
                    <input id="location" name="location" type="text" value="{{ old('location') }}"
                        placeholder="e.g., Cairo International Stadium"
                        class="w-full rounded-md border p-3 @error('location') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('location')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-5">
                    <label for="available_tickets" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                        Available Tickets
                    </label>
                    <input id="available_tickets" name="available_tickets" type="number" min="1"
                        value="{{ old('available_tickets') }}" placeholder="e.g., 100"
                        class="w-full rounded-md border p-3 @error('available_tickets') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('available_tickets')
                        <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col md:flex-row justify-between w-full gap-6 mt-6">
                    <div class="w-full">
                        <label for="start_date" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                            Start Date
                        </label>
                        <input id="start_date" name="start_date" type="date" min="{{ now()->toDateString() }}"
                            value="{{ old('start_date', now()->toDateString()) }}"
                            class="w-full rounded-md border p-3 @error('start_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                        @error('start_date')
                            <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="w-full">
                        <label for="end_date" class="block text-primary dark:text-dark-primary font-semibold mb-2">
                            End Date
                        </label>
                        <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}"
                            class="w-full rounded-md border p-3 @error('end_date') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                        @error('end_date')
                            <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Upload Image</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-accent file:text-white hover:file:bg-accent-hover transition-all cursor-pointer">
                        @error('image')
                            <p class="text-sm text-error dark:text-dark-error mt-1">{{ $message }}</p>
                        @enderror
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit"
                        class="cursor-pointer border rounded-full py-3 px-6 text-xl font-bold text-dark-primary dark:text-primary hover:text-primary hover:dark:text-dark-primary bg-primary dark:bg-dark-primary hover:bg-transparent transition-all duration-300 w-full md:w-1/4">
                        Create
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
