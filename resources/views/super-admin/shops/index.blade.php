<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">store</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Tenant Governance') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Global shop & license management</p>
                </div>
            </div>
            <a href="{{ route('super-admin.shops.create') }}" class="btn-premium btn-premium-primary">
                <span class="material-symbols-rounded text-lg mr-2">add_business</span>
                <span>Onboard New Tenant</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <!-- Search Bar -->
            <div class="bg-white premium-shadow rounded-[2rem] border border-slate-200 overflow-hidden">
                <form method="GET" action="{{ route('super-admin.shops.index') }}" class="p-6">
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Search by shop name or tenant name..." 
                                class="w-full pl-12 pr-4 py-4 border-2 border-slate-100 rounded-2xl focus:border-blue-600 focus:ring-0 transition-all text-sm font-medium placeholder:text-slate-400"
                            >
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="btn-premium btn-premium-primary">
                                <span class="material-symbols-rounded text-lg mr-2">filter_list</span>
                                <span>Search</span>
                            </button>
                            @if($search)
                                <a href="{{ route('super-admin.shops.index') }}" class="btn-premium btn-premium-secondary">
                                    <span class="material-symbols-rounded text-lg mr-2">close</span>
                                    <span>Clear</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    @if($search)
                        <div class="mt-4 px-4 py-2 bg-blue-50 border border-blue-100 rounded-xl">
                            <p class="text-xs font-bold text-blue-600">
                                <span class="material-symbols-rounded text-sm align-middle">info</span>
                                Showing results for: <span class="font-black italic">"{{ $search }}"</span>
                            </p>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Mobile View (Card Based) -->
            <div class="grid grid-cols-1 gap-6 md:hidden">
                @forelse($shops as $shop)
                    <div class="bg-white premium-shadow rounded-[2rem] border border-slate-200 overflow-hidden">
                        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 p-1">
                                    @if($shop->logo)
                                        <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-200">
                                            <span class="material-symbols-rounded text-2xl">image</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-black text-slate-900 uppercase text-xs">{{ $shop->name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold mt-1">ID: {{ str_pad($shop->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 rounded-full {{ $shop->is_active ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                <span class="text-[9px] font-black uppercase text-slate-400">{{ $shop->is_active ? 'Active' : 'Suspended' }}</span>
                            </div>
                        </div>
                        <div class="p-6 bg-slate-50/50">
                            <div class="flex items-center space-x-2 mb-4">
                                <span class="material-symbols-rounded text-slate-400 text-sm">mail</span>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $shop->users->first()?->email ?: 'No Admin' }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center">
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Customers</p>
                                    <p class="text-xl font-black text-slate-900 mt-1">{{ number_format($shop->customers_count) }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center">
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Loans</p>
                                    <p class="text-xl font-black text-slate-900 mt-1">{{ number_format($shop->loans_count) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 border-t border-slate-100 grid grid-cols-3 gap-3">
                            <a href="{{ route('super-admin.shops.show', $shop) }}" class="px-4 py-3 bg-indigo-700 text-white rounded-xl text-center text-[10px] font-black uppercase tracking-widest">View</a>
                            <a href="{{ route('super-admin.shops.edit', $shop) }}" class="px-4 py-3 bg-blue-50 text-blue-600 rounded-xl text-center text-[10px] font-black uppercase tracking-widest">Edit</a>
                            <form action="{{ route('super-admin.shops.toggle-status', $shop) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="w-full px-4 py-3 {{ $shop->is_active ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} rounded-xl text-[10px] font-black uppercase tracking-widest">
                                    {{ $shop->is_active ? 'Suspend' : 'Active' }}
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white premium-shadow rounded-[2rem] border border-slate-200 overflow-hidden p-12 text-center">
                        <span class="material-symbols-rounded text-slate-300 text-6xl">search_off</span>
                        <h3 class="text-lg font-black text-slate-900 mt-4 uppercase tracking-tight">No Tenants Found</h3>
                        <p class="text-sm text-slate-500 mt-2">
                            @if($search)
                                No shops match your search criteria. Try a different search term.
                            @else
                                No shops have been registered yet.
                            @endif
                        </p>
                        @if($search)
                            <a href="{{ route('super-admin.shops.index') }}" class="inline-block mt-6 px-8 py-3 bg-indigo-700 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-800 transition-all">
                                View All Tenants
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            <!-- Desktop View (Table Based) -->
            <div class="hidden md:block">
                <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden">
                    <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">Global Tenant Registry</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Live monitoring of all registered shops</p>
                        </div>
                        <div class="flex items-center space-x-6">
                            <div class="px-5 py-2 bg-indigo-50 border border-indigo-100 rounded-xl">
                                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-widest leading-none">Total Nodes: {{ $shops->total() }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-200">
                                    <th class="px-10 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em]">Shop Identity</th>
                                    <th class="px-8 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-center">Business Metrics</th>
                                    <th class="px-8 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-center">System Status</th>
                                    <th class="px-10 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-right">Operational Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($shops as $shop)
                                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                        <td class="px-10 py-8">
                                             <div class="flex items-center space-x-5">
                                                 <div class="relative group">
                                                     <div class="w-16 h-16 rounded-3xl bg-slate-50 border-2 border-slate-100 p-1 shadow-sm overflow-hidden flex items-center justify-center group-hover:border-blue-200 transition-colors">
                                                         @if($shop->logo)
                                                             <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-contain">
                                                         @else
                                                             <span class="material-symbols-rounded text-slate-300 text-4xl">image</span>
                                                         @endif
                                                     </div>
                                                     @if($shop->is_active)
                                                         <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full"></div>
                                                     @endif
                                                 </div>
                                                 <div>
                                                     <p class="text-lg font-extrabold text-slate-900 tracking-tight leading-none group-hover:text-blue-600 transition-colors">{{ $shop->name }}</p>
                                                     <div class="flex flex-col space-y-1 mt-2">
                                                         <div class="flex items-center space-x-2">
                                                             <span class="material-symbols-rounded text-slate-400 text-sm">mail</span>
                                                             <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $shop->users->first()?->email ?: 'No Admin' }}</p>
                                                         </div>
                                                         <div class="flex items-center space-x-2">
                                                             <span class="material-symbols-rounded text-slate-400 text-xs">person</span>
                                                             <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest italic">{{ $shop->users->first()?->name ?: 'N/A' }}</p>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <div class="flex items-center justify-center space-x-8">
                                                <div class="text-center">
                                                    <p class="text-xl font-black text-slate-900 leading-none">{{ number_format($shop->customers_count) }}</p>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2">Clients</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xl font-black text-slate-900 leading-none">{{ number_format($shop->loans_count) }}</p>
                                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-2">Instruments</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8 text-center">
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $shop->is_active ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-100' }}">
                                                {{ $shop->is_active ? 'Authorized' : 'Suspended' }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-8 text-right">
                                             <div class="flex items-center justify-end space-x-3">
                                                 <a href="{{ route('super-admin.shops.show', $shop) }}" class="w-10 h-10 flex items-center justify-center bg-indigo-700 text-white rounded-2xl hover:bg-indigo-800 transition-all shadow-lg" title="View Full Profile">
                                                     <span class="material-symbols-rounded text-xl leading-none">visibility</span>
                                                 </a>
                                                 <form action="{{ route('super-admin.shops.toggle-status', $shop) }}" method="POST">
                                                     @csrf
                                                     @method('PATCH')
                                                     <button type="submit" class="w-10 h-10 flex items-center justify-center transition-all rounded-2xl border-2 {{ $shop->is_active ? 'border-amber-100 text-amber-600 hover:bg-amber-50 hover:border-amber-200' : 'border-emerald-100 text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200' }}" title="{{ $shop->is_active ? 'Suspend' : 'Authorize' }}">
                                                         <span class="material-symbols-rounded text-xl leading-none">@if($shop->is_active)pause_circle @else play_circle @endif</span>
                                                     </button>
                                                 </form>
                                                 <a href="{{ route('super-admin.shops.edit', $shop) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-100 border-2 border-slate-50 transition-all rounded-2xl" title="Configure Details">
                                                     <span class="material-symbols-rounded text-xl leading-none">settings</span>
                                                 </a>
                                             </div>
                                         </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-10 py-20 text-center">
                                            <span class="material-symbols-rounded text-slate-300 text-6xl">search_off</span>
                                            <h3 class="text-lg font-black text-slate-900 mt-4 uppercase tracking-tight">No Tenants Found</h3>
                                            <p class="text-sm text-slate-500 mt-2">
                                                @if($search)
                                                    No shops match your search criteria. Try a different search term.
                                                @else
                                                    No shops have been registered yet.
                                                @endif
                                            </p>
                                            @if($search)
                                                <a href="{{ route('super-admin.shops.index') }}" class="inline-block mt-6 px-8 py-3 bg-indigo-700 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-800 transition-all">
                                                    View All Tenants
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($shops->hasPages())
                        <div class="px-10 py-8 bg-slate-50 border-t border-slate-100">
                            {{ $shops->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
