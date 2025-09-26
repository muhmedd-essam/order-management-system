<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-4 p-3 rounded bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Edit Form --}}
            <form action="{{ route('products.update', $product) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', $product->name) }}"
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                    <input type="number" step="0.01" name="price" id="price"
                           value="{{ old('price', $product->price) }}"
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock Quantity</label>
                    <input type="number" name="stock" id="stock"
                           value="{{ old('stock', $product->stock) }}"
                           class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                </div>

                @if(auth()->user()->hasRole('admin'))
                    <div class="flex justify-end">
                        <a href="{{ route('products.index') }}"
                           class="px-4 py-2 bg-gray-300 dark:bg-gray-600 rounded-md mr-2 text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-500">
                            Cancel
                        </a>
                        <x-primary-button>Update</x-primary-button>
                    </div>
                @else
                    <div class="mt-4 text-sm text-red-600 dark:text-red-400">
                        You do not have permission to update products.
                    </div>
                @endif
            </form>

        </div>
    </div>
</x-app-layout>
