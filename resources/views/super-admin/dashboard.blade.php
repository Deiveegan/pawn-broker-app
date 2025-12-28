<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-600/10 p-2 rounded-2xl">
                <span class="material-symbols-rounded text-blue-600 text-3xl">admin_panel_settings</span>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    {{ __('Control Center') }}
                </h2>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Global system statistics & management</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Global Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white premium-shadow rounded-[2rem] border-b-4 border-blue-600 p-8 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <span class="material-symbols-rounded text-blue-600 bg-blue-50 p-3 rounded-2xl">store</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Global Network</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Registered Shops</p>
                    <div class="flex items-end space-x-2 mt-4">
                        <p class="text-4xl font-extrabold text-slate-900 tracking-tighter">{{ number_format($stats['total_shops']) }}</p>
                        <p class="text-sm font-bold text-emerald-600 mb-1 flex items-center">
                            <span class="material-symbols-rounded text-sm">verified</span>
                            <span class="ml-1">{{ $stats['active_shops'] }} Active</span>
                        </p>
                    </div>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] border-b-4 border-emerald-600 p-8 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <span class="material-symbols-rounded text-emerald-600 bg-emerald-50 p-3 rounded-2xl">groups</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Reach</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Global Clients</p>
                    <p class="text-4xl font-extrabold text-slate-900 tracking-tighter mt-4">{{ number_format($stats['total_customers']) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] border-b-4 border-amber-600 p-8 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <span class="material-symbols-rounded text-amber-600 bg-amber-50 p-3 rounded-2xl">receipt_long</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Combined Ledger</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Active Loans</p>
                    <p class="text-4xl font-extrabold text-slate-900 tracking-tighter mt-4">{{ number_format($stats['total_loans']) }}</p>
                </div>

                <div class="bg-slate-900 premium-shadow rounded-[2rem] p-8 flex flex-col items-center justify-center text-center group cursor-pointer hover:bg-slate-800 transition-all border-b-4 border-blue-500">
                    <a href="{{ route('super-admin.shops.create') }}" class="inline-flex flex-col items-center">
                        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-all shadow-lg shadow-blue-600/20">
                            <span class="material-symbols-rounded text-white text-3xl">add_business</span>
                        </div>
                        <span class="text-[10px] font-black uppercase text-white tracking-[0.2em]">Onboard New Partner</span>
                        <span class="text-[8px] text-slate-400 font-bold uppercase mt-2">Initialize Environment</span>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recent Shop Activity -->
                <div class="lg:col-span-2">
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Recent Enrollments</h3>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">Latest tenant onboardings</p>
                            </div>
                            <a href="{{ route('super-admin.shops.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-blue-600 uppercase tracking-widest hover:bg-blue-50 transition-colors premium-shadow">View Ecosystem</a>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($latest_shops as $shop)
                                <div class="px-10 py-8 flex items-center justify-between hover:bg-slate-50/80 transition-all duration-300">
                                    <div class="flex items-center space-x-5">
                                        <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center overflow-hidden border-2 border-slate-100 shadow-sm">
                                            @if($shop->logo)
                                                <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-contain">
                                            @else
                                                <span class="material-symbols-rounded text-slate-300 text-3xl">store</span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-base font-extrabold text-slate-900 tracking-tight">{{ $shop->name }}</p>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="material-symbols-rounded text-slate-400 text-sm">calendar_today</span>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none">{{ $shop->created_at->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-8">
                                        <div class="text-center group">
                                            <p class="text-sm font-black text-slate-900 leading-none">{{ number_format($shop->customers_count) }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight mt-1">Clients</p>
                                        </div>
                                        <div class="text-center group">
                                            <p class="text-sm font-black text-slate-900 leading-none">{{ number_format($shop->loans_count) }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-tight mt-1">Loans</p>
                                        </div>
                                        <div>
                                            @if($shop->is_active)
                                                <span class="w-2.5 h-2.5 bg-emerald-500 border-2 border-white rounded-full block shadow-[0_0_10px_rgba(16,185,129,0.3)]"></span>
                                            @else
                                                <span class="w-2.5 h-2.5 bg-rose-500 border-2 border-white rounded-full block shadow-[0_0_10px_rgba(244,63,94,0.3)]"></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="lg:col-span-1 space-y-10">
                    <div class="bg-slate-900 premium-shadow rounded-[2.5rem] p-10 text-white relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-600/10 rounded-full blur-3xl"></div>
                        <h3 class="text-[11px] font-black text-blue-400 uppercase tracking-[0.2em] mb-10 relative z-10">Environment Shield</h3>
                        <div class="space-y-10 relative z-10">
                            <div class="flex items-start space-x-5">
                                <div class="bg-white/5 p-2 rounded-xl">
                                    <span class="material-symbols-rounded text-blue-400">security</span>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest text-white">Advanced Isolation</p>
                                    <p class="text-[10px] text-slate-400 mt-2 font-medium leading-relaxed uppercase tracking-tighter italic">Multi-tenant logic enforced via automated global scopes.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-5">
                                <div class="bg-white/5 p-2 rounded-xl">
                                    <span class="material-symbols-rounded text-emerald-400">speed</span>
                                </div>
                                <div>
                                    <p class="text-xs font-black uppercase tracking-widest text-white">Engine Performance</p>
                                    <p class="text-[10px] text-slate-400 mt-2 font-medium leading-relaxed uppercase tracking-tighter italic">Vite 6 / Laravel 11 stack running in hyperspace mode.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-16 pt-10 border-t border-white/5 text-center relative z-10">
                            <div class="flex items-center justify-center space-x-2 text-slate-500">
                                <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></div>
                                <p class="text-[9px] font-black uppercase tracking-[0.3em]">PonNidhi Suite v2.1</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
