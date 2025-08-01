<nav class="bg-surface dark:bg-dark-bg text-primary dark:text-dark-primary px-6 py-4 shadow-md">
    <div class="flex justify-between items-center">
        <!-- Logo & Navigation -->
        <ul class="flex items-center space-x-6">

            <li class="">
                <a href="/"
                    class="text-accent hover:text-accent-hover font-bold text-4xl flex justify-center items-center">
                    <div class="bg-white rounded-full p-2 mr-3">
                        <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-8 h-auto">
                    </div>
                    <p>
                        Event Hub
                    </p>
                </a>
            </li>


            @auth
                @if (auth()->user()->role === 'user')
                    <li><a href="/events" class="hover:underline">Events</a></li>
                    <li><a href="/my-tickets" class="hover:underline">My Tickets</a></li>
                @elseif(auth()->user()->role === 'speaker')
                    <li><a href="/events" class="hover:underline">Events</a></li>
                    <li><a href="/proposals" class="hover:underline">Proposals</a></li>
                @elseif(auth()->user()->role === 'organizer')
                    <li><a href="/my-events" class="hover:underline">My Events</a></li>
                    <li><a href="/choose-speakers" class="hover:underline">Choose Speakers</a></li>
                @endif

                <li><a href="/profile" class="hover:underline">Profile</a></li>
                <li>
                    <form action="/logout" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline">Logout</button>
                    </form>
                </li>
            @endauth

            @guest
                <li><a href="/login" class="hover:underline">Login</a></li>
            @endguest
        </ul>

        {{-- Theme Toggle Button --}}
        <button onclick="toggleTheme()"
            class="inline-flex items-center cursor-pointer gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white dark:bg-white dark:text-primary dark:hover:bg-gray-200 rounded-full shadow transition duration-200">
            <i class="fas fa-adjust"></i>
            <span class="hidden sm:inline">Toggle Theme</span>
        </button>
    </div>
</nav>

{{-- Theme Script --}}
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
