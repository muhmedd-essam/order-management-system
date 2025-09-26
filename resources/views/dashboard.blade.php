<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(auth()->user()->hasRole('admin'))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Orders</h3>
                        <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalOrders }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</h3>
                        <div class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">${{ number_format($totalRevenue, 2) }}</div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg p-6">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Top 5 Customers</h3>
                        <ul class="mt-2 text-gray-700 dark:text-gray-200 list-disc list-inside">
                            @foreach($topCustomers as $customer)
                                <li>{{ $customer->name }} ({{ $customer->orders_count }} orders)</li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="mb-4">
                    <form method="GET" action="{{ route('dashboard.export') }}">
                        <x-primary-button>Export to Excel</x-primary-button>
                    </form>
                </div>

            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                    You do not have access to the dashboard.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
