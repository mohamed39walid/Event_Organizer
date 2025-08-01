<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Event Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-bg dark:bg-dark-bg text-gray-900 dark:text-white font-sans leading-relaxed">

    {{-- Flash Messages --}}
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
    @endif

    <x-navbar />



    <main class="h-[calc(100vh-140px)] w-full ">
        @yield('main')
    </main>

    <x-footer />


</body>

</html>
