<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Order #{{ $order->id }} Details
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            <div class="mb-4">
                <h3 class="text-lg font-semibold">Customer Info</h3>
                <p><strong>Name:</strong> {{ $order->customer->name }}</p>
                <p><strong>Email:</strong> {{ $order->customer->email }}</p>
                <p><strong>Address:</strong> {{ $order->address_place ?? $order->customer->address }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold">Order Info</h3>
                <p><strong>Status:</strong>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </p>
                <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                <p><strong>Created at:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>

            <div class="mb-4">
                <h3 class="text-lg font-semibold">Items</h3>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Quantity</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $item->product->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">${{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex gap-2">
                <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm text-gray-800 dark:text-gray-100 hover:bg-gray-300 dark:hover:bg-gray-600">Back to Orders</a>

                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('orders.edit', $order) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Edit Order</a>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
