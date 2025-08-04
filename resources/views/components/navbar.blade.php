<nav class="bg-surface dark:bg-dark-bg text-primary dark:text-dark-primary px-6 py-4 shadow-md z-50 sticky top-0">
    <div class="flex flex-wrap justify-between items-center gap-4 max-w-7xl mx-auto">

        <a href="{{ route('home') }}" class="flex items-center gap-3 text-xl sm:text-2xl font-bold">
            <div class="bg-white dark:bg-dark-surface p-2 rounded-full shadow">
                <img src="{{ asset('images/logo.webp') }}" alt="Event Hub Logo"
                    class="w-8 h-8 object-contain dark:hidden" />
                <img src="{{ asset('images/logo-dark.webp') }}" alt="Event Hub Logo (Dark)"
                    class="w-8 h-8 object-contain hidden dark:block" />
            </div>
            <span class="tracking-wide font-heading">Event Hub</span>
        </a>

        <div class="flex items-center gap-2 flex-wrap text-base font-medium">

            @auth
                @switch(auth()->user()->role)
                    @case('user')
                        <a href=""
                        {{-- {{ route('events') }} --}}
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Events
                        </a>
                        <a href="{{ route('my-tickets') }}"
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Tickets
                        </a>
                    @break

                    @case('speaker')
                        <a href=""
                        {{-- {{ route('speaker.events') }} --}}
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Events
                        </a>
                        <a href=""
                        {{-- {{ route('speaker.proposals') }} --}}
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            My Proposals
                        </a>
                    @break

                    @case('organizer')
                        <a href=""
                        {{-- {{ route('organizer.events.index') }} --}}
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Events
                        </a>
                        <a href=""
                        {{-- {{ route('organizer.review-proposals') }} --}}
                            class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                            Proposals
                        </a>
                    @break
                @endswitch

                <a href=""
                {{-- {{ route('profile') }} --}}
                    class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
                    Profile
                </a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="hover:text-accent dark:hover:text-dark-accent transition duration-150 ease-in-out">
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
                class="ml-2 inline-flex items-center gap-2 cursor-pointer px-4 py-2 bg-primary hover:bg-primary/90 text-white dark:bg-white dark:text-primary dark:hover:bg-gray-200 rounded-full shadow transition">
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
</script>
