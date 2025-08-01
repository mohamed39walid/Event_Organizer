@extends('layouts.app')

@section('main')
    <div class="h-full flex justify-center items-center px-4">
        <div
            class="bg-surface dark:bg-dark-surface w-sm h-[600px] text-white flex justify-center rounded-l-2xl overflow-hidden">
            <img src="{{ asset('images/login.png') }}" class="w-full h-full object-cover rounded-l-2xl" alt="Login Image">
        </div>

        <div class="bg-surface dark:bg-dark-surface w-lg h-[600px] text-white py-10 rounded-r-2xl flex flex-col">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold text-center mb-10">Login</h1>

            <form method="POST" action="{{ route('login') }}"
                class="flex flex-col justify-center items-center h-full space-y-8 px-10 w-full">
                @csrf

                <label for="email" class="block w-full  dark:text-dark-primary text-primary">
                    Email
                    <input id="email" name="email" type="email" required
                        class="mt-2 w-full rounded-md border border-gray-300 p-3 " />
                </label>

                <label for="password" class="block w-full  dark:text-dark-primary text-primary">
                    Password
                    <input id="password" name="password" type="password" required
                        class="mt-2 w-full rounded-md border border-gray-300 p-3 " />
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
