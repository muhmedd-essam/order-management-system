<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="GET" action="{{ route('orders.index') }}" class="mb-4">
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name, email, or status" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    <x-primary-button>Search</x-primary-button>
                    @if(request('search'))
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm">Reset</a>
                    @endif
                </div>
            </form>

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-300">Total: {{ $orders->total() }}</div>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Order</a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Customer</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Total</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Items</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Created</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $order->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">
                                    <div>
                                        <div class="font-medium">{{ $order->customer->name }}</div>
                                        <div class="text-gray-500">{{ $order->customer->email }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">${{ number_format($order->total, 2) }}</td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $order->items->count() }} items</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline mr-3">View</a>
                                    @if(auth()->user()->hasRole('admin'))
                                        <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this order?')">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
