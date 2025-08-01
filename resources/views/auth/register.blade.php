@extends('layouts.app')

@section('main')
    <div class="h-full flex justify-center items-center px-4">

        <div class="bg-surface dark:bg-dark-surface w-lg h-[600px] text-white py-10 rounded-l-2xl flex flex-col">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold text-center mb-10">Register
            </h1>

            <form method="POST" action="{{ route('register') }}"
                class="flex flex-col justify-center items-center h-full space-y-5 px-10 w-full">
                @csrf

                <label for="name" class="block w-full dark:text-dark-primary text-primary">
                    Name
                    <input id="name" name="name" type="name"
                        class="mt-2 w-full rounded-md border border-gray-300 p-3" />
                </label>

                <label for="email" class="block w-full dark:text-dark-primary text-primary">
                    Email
                    <input id="email" name="email" type="email"
                        class="mt-2 w-full rounded-md border border-gray-300 p-3" />
                </label>

                <label for="password" class="block w-full dark:text-dark-primary text-primary">
                    Password
                    <input id="password" name="password" type="password"
                        class="mt-2 w-full rounded-md border border-gray-300 p-3" />
                </label>

                <input type="submit" value="Register"
                    class="cursor-pointer border rounded-full py-3 w-1/2 text-xl font-bold text-dark-primary dark:text-primary hover:text-primary hover:dark:text-dark-primary bg-primary dark:bg-dark-primary hover:bg-transparent transition-all duration-300" />

                <p class="text-muted dark:text-dark-muted text-center mt-4">
                    Do have an account?
                    <a class="text-accent hover:text-accent-hover underline" href="{{ route('login') }}">Login</a>
                </p>
            </form>
        </div>

        <div
            class="bg-surface dark:bg-dark-surface w-sm h-[600px] text-white flex justify-center rounded-r-2xl overflow-hidden">
            <img src="{{ asset('images/register.png') }}" class="w-full h-full object-cover rounded-r-2xl"
                alt="Register Image">
        </div>
    </div>
@endsection
