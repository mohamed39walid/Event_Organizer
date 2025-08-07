<nav class="bg-surface dark:bg-dark-bg text-primary dark:text-dark-primary px-6 py-4 shadow-md z-50 sticky top-0">
    <div class="flex flex-wrap justify-between items-center gap-4 max-w-7xl mx-auto">

        <a href="{{ route('home') }}" class="flex items-center gap-3 text-3xl font-bold">
            <div class="bg-white dark:bg-dark-surface p-2 rounded-full shadow">
                <img src="{{ asset('images/logo.webp') }}" alt="Event Hub Logo"
                    class="w-8 h-8 object-contain dark:hidden" />
                <img src="{{ asset('images/logo-dark.webp') }}" alt="Event Hub Logo (Dark)"
                    class="w-8 h-8 object-contain hidden dark:block" />
            </div>
            <span class="tracking-wide font-heading">Event Hub</span>
        </a>

        <div class="flex items-center gap-8 flex-wrap text-lg font-medium">

            @auth
                <p class="text-red-900">
                    {{ strtoupper(auth()->user()->role) }}
                </p>

                @switch(auth()->user()->role)
                    @case('user')
                        <a href="{{ route('events') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Events
                        </a>
                        <a href="{{ route('tickets.my-tickets') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Tickets
                        </a>

                        {{-- Become a Partner Dropdown --}}
                        <div class="relative group">
                            <button
                                class="cursor-pointer hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out focus:outline-none">
                                Become a Partner
                            </button>

                            <div class="absolute mt-2 w-48 bg-white dark:bg-dark-surface shadow-lg rounded-md py-2 z-50 
                invisible opacity-0 group-hover:visible group-hover:opacity-100 
                transition-all duration-200"
                                onmouseenter="this.classList.add('visible','opacity-100')"
                                onmouseleave="this.classList.remove('visible','opacity-100')">

                                <form id="speaker-form" action="{{ route('role.to-speaker') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="confirmRoleChange('speaker')"
                                        class="cursor-pointer block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-bg transition">
                                        Become a Speaker
                                    </button>
                                </form>

                                <form id="organizer-form" action="{{ route('role.to-organizer') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="confirmRoleChange('organizer')"
                                        class="cursor-pointer block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-dark-bg transition">
                                        Become an Organizer
                                    </button>
                                </form>

                            </div>
                        </div>
                    @break

                    @case('speaker')
                        <a href="{{ route('events') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Events
                        </a>
                        <a href="{{ route('speaker.my-proposals') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Proposals
                        </a>
                        <a href="{{ route('tickets.my-tickets') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Tickets
                        </a>
                    @break

                    @case('organizer')
                        <a href="{{ route('events') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Events
                        </a>
                        <a href="{{ route('organizer.organizer-events') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Events
                        </a>
                    @break
                @endswitch

                <a href="{{ route('profile.view') }}"
                    class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                    Profile
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="hover:text-red-800 cursor-pointer dark:hover:text-red-900 transition duration-150 ease-in-out">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                    class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                    Register
                </a>
            @endguest

            <button onclick="toggleTheme()"
                class="ml-2 inline-flex text-base items-center gap-2 cursor-pointer px-4 py-2 bg-primary hover:bg-primary/90 text-white dark:bg-white dark:text-primary dark:hover:bg-gray-200 rounded-full shadow transition">
                <i class="fas fa-moon"></i>
                <span class="hidden sm:inline font-poppins">Theme</span>
            </button>

        </div>
    </div>
</nav>

<script>
    if (
        localStorage.getItem('theme') === 'dark' ||
        (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
    ) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.classList.contains('dark');
        html.classList.toggle('dark', !isDark);
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
    }

    function confirmRoleChange(role) {
        let roleName = role.charAt(0).toUpperCase() + role.slice(1); // Capitalize
        Swal.fire({
            title: `Are you sure?`,
            text: `You are about to become a ${roleName}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, become ${roleName}`
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`${role}-form`).submit();
            }
        });
    }
</script>
