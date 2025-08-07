<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Event Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
        href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600&family=Inter:wght@400;600&family=Manrope:wght@400;600&family=Poppins:wght@400;600&family=Space+Grotesk:wght@400;700&family=Urbanist:wght@400;600&display=swap"
        rel="stylesheet">

</head>

@yield('styles')

<body class="bg-bg dark:bg-dark-bg text-gray-900 dark:text-white font-sans leading-relaxed">

    @if (session('success'))
        <div class="py-3 bg-success dark:bg-dark-success text-white flex items-center justify-center gap-2">
            <i class="fas fa-check-circle text-white"></i>
            <span>{{ session('success') }}</span>
        </div>
    @elseif (session('error'))
        <div class="py-3 bg-error dark:bg-dark-error text-white flex items-center justify-center gap-2">
            <i class="fas fa-exclamation-triangle text-white"></i>
            <span>{{ session('error') }}</span>
        </div>
    @elseif (session('info'))
        <div class="py-3 bg-blue-600 dark:bg-blue-700 text-white flex items-center justify-center gap-2">
            <i class="fas fa-exclamation-triangle text-white"></i>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    <x-navbar />



    <main>
        @yield('main')

    </main>


    <x-footer />

    @yield('scripts')
<script>
    // Force reload when using back button
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
</body>

</html>
