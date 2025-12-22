<nav x-data="{ open: false }" class="bg-white elevation-2 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 group">
                        @if(Auth::user()->role !== 'super_admin' && Auth::user()->shop && Auth::user()->shop->logo)
                            <img src="{{ Storage::url(Auth::user()->shop->logo) }}" class="h-10 w-auto rounded-lg" alt="{{ Auth::user()->shop->name }}">
                        @else
                            <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-2 rounded-lg elevation-1 group-hover:elevation-2 transition-all">
                                <span class="material-icons text-white text-2xl">account_balance</span>
                            </div>
                        @endif
                        <span class="text-xl font-black text-gray-900 hidden md:block tracking-tighter uppercase">
                            {{ Auth::user()->role !== 'super_admin' && Auth::user()->shop ? Auth::user()->shop->name : config('app.name') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                    @if(Auth::user()->role === 'super_admin')
                        <a href="{{ route('super-admin.dashboard') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('super-admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">admin_panel_settings</span>
                            <span>Admin Center</span>
                        </a>
                        <a href="{{ route('super-admin.shops.index') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('super-admin.shops.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">store</span>
                            <span>Manage Shops</span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">dashboard</span>
                            <span>Dashboard</span>
                        </a>
                        
                        <a href="{{ route('customers.index') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('customers.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">people</span>
                            <span>Customers</span>
                        </a>
                        
                        <a href="{{ route('loans.index') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('loans.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">receipt_long</span>
                            <span>Loans</span>
                        </a>
                        
                        <a href="{{ route('payments.index') }}" 
                            class="flex items-center space-x-2 px-4 py-2 rounded-lg {{ request()->routeIs('payments.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }} transition-all font-black text-xs uppercase tracking-widest">
                            <span class="material-icons text-xl">payments</span>
                            <span>Payments</span>
                        </a>
                    @endif
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
                                <div class="font-black text-[10px] uppercase tracking-widest leading-none">{{ Auth::user()->name }}</div>
                                <div class="text-[9px] text-gray-400 font-bold uppercase tracking-tighter mt-1">{{ Auth::user()->role }}</div>
                            </div>
                            <span class="material-icons text-gray-400">expand_more</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="font-black text-xs text-gray-800 uppercase tracking-widest mb-1">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-gray-500 font-bold tracking-tighter">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-2">
                            <span class="material-icons text-gray-400 text-sm">settings</span>
                            <span class="text-xs font-bold uppercase tracking-widest">{{ __('Profile') }}</span>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-2 text-red-600">
                                <span class="material-icons text-sm">logout</span>
                                <span class="text-xs font-bold uppercase tracking-widest">{{ __('Log Out') }}</span>
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
            @if(Auth::user()->role === 'super_admin')
                <a href="{{ route('super-admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700">
                    <span class="material-icons">admin_panel_settings</span>
                    <span class="font-bold text-xs uppercase tracking-widest">Admin Center</span>
                </a>
                <a href="{{ route('super-admin.shops.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700">
                    <span class="material-icons">store</span>
                    <span class="font-bold text-xs uppercase tracking-widest">Manage Shops</span>
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 font-bold text-xs uppercase tracking-widest">
                    <span class="material-icons">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <!-- Add other responsive links here... -->
            @endif
        </div>
    </div>
</nav>
