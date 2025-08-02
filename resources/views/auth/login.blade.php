@extends('layouts.app')

@section('main')
    <div class="min-h-[calc(100vh-140px)] flex justify-center items-center px-4">
        <img src="{{ asset('images/login.webp') }}"
            class="object-cover w-full min-h-[600px] max-w-sm rounded-l-2xl hidden lg:block" alt="Login Image">

        <div
            class="bg-surface dark:bg-dark-surface w-full min-h-[600px] max-w-md text-white py-10 rounded-r-2xl flex flex-col items-center">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold text-center mb-6">Login</h1>

            <form method="POST" action="{{ route('login') }}"
                class="flex flex-col justify-center items-center h-full space-y-6 px-10 w-full">
                @csrf

                
                <label for="email" class="block w-full dark:text-dark-primary text-primary">
                    Email
                    <input id="email" name="email" type="email" required
                        class="mt-2 w-full rounded-md border p-3 @error('email') border-error dark:border-dark-error  @else border-gray-300 @enderror" />
                    @error('email')
                        <p class="text-error dark:text-dark-error  text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <label for="password" class="block w-full dark:text-dark-primary text-primary">
                    Password
                    <input id="password" name="password" type="password" required
                        class="mt-2 w-full rounded-md border p-3 @error('password') border-error dark:border-dark-error  @else border-gray-300 @enderror" />
                    @error('password')
                        <p class="text-error dark:text-dark-error  text-sm mt-1">{{ $message }}</p>
                    @enderror
                </label>

                <input type="submit" value="Login"
                    class="cursor-pointer border rounded-full py-3 w-1/2 text-xl font-bold text-dark-primary dark:text-primary hover:text-primary hover:dark:text-dark-primary bg-primary dark:bg-dark-primary hover:bg-transparent transition-all duration-300" />

                <p class="text-muted dark:text-dark-muted text-center mt-4">
                    Don't have an account?
                    <a class="text-accent hover:text-accent-hover underline" href="{{ route('register') }}">Register</a>
                </p>
            </form>
        </div>
    </div>
@endsection
