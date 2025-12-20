<nav x-data="{ open: false }" class="bg-white elevation-2 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-2 rounded-lg elevation-1 group-hover:elevation-2 transition-all">
                            <span class="material-icons text-white text-2xl">account_balance</span>
                        </div>
                        <span class="text-xl font-medium text-gray-800 hidden md:block">Pawn Broker</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                    <a href="{{ route('dashboard') }}" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        <span class="material-icons text-xl">dashboard</span>
                        <span class="font-medium">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('customers.index') }}" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        <span class="material-icons text-xl">people</span>
                        <span class="font-medium">Customers</span>
                    </a>
                    
                    <a href="{{ route('loans.index') }}" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('loans.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        <span class="material-icons text-xl">receipt_long</span>
                        <span class="font-medium">Loans</span>
                    </a>
                    
                    <a href="{{ route('payments.index') }}" 
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all">
                        <span class="material-icons text-xl">payments</span>
                        <span class="font-medium">Payments</span>
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center space-x-2 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition-all">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                                <span class="material-icons text-white text-sm">person</span>
                            </div>
                            <div class="text-left hidden lg:block">
                                <div class="font-medium text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                            </div>
                            <span class="material-icons text-gray-400">expand_more</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="font-medium text-sm text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <span class="material-icons text-gray-400 text-sm">settings</span>
                            <span>{{ __('Profile Settings') }}</span>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-red-600">
                                <span class="material-icons text-sm">logout</span>
                                <span>{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-gray-400 hover:text-gray-500 hover:bg-gray-100 transition-all">
                    <span class="material-icons" x-show="!open">menu</span>
                    <span class="material-icons" x-show="open" style="display: none;">close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                <span class="material-icons">dashboard</span>
                <span class="font-medium">{{ __('Dashboard') }}</span>
            </a>
            
            <a href="{{ route('customers.index') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                <span class="material-icons">people</span>
                <span class="font-medium">{{ __('Customers') }}</span>
            </a>
            
            <a href="{{ route('loans.index') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('loans.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                <span class="material-icons">receipt_long</span>
                <span class="font-medium">{{ __('Loans') }}</span>
            </a>
            
            <a href="{{ route('payments.index') }}" 
                class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700' }}">
                <span class="material-icons">payments</span>
                <span class="font-medium">{{ __('Payments') }}</span>
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 px-4">
            <div class="flex items-center space-x-3 px-4 py-2">
                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center">
                    <span class="material-icons text-white">person</span>
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                    class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <span class="material-icons">settings</span>
                    <span>{{ __('Profile') }}</span>
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                        class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg text-red-600 hover:bg-red-50">
                        <span class="material-icons">logout</span>
                        <span>{{ __('Log Out') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
