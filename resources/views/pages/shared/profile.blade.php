@extends('layouts.app')


@section('main')
    <div class="min-h-[calc(100vh-140px)] bg-bg dark:bg-dark-bg py-8">
        <div class="max-w-2xl mx-auto px-4">
            {{-- Profile Card --}}
            <div
                class="bg-white dark:bg-dark-surface rounded-2xl shadow-sm border border-border dark:border-dark-border overflow-hidden">

                {{-- Header --}}
                <div class="bg-gradient-to-r from-accent to-accent-hover px-6 py-8 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ auth()->user()->fullname ?? auth()->user()->username }}</h1>
                            <p class="text-white/80">Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Profile Form --}}
                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Full Name --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-primary dark:text-dark-primary font-poppins">
                                <i class="fas fa-id-card mr-2 text-muted dark:text-dark-muted"></i>Full Name
                            </label>
                            <div class="profile-field">
                                <div
                                    class="profile-display px-3 py-2 bg-surface dark:bg-dark-surface rounded-lg text-primary dark:text-dark-primary font-manrope">
                                    {{ auth()->user()->fullname ?? 'Not provided' }}
                                </div>
                                <input type="text" name="fullname" value="{{ auth()->user()->fullname }}"
                                    class="profile-input hidden w-full px-3 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary font-manrope focus:ring-2 focus:ring-accent focus:border-transparent">
                            </div>
                        </div>

                        {{-- Username --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-primary dark:text-dark-primary font-poppins">
                                <i class="fas fa-at mr-2 text-muted dark:text-dark-muted"></i>Username
                            </label>
                            <div class="profile-field">
                                <div
                                    class="profile-display px-3 py-2 bg-surface dark:bg-dark-surface rounded-lg text-primary dark:text-dark-primary font-mono">
                                    {{ auth()->user()->username }}
                                </div>
                                <input type="text" name="username" value="{{ auth()->user()->username }}"
                                    class="profile-input hidden w-full px-3 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary font-mono focus:ring-2 focus:ring-accent focus:border-transparent">
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-primary dark:text-dark-primary font-poppins">
                                <i class="fas fa-envelope mr-2 text-muted dark:text-dark-muted"></i>Email Address
                            </label>
                            <div class="profile-field">
                                <div
                                    class="profile-display px-3 py-2 bg-surface dark:bg-dark-surface rounded-lg text-primary dark:text-dark-primary font-manrope">
                                    {{ auth()->user()->email }}
                                </div>
                                <input type="email" name="email" value="{{ auth()->user()->email }}"
                                    class="profile-input hidden w-full px-3 py-2 border border-border dark:border-dark-border rounded-lg bg-white dark:bg-dark-bg text-primary dark:text-dark-primary font-manrope focus:ring-2 focus:ring-accent focus:border-transparent">
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-primary dark:text-dark-primary font-poppins">
                                <i class="fas fa-shield-alt mr-2 text-muted dark:text-dark-muted"></i>Role
                            </label>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium font-poppins
                                @if (auth()->user()->role === 'speaker') bg-info/10 text-info dark:bg-dark-info/10 dark:text-dark-info
                                @elseif(auth()->user()->role === 'organizer') bg-error/10 text-error dark:bg-dark-error/10 dark:text-dark-error
                                @else bg-success/10 text-success dark:bg-dark-success/10 dark:text-dark-success @endif">
                                <i
                                    class="fas
                                    @if (auth()->user()->role === 'speaker') fa-microphone
                                    @elseif(auth()->user()->role === 'organizer') fa-users-cog
                                    @else fa-user @endif mr-2"></i>
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div> 
                        
                    </div>
                    
                    <div class="flex gap-3 pt-6 mt-6 border-t border-border dark:border-dark-border">
                        <button type="button" id="editBtn"
                            class="px-4 py-2 cursor-pointer bg-accent hover:bg-accent-hover text-white font-medium font-poppins rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profile</span>
                        </button>
                        
                        


                        <button type="submit" id="saveBtn"
                            class="hidden px-4 py-2 cursor-pointer bg-success hover:bg-success/90 text-white font-medium font-poppins rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Save Changes</span>
                        </button>
                        <!-- delete button -->
                        
                        <button type="button" id="cancelBtn"
                            class="hidden px-4 py-2 cursor-pointer bg-muted hover:bg-muted/80 text-white font-medium font-poppins rounded-lg transition-colors flex items-center gap-2">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </button>

                    </div>
                </form>

                <!-- delete button -->   
                <form action="{{ route('profile.delete') }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.');"
                class="px-6 mb-4">
                    @csrf
                    @method('DELETE')

                    <button type="submit" id="deletebtn"
                        class="hidden px-4 py-2 cursor-pointer bg-error hover:bg-error/90 text-white font-medium font-poppins rounded-lg transition-colors flex items-center gap-2">
                        <i class="fas fa-trash"></i>
                        <span>Delete Account</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const editBtn = document.getElementById('editBtn');
        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const deleteBtn = document.getElementById('deletebtn');
        const displays = document.querySelectorAll('.profile-display');
        const inputs = document.querySelectorAll('.profile-input');
        const originalValues = {};

        inputs.forEach(input => {
            originalValues[input.name] = input.value;
        });

        function toggleEdit(editing) {
            displays.forEach(display => display.classList.toggle('hidden', editing));
            inputs.forEach(input => input.classList.toggle('hidden', !editing));

            editBtn.classList.toggle('hidden', editing);
            saveBtn.classList.toggle('hidden', !editing);
            cancelBtn.classList.toggle('hidden', !editing);
            deleteBtn.classList.toggle('hidden', !editing);
        }

        editBtn.addEventListener('click', () => toggleEdit(true));

        cancelBtn.addEventListener('click', () => {
            inputs.forEach(input => {
                input.value = originalValues[input.name];
            });
            toggleEdit(false);
        });
    </script>
@endsection
