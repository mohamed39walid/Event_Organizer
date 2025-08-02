<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Event Platform')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body
    class="bg-dark-primary dark:bg-primary text-primary dark:text-dark-primary font-inter antialiased min-h-screen flex flex-col">
    <!-- Navbar -->
    <x-navbar />

    <!-- Main Layout -->
    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar -->
        <aside
            class="w-64 bg-surface dark:bg-dark-bg text-primary dark:text-dark-primary border-r border-gray-200 dark:border-primary shadow-lg hidden lg:flex flex-col">
            <div class="p-6 border-b border-gray-200 dark:border-primary flex items-center gap-3">
                <i class="fa-solid fa-user text-red-600 dark:text-red-400"></i>
                <span class="text-xl font-semibold">Admin Dashboard</span>
            </div>
            <nav class="flex-1 p-4">
                <ul class="space-y-4">
                    <li>
                        <a href="/admin/departments"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-dark-muted dark:hover:bg-muted transition">
                            <i class="fas fa-building w-5"></i>
                            <span>Departments</span>
                        </a>
                        <ul class="ml-7 mt-2 space-y-1">
                            <li>
                                <a href="/admin/departments/create"
                                    class="text-sm hover:text-red-500 dark:hover:text-red-400 transition">
                                    Create Department
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
        </aside>

        <!-- Page Content -->
        <main class="flex-1 flex flex-col">
            @yield('main')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#zero_config').DataTable({
                pageLength: 10,
                language: {
                    search: 'Search:',
                    paginate: {
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                },
                drawCallback: function() {
                    $('.paginate_button').addClass(
                        'px-3 py-1.5 m-1 rounded-lg text-sm font-medium text-gray-600 bg-white hover:bg-indigo-100 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors'
                    );
                    $('.dataTables_filter input').addClass(
                        'border border-gray-300 dark:border-gray-600 rounded-lg py-2 px-3 text-gray-900 dark:text-gray-100 dark:bg-gray-800 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500'
                    );
                    $('.dataTables_length select').addClass(
                        'border border-gray-300 dark:border-gray-600 rounded-lg py-1.5 px-2 text-gray-900 dark:text-gray-100 dark:bg-gray-800'
                    );
                }
            });
        });
    </script>
</body>

</html>
