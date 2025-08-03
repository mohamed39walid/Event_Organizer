@extends('layouts.app')

@section('main')
    <div
        class="min-h-[calc(100vh-140px)] flex flex-col lg:flex-row items-center justify-center px-4 py-10 bg-background text-foreground dark:bg-dark-background dark:text-dark-foreground">

        <div class="bg-surface dark:bg-dark-surface w-full min-h-[700px] max-w-lg rounded-l-2xl shadow-lg p-8">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-4xl md:text-5xl font-bold text-center">
                Register
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-5 flex flex-col justify-center h-full">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-primary dark:text-dark-primary">Name</label>
                    <input id="name" name="name" type="text" placeholder="Your full name"
                        class="mt-2 w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('name') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('name')
                        <p class="text-error dark:text-dark-error  text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-primary dark:text-dark-primary">Email</label>
                    <input id="email" name="email" type="email" placeholder="you@example.com"
                        class="mt-2 w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('email') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('email')
                        <p class="text-error dark:text-dark-error  text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block text-sm font-medium text-primary dark:text-dark-primary">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter password"
                        class="mt-2 w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('password') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('password')
                        <p class="text-error dark:text-dark-error  text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation"
                        class="block text-sm font-medium text-primary dark:text-dark-primary">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                        placeholder="Confirm password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary" />
                </div>

                <div class="text-center">
                    <button type="submit"
                        class="w-full md:w-1/2 rounded-full py-3 text-lg font-semibold text-dark-primary dark:text-primary bg-primary dark:bg-dark-primary hover:bg-transparent hover:text-primary hover:dark:text-dark-primary border border-primary dark:border-dark-primary transition-all duration-300">
                        Register
                    </button>
                </div>

                <p class="text-sm text-muted dark:text-dark-muted text-center mt-4">
                    Already have an account?
                    <a class="text-accent hover:text-accent-hover underline" href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </div>

        <img src="{{ asset('images/register.webp') }}" alt="Register Image"
            class="object-cover  w-full min-h-[700px] max-w-md rounded-r-2xl hidden lg:block">

    </div>
@endsection
