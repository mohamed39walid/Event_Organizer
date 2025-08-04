@extends('layouts.app')

@section('main')
    <div
        class="min-h-[calc(100vh-140px)] flex flex-col justify-center items-center px-4 bg-bg text-foreground dark:bg-dark-bg dark:text-dark-foreground">
        <div class="text-center space-y-6">
            <h1 class="text-8xl sm:text-9xl font-extrabold text-error dark:text-dark-error tracking-tight drop-shadow-lg">
                404
            </h1>

            <p class="text-3xl sm:text-4xl font-semibold">
                Page Not Found
            </p>

            <p class="text-base sm:text-lg text-muted dark:text-dark-muted max-w-md mx-auto">
                Oops! The page you're looking for doesn't exist or may have been moved. Let's get you back on track.
            </p>

            <a href="{{ route('home') }}"
                class="inline-flex items-center font-poppins gap-2 px-6 py-3 bg-accent hover:bg-accent-hover text-white font-medium rounded-full transition duration-200 ease-in-out shadow-md">
                <i class="fas fa-home text-lg"></i>
                Return Home
            </a>
        </div>
    </div>
@endsection
