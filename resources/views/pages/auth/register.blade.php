@extends('layouts.app')
{{-- @php
    $fakeErrors = new \Illuminate\Support\MessageBag([
        'fname' => ['First name is required.'],
        'lname' => ['Last name must be at least 3 characters.'],
        'password' => ['Password must be at least 3 characters.'],
        'email' => ['Invalid email address.'],
        'role' => ['Please select a valid role.'],
        'userName' => ['Username must be unique.'],
    ]);
    $errors = new \Illuminate\Support\ViewErrorBag();
    $errors->put('default', $fakeErrors);
@endphp --}}

@section('main')
    <div
        class="py-3 min-h-[calc(100vh-140px)] flex items-center justify-center bg-bg text-foreground dark:bg-dark-bg dark:text-dark-foreground px-4">
        <div
            class="bg-surface dark:bg-dark-surface w-full min-h-[700px] max-w-xl {{ $errors->any() ? 'rounded-2xl' : 'rounded-l-2xl' }} shadow-md px-8 py-10">
            <h1 class="text-secondary dark:text-dark-secondary font-heading text-5xl font-bold text-center mb-8">
                Create Account
            </h1>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="fname" class="block text-sm font-medium text-primary dark:text-dark-primary">
                            First Name <span class="text-error dark:text-dark-error">*</span>
                        </label>
                        <input id="fname" name="fname" type="text" placeholder="Your first name"
                            value="{{ old('fname') }}" autofocus
                            class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('fname') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                        @error('fname')
                            <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="lname" class="block text-sm font-medium text-primary dark:text-dark-primary">
                            Last Name <span class="text-error dark:text-dark-error">*</span>
                        </label>
                        <input id="lname" name="lname" type="text" placeholder="Your last name"
                            value="{{ old('lname') }}"
                            class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('lname') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                        @error('lname')
                            <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="userName" class="block text-sm font-medium text-primary dark:text-dark-primary">
                        Username <span class="text-error dark:text-dark-error">*</span>
                    </label>
                    <input id="userName" name="userName" type="text" placeholder="Your username"
                        value="{{ old('userName') }}"
                        class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('userName') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('userName')
                        <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-primary dark:text-dark-primary">
                        Email <span class="text-error dark:text-dark-error">*</span>
                    </label>
                    <input id="email" name="email" type="email" placeholder="you@example.com"
                        value="{{ old('email') }}"
                        class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('email') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    @error('email')
                        <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-primary dark:text-dark-primary">
                            Password <span class="text-error dark:text-dark-error">*</span>
                        </label>
                        <input id="password" name="password" type="password" placeholder="Enter password"
                            class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('password') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                        @error('password')
                            <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-primary dark:text-dark-primary">
                            Confirm Password <span class="text-error dark:text-dark-error">*</span>
                        </label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            placeholder="Confirm password"
                            class="mt-2 w-full rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('password') border-error dark:border-dark-error @else border-gray-300 @enderror" />
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-primary dark:text-dark-primary">
                        Account Type <span class="text-error dark:text-dark-error">*</span>
                    </label>
                    <select name="role" id="role"
                        class="mt-2 w-full cursor-pointer rounded-lg border py-2 px-3 focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-dark-primary @error('role') border-error dark:border-dark-error @else border-gray-300 @enderror">
                        <option disabled selected value="" class="text-primary/90">Choose a role</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }} class="text-primary">Regular
                            User</option>
                        <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }} class="text-primary">
                            Organizer</option>
                        <option value="speaker" {{ old('role') == 'speaker' ? 'selected' : '' }} class="text-primary">
                            Speaker</option>
                    </select>
                    @error('role')
                        <p class="text-error dark:text-dark-error text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-center pt-4">
                    <button type="submit"
                        class="w-1/2 rounded-full cursor-pointer py-2 px-6 text-lg font-semibold bg-primary text-dark-primary dark:bg-dark-primary dark:text-primary hover:bg-transparent hover:text-primary hover:dark:text-dark-primary border border-primary dark:border-dark-primary transition-all duration-300">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
        @if (!$errors->any())
            <img src="{{ asset('images/register.webp') }}" alt="Register Image"
                class="object-cover h-full w-full min-h-[700px] max-w-md rounded-r-2xl hidden lg:block">
        @endif
    </div>
@endsection
