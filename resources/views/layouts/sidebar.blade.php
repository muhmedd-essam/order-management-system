<div class="bg-white dark:bg-gray-800 rounded-lg shadow divide-y divide-gray-200 dark:divide-gray-700">
    <div class="p-4">
        <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">Menu</h2>
    </div>
    <nav class="p-2 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium
           {{ request()->routeIs('dashboard') ?
              'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
              'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
           Dashboard
        </a>

        @auth
            {{-- Customers --}}
            <a href="{{ route('customers.index') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium
               {{ request()->routeIs('customers.*') ?
                  'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                  'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
               Customers
            </a>

            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('customers.create') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium
                   {{ request()->routeIs('customers.create') ?
                      'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                      'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                   Add Customer
                </a>
            @endif

            {{-- Products --}}
            <a href="{{ route('products.index') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium
               {{ request()->routeIs('products.*') ?
                  'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                  'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
               Products
            </a>

            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('products.create') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium
                   {{ request()->routeIs('products.create') ?
                      'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                      'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                   Add Product
                </a>
            @endif

            {{-- Orders --}}
            <a href="{{ route('orders.index') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium
               {{ request()->routeIs('orders.*') ?
                  'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                  'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
               Orders
            </a>

            <a href="{{ route('orders.create') }}"
               class="block px-3 py-2 rounded-md text-sm font-medium
               {{ request()->routeIs('orders.create') ?
                  'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' :
                  'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
               Add Order
            </a>
        @endauth
    </nav>
</div>
