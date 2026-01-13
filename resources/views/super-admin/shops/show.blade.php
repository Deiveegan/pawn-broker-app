<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('super-admin.shops.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">store</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ $shop->name }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Tenant Profile & Governance</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('super-admin.shops.edit', $shop) }}" class="px-6 py-3 bg-indigo-700 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-800 transition-all shadow-xl shadow-indigo-600/20 flex items-center space-x-2">
                    <span class="material-symbols-rounded text-base">settings</span>
                    <span>Adjust Parameters</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                <!-- Shop Profile Sidebar -->
                <div class="lg:col-span-1 space-y-10">
                    <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden relative group">
                        <div class="h-32 bg-indigo-700"></div>
                        <div class="px-8 pb-10 text-center relative">
                            <div class="relative -mt-16 mb-6 inline-block">
                                @if($shop->logo)
                                    <img src="{{ Storage::url($shop->logo) }}" class="w-32 h-32 rounded-[2.5rem] border-8 border-white premium-shadow object-contain bg-white transition-transform duration-500">
                                @else
                                    <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white premium-shadow bg-slate-100 flex items-center justify-center text-slate-200 transition-transform duration-500">
                                        <span class="material-symbols-rounded text-6xl">storefront</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 {{ $shop->is_active ? 'bg-emerald-500' : 'bg-rose-500' }} border-4 border-white rounded-xl shadow-lg flex items-center justify-center">
                                    <span class="material-symbols-rounded text-white text-xs">{{ $shop->is_active ? 'check_circle' : 'pause_circle' }}</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $shop->name }}</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2 italic">Tenant ID: {{ str_pad($shop->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="border-t border-slate-100 px-8 py-8 bg-slate-50/30">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Metadata</h4>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">location_on</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-600 italic leading-relaxed">{{ $shop->address ?: 'No Address Specified' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">calendar_month</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 italic">{{ $shop->created_at->format('d M Y') }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mt-1">Registration Date</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Administrator Details -->
                    <div class="bg-indigo-700 premium-shadow rounded-[2.5rem] p-8 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10">Assigned Administrator</h4>
                        @php $admin = $shop->users->first(); @endphp
                        @if($admin)
                            <div class="space-y-6 relative z-10">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10">
                                        <span class="material-symbols-rounded text-blue-400">person</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-white italic">{{ $admin->name }}</p>
                                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">Primary Access Holder</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-white/5 rounded-2xl border border-white/5">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="material-symbols-rounded text-slate-500 text-sm">mail</span>
                                        <p class="text-[10px] font-black text-blue-400 tracking-widest uppercase truncate">{{ $admin->email }}</p>
                                    </div>
                                    <p class="text-[9px] text-slate-500 font-medium italic">All system notifications and security alerts are routed to this terminal.</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 relative z-10">
                                <span class="material-symbols-rounded text-rose-400 text-4xl">no_accounts</span>
                                <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest mt-4 italic">Orphaned Tenant: No Admin detected</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Business Performance Metrics -->
                <div class="lg:col-span-3 space-y-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Client Base -->
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group hover:border-blue-200 transition-all">
                           <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full blur-3xl group-hover:bg-blue-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Cumulative Client Base</p>
                                <div class="flex items-end justify-between">
                                    <p class="text-5xl font-black text-slate-900 italic tracking-tighter">{{ number_format($shop->customers_count) }}</p>
                                    <div class="w-12 h-12 bg-indigo-700 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                        <span class="material-symbols-rounded text-xl">groups</span>
                                    </div>
                                </div>
                                <p class="mt-6 text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2"></span>
                                    Total Registered Customers
                                </p>
                           </div>
                        </div>

                        <!-- Loan Portfolio -->
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group hover:border-indigo-200 transition-all">
                           <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full blur-3xl group-hover:bg-indigo-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Managed Loan Portfolio</p>
                                <div class="flex items-end justify-between">
                                    <p class="text-5xl font-black text-slate-900 italic tracking-tighter">{{ number_format($shop->loans_count) }}</p>
                                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/20">
                                        <span class="material-symbols-rounded text-xl">contract</span>
                                    </div>
                                </div>
                                <p class="mt-6 text-[10px] text-slate-400 font-bold uppercase tracking-widest flex items-center">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-2"></span>
                                    Total Lifecycle Instruments
                                </p>
                           </div>
                        </div>
                    </div>

                    <!-- Operational Control Grid -->
                    <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 p-10">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Governance & Controls</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Tenant access and security parameters</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="p-8 rounded-[2rem] border border-slate-100 bg-slate-50/50">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Service Authorization</h4>
                                <div class="flex items-center justify-between">
                                    <div>
                                        @if($shop->is_active)
                                            <p class="text-sm font-black text-emerald-600 italic">AUTHORIZED</p>
                                            <p class="text-[10px] text-slate-400 font-medium uppercase mt-1">Currently serving clients</p>
                                        @else
                                            <p class="text-sm font-black text-rose-600 italic">SUSPENDED</p>
                                            <p class="text-[10px] text-slate-400 font-medium uppercase mt-1">Access restricted by governor</p>
                                        @endif
                                    </div>
                                    <form action="{{ route('super-admin.shops.toggle-status', $shop) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-6 py-3 {{ $shop->is_active ? 'bg-amber-100 text-amber-600 hover:bg-amber-600 hover:text-white' : 'bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white' }} font-black text-[9px] uppercase tracking-widest rounded-xl transition-all premium-shadow">
                                            {{ $shop->is_active ? 'Suspend Operations' : 'Restore Service' }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div class="p-8 rounded-[2rem] border border-slate-100 bg-slate-50/50">
                                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">System Health</h4>
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
                                        <span class="material-symbols-rounded text-sm">verified</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-slate-900 uppercase italic">Ledger Integrity: OK</p>
                                        <p class="text-[9px] text-slate-400 font-medium uppercase mt-1">Last sync: {{ now()->format('H:i') }} UTC</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
