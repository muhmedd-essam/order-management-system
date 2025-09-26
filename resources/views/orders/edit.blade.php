<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Order') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Customer -->
                <div class="mb-4">
                    <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Customer
                    </label>
                    <select name="customer_id" id="customer_id"
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id', $order->customer_id) == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Total -->
                <div class="mb-4">
                    <label for="total" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Total Amount
                    </label>
                    <input type="number" step="0.01" name="total" id="total"
                        value="{{ old('total', $order->total) }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status
                    </label>
                    <select name="status" id="status"
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                        <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="canceled" {{ old('status', $order->status) == 'canceled' ? 'selected' : '' }}>Canceled</option>
                    </select>
                </div>

                <!-- Address -->
                <div class="mb-4">
                    <label for="address_place" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Address
                    </label>
                    <input type="text" name="address_place" id="address_place"
                        value="{{ old('address_place', $order->address_place) }}"
                        class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('orders.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm mr-2">
                        Cancel
                    </a>
                    <x-primary-button>
                        Update Order
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
