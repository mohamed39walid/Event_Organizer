@extends('layouts.adminDashboard')

@section('main')
    <div class="p-6">
        <div class="bg-gray-100 dark:bg-gray-800 rounded-2xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Test Table</h2>

            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead
                        class="bg-white dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs border-b dark:border-gray-600">
                        <tr>
                            <th class="px-6 py-3">ID</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Email</th>
                            <th class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-3">1</td>
                            <td class="px-6 py-3">John Doe</td>
                            <td class="px-6 py-3">john@example.com</td>
                            <td class="px-6 py-3">
                                <a href="#" class="text-blue-600 hover:underline">Edit</a>
                                <a href="#" class="text-red-600 hover:underline ml-4">Delete</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-3">2</td>
                            <td class="px-6 py-3">Jane Smith</td>
                            <td class="px-6 py-3">jane@example.com</td>
                            <td class="px-6 py-3">
                                <a href="#" class="text-blue-600 hover:underline">Edit</a>
                                <a href="#" class="text-red-600 hover:underline ml-4">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
