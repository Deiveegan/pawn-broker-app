<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <span class="material-icons text-blue-600 text-3xl">admin_panel_settings</span>
            <h2 class="font-black text-2xl text-gray-800 tracking-tighter uppercase">
                {{ __('System Controller Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Global Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="md-card elevation-2 overflow-hidden border-l-4 border-blue-600">
                    <div class="p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Total Registered Shops</p>
                        <p class="text-3xl font-black text-blue-600 mt-2">{{ $stats['total_shops'] }}</p>
                        <div class="mt-4 flex items-center justify-between text-[10px] text-gray-400 font-bold uppercase">
                            <span>Active: {{ $stats['active_shops'] }}</span>
                            <span class="material-icons text-sm">store</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-2 overflow-hidden border-l-4 border-green-600">
                    <div class="p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Global Customers</p>
                        <p class="text-3xl font-black text-green-600 mt-2">{{ $stats['total_customers'] }}</p>
                        <div class="mt-4 flex items-center justify-between text-[10px] text-gray-400 font-bold uppercase">
                            <span>SaaS Network</span>
                            <span class="material-icons text-sm">groups</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-2 overflow-hidden border-l-4 border-purple-600">
                    <div class="p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Total Loans Managed</p>
                        <p class="text-3xl font-black text-purple-600 mt-2">{{ $stats['total_loans'] }}</p>
                        <div class="mt-4 flex items-center justify-between text-[10px] text-gray-400 font-bold uppercase">
                            <span>Combined Ledger</span>
                            <span class="material-icons text-sm">receipt_long</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-2 overflow-hidden border-l-4 border-orange-600 bg-orange-50/10">
                    <div class="p-6 text-center">
                        <a href="{{ route('super-admin.shops.create') }}" class="inline-flex flex-col items-center group">
                            <span class="material-icons text-orange-600 text-4xl group-hover:scale-110 transition-transform">add_business</span>
                            <span class="text-[10px] font-black uppercase text-orange-600 tracking-widest mt-2">Onboard New Shop</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Shop Activity -->
                <div class="lg:col-span-2">
                    <div class="md-card elevation-1 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Recent Shop Incursions</h3>
                            <a href="{{ route('super-admin.shops.index') }}" class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">View All</a>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($latest_shops as $shop)
                                <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200">
                                            @if($shop->logo)
                                                <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="material-icons text-gray-400">storefront</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-gray-900 uppercase tracking-tighter">{{ $shop->name }}</p>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">{{ $shop->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-6 text-right">
                                        <div>
                                            <p class="text-xs font-black text-gray-900">{{ $shop->customers_count }}</p>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase">Clients</p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-gray-900">{{ $shop->loans_count }}</p>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase">Loans</p>
                                        </div>
                                        <div>
                                            <span class="px-2 py-1 rounded text-[8px] font-black uppercase tracking-widest {{ $shop->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $shop->is_active ? 'Active' : 'Disabled' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="lg:col-span-1">
                    <div class="md-card elevation-1 bg-gradient-to-br from-gray-900 to-black text-white p-8">
                        <h3 class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-6">Environment Control</h3>
                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <span class="material-icons text-blue-400">security</span>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-tighter">Security Protocol</p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">Tenant isolation active via BelongsToShop trait.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <span class="material-icons text-green-400">speed</span>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-tighter">System Pulse</p>
                                    <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">Laravel 11 / Vite Framework running optimized.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-12 pt-12 border-t border-gray-800 text-center">
                            <p class="text-[9px] font-bold text-gray-500 uppercase tracking-[0.2em]">PonNidhi Management Suite v2.0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
