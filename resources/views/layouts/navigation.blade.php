<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 premium-shadow">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'super_admin' ? route('super-admin.dashboard') : route('dashboard') }}" class="flex items-center space-x-3 group">
                        @if(Auth::user()->role !== 'super_admin' && Auth::user()->shop && Auth::user()->shop->logo)
                            <img src="{{ Storage::url(Auth::user()->shop->logo) }}" class="h-12 w-12 rounded-2xl object-contain bg-slate-50 border border-slate-100 p-1 shadow-sm group-hover:border-blue-200 transition-all" alt="{{ Auth::user()->shop->name }}">
                        @else
                            <div class="bg-slate-900 p-2.5 rounded-2xl shadow-lg shadow-slate-900/20 group-hover:scale-110 transition-all">
                                <span class="material-symbols-rounded text-white text-2xl leading-none">account_balance</span>
                            </div>
                        @endif
                        <div class="flex flex-col">
                            <span class="text-base font-black text-slate-900 hidden md:block tracking-tighter uppercase leading-none">
                                {{ Auth::user()->role !== 'super_admin' && Auth::user()->shop ? Auth::user()->shop->name : config('app.name') }}
                            </span>
                            @if(Auth::user()->role !== 'super_admin' && Auth::user()->shop)
                                <span class="text-[9px] font-black text-blue-600 uppercase tracking-widest mt-1 hidden md:block">Authorized Terminal</span>
                            @endif
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:ms-10 sm:flex items-center">
                    @if(Auth::user()->role === 'super_admin')
                        <x-nav-link :href="route('super-admin.dashboard')" :active="request()->routeIs('super-admin.dashboard')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">dashboard</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Dashboard</span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('super-admin.shops.index')" :active="request()->routeIs('super-admin.shops.*')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">store</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Manage Shops</span>
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">dashboard</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Overview</span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">groups</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Clients</span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">contract</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Instruments</span>
                        </x-nav-link>
                        
                        <x-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                            <span class="material-symbols-rounded text-xl">payments</span>
                            <span class="font-black text-[10px] uppercase tracking-[0.15em]">Collections</span>
                        </x-nav-link>

                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all">
                                <span class="material-symbols-rounded text-xl">badge</span>
                                <span class="font-black text-[10px] uppercase tracking-[0.15em]">Staff</span>
                            </x-nav-link>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center space-x-3 px-4 py-2 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-blue-100 transition-all premium-shadow group">
                            <div class="w-8 h-8 rounded-xl bg-slate-900 flex items-center justify-center group-hover:scale-105 transition-all">
                                <span class="material-symbols-rounded text-white text-sm">person</span>
                            </div>
                            <div class="text-left hidden lg:block">
                                <div class="font-black text-[10px] uppercase tracking-widest text-slate-900 leading-none">{{ Auth::user()->name }}</div>
                                <div class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter mt-1">{{ Auth::user()->role }}</div>
                            </div>
                            <span class="material-symbols-rounded text-slate-300 text-lg group-hover:text-blue-600 transition-colors">expand_more</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-5 py-4 border-b border-slate-50">
                            <div class="font-black text-[10px] text-slate-900 uppercase tracking-[0.2em] mb-1">{{ Auth::user()->name }}</div>
                            <div class="text-[9px] text-slate-400 font-bold tracking-tighter truncate">{{ Auth::user()->email }}</div>
                        </div>
                        
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center space-x-3 px-5 py-3 hover:bg-slate-50 transition-colors">
                            <span class="material-symbols-rounded text-slate-400 text-base">manage_accounts</span>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">Access Identity</span>
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="flex items-center space-x-3 px-5 py-3 hover:bg-rose-50 text-rose-600 transition-colors border-t border-slate-50">
                                <span class="material-symbols-rounded text-base">logout</span>
                                <span class="text-[10px] font-black uppercase tracking-widest">Terminate Session</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-2xl text-slate-400 hover:text-slate-900 hover:bg-slate-100 transition-all">
                    <span class="material-symbols-rounded text-2xl" x-show="!open">menu</span>
                    <span class="material-symbols-rounded text-2xl" x-show="open" style="display: none;">close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-slate-50 border-t border-slate-100">
        <div class="pt-4 pb-6 space-y-2 px-4">
            @if(Auth::user()->role === 'super_admin')
                <x-responsive-nav-link :href="route('super-admin.dashboard')" :active="request()->routeIs('super-admin.dashboard')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">dashboard</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Dashboard</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('super-admin.shops.index')" :active="request()->routeIs('super-admin.shops.*')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">store</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Manage Shops</span>
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">dashboard</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Overview</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">groups</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Clients</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('loans.index')" :active="request()->routeIs('loans.*')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">contract</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Instruments</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.*')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                    <span class="material-symbols-rounded">payments</span>
                    <span class="font-black text-[11px] uppercase tracking-widest">Collections</span>
                </x-responsive-nav-link>
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl">
                        <span class="material-symbols-rounded">badge</span>
                        <span class="font-black text-[11px] uppercase tracking-widest">Staff Registry</span>
                    </x-responsive-nav-link>
                @endif
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-6 pb-6 border-t border-slate-200 px-4">
            <div class="flex items-center px-6 mb-6">
                <div class="bg-slate-900 p-2 rounded-xl mr-4">
                    <span class="material-symbols-rounded text-white text-base">person</span>
                </div>
                <div>
                    <div class="font-black text-[11px] text-slate-900 uppercase tracking-widest">{{ Auth::user()->name }}</div>
                    <div class="text-[9px] text-slate-500 font-bold italic">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="flex items-center space-x-4 px-6 py-4 rounded-2xl text-slate-600">
                    <span class="material-symbols-rounded">manage_accounts</span>
                    <span class="font-black text-[10px] uppercase tracking-widest">Access Identity</span>
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center space-x-4 px-6 py-4 rounded-2xl text-rose-600">
                        <span class="material-symbols-rounded">logout</span>
                        <span class="font-black text-[10px] uppercase tracking-widest">Terminate Session</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

