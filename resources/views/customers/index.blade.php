<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customers') }}
        </h2>
    </x-slot>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <form method="GET" action="{{ route('customers.index') }}" class="mb-4">
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    <x-primary-button>Search</x-primary-button>
                    @if(request('search'))
                        <a href="{{ route('customers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm">Reset</a>
                    @endif
                </div>
            </form>

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex justify-between items-center">
                <div class="text-sm text-gray-600 dark:text-gray-300">Total: {{ $customers->total() }}</div>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('customers.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Add Customer</a>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">#</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">Phone</th>
                            @if(auth()->user()->hasRole('admin'))
                                <th class="px-4 py-2"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($customers as $customer)
                            <tr>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $customer->id }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $customer->name }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $customer->email }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-200">{{ $customer->phone }}</td>
                                @if(auth()->user()->hasRole('admin'))
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('customers.edit', $customer) }}" class="text-indigo-600 hover:underline mr-3">Edit</a>
                                        <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this customer?')">Delete</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">No customers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $customers->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>