<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Order') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="customer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Customer</label>
                        <select name="customer_id" id="customer_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                            <option value="">-- Select Customer --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>
                                    {{ $customer->name }} ({{ $customer->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="address_place" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Address</label>
                        <input type="text" name="address_place" id="address_place" value="{{ old('address_place') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200" />
                    </div>

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                        <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                            <option value="pending" @selected(old('status') == 'pending')>Pending</option>
                            <option value="completed" @selected(old('status') == 'completed')>Completed</option>
                            <option value="cancelled" @selected(old('status') == 'cancelled')>Cancelled</option>
                        </select>
                    </div>

                    <div id="items-wrapper">
                        <div class="mb-4 item-row">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product</label>
                            <select name="items[0][product_id]" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                                <option value="">-- Select Product --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (${{ $product->price }})</option>
                                @endforeach
                            </select>

                            <label class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
                            <input type="number" name="items[0][quantity]" min="1" value="1"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200" />
                        </div>
                    </div>

                    <button type="button" id="add-item"
                        class="mb-4 px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        + Add Another Product
                    </button>

                    <div class="flex justify-end">
                        <x-primary-button>Create Order</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-item').addEventListener('click', function() {
            const wrapper = document.getElementById('items-wrapper');
            const index = wrapper.querySelectorAll('.item-row').length;

            const div = document.createElement('div');
            div.classList.add('mb-4', 'item-row');
            div.innerHTML = `
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Product</label>
                <select name="items[${index}][product_id]" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                    <option value="">-- Select Product --</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (${{ $product->price }})</option>
                    @endforeach
                </select>

                <label class="block mt-2 text-sm font-medium text-gray-700 dark:text-gray-200">Quantity</label>
                <input type="number" name="items[${index}][quantity]" min="1" value="1"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-gray-700 dark:text-gray-200" />
            `;
            wrapper.appendChild(div);
        });
    </script>
</x-app-layout>
