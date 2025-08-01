@extends('layouts.app')

@section('main')
    <div class="h-full flex flex-col justify-center items-center px-4">
        <div class="text-center space-y-4">
            <h1 class="text-6xl font-bold text-error dark:text-dark-error">
                404
            </h1>

            <p class="text-2xl font-semibold">Page Not Found</p>

            <p class="text-muted dark:text-dark-muted">
                Oops! The page you're looking for doesn't exist or has been moved.
            </p>

            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-accent hover:bg-accent-hover text-white rounded-full transition">
                <i class="fas fa-home"></i>
                Return Home
            </a>
        </div>
    </div>
@endsection
