<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-6 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('customers.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">verified_user</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-none">
                        {{ $customer->name }}
                    </h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-2 italic">Validated Borrower Profile</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.create', ['customer_id' => $customer->id]) }}" 
                    class="px-6 py-3 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 flex items-center space-x-2">
                    <span class="material-symbols-rounded text-base">add_box</span>
                    <span>New Protocol</span>
                </a>
                <a href="{{ route('customers.edit', $customer) }}" 
                    class="px-6 py-3 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/20 flex items-center space-x-2">
                    <span class="material-symbols-rounded text-base text-blue-400">edit_square</span>
                    <span>Modify Profile</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ activeTooltip: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                <!-- Identity Sidebar -->
                <div class="lg:col-span-1 space-y-10">
                    <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden relative group">
                        <div class="h-32 bg-slate-900"></div>
                        <div class="px-8 pb-10 text-center relative">
                            <div class="relative -mt-16 mb-6 inline-block">
                                @if($customer->photo)
                                    <img src="{{ Storage::url($customer->photo) }}" class="w-32 h-32 rounded-[2.5rem] border-8 border-white premium-shadow object-cover bg-white group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white premium-shadow bg-slate-100 flex items-center justify-center text-slate-200 group-hover:scale-105 transition-transform duration-500">
                                        <span class="material-symbols-rounded text-6xl">person</span>
                                    </div>
                                @endif
                                <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-500 border-4 border-white rounded-xl shadow-lg flex items-center justify-center">
                                    <span class="material-symbols-rounded text-white text-xs">check_circle</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $customer->name }}</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2 italic">Client ID: {{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</p>
                            
                            <div class="mt-8 flex justify-center space-x-4">
                                <a href="tel:{{ $customer->mobile }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-400 rounded-2xl hover:bg-blue-600 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded">call</span>
                                </a>
                                <a href="https://wa.me/{{ $customer->mobile }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-400 rounded-2xl hover:bg-emerald-600 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded text-2xl leading-none">chat</span>
                                </a>
                                @if($customer->email)
                                <a href="mailto:{{ $customer->email }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-400 rounded-2xl hover:bg-indigo-600 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded">mail</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="border-t border-slate-100 px-8 py-8 bg-slate-50/30">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Contact Matrix</h4>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">smartphone</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 italic">+91 {{ $customer->mobile }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mt-1">Mobile Terminal</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">home_pin</span>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-600 italic leading-relaxed">{{ $customer->address }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none mt-2">{{ $customer->city }}, {{ $customer->pincode }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Asset Verification Card -->
                    <div class="bg-slate-900 premium-shadow rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10">Verification Protocol</h4>
                        <div class="flex items-center justify-between p-5 bg-white/5 rounded-2xl border border-white/10 relative z-10 transition-colors group-hover:bg-white/10">
                            <div class="flex items-center">
                                <span class="material-symbols-rounded text-blue-400 mr-4">badge</span>
                                <div>
                                    <p class="text-xs font-black text-white uppercase tracking-widest">{{ $customer->id_proof_type }}</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase mt-1 italic">Type of identity document</p>
                                </div>
                            </div>
                        </div>
                        <p class="mt-6 text-2xl font-black text-white italic tracking-widest bg-white/5 p-4 rounded-xl text-center border-2 border-white/5 group-hover:border-blue-500/30 transition-all">{{ $customer->id_proof_number }}</p>
                    </div>
                </div>

                <!-- Operational History -->
                <div class="lg:col-span-3 space-y-10">
                    <!-- Global Statistics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-20 h-20 bg-slate-50 rounded-full blur-2xl group-hover:bg-slate-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Total Protocols</p>
                                <div class="flex items-end justify-between">
                                    <p class="text-4xl font-black text-slate-900 italic tracking-tighter">{{ $customer->loans->count() }}</p>
                                    <div class="w-10 h-10 bg-slate-900 text-white rounded-xl flex items-center justify-center">
                                        <span class="material-symbols-rounded text-sm">history</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Active Instruments</p>
                                <div class="flex items-end justify-between">
                                    <p class="text-4xl font-black text-emerald-600 italic tracking-tighter">{{ $customer->loans->where('status', 'Active')->count() }}</p>
                                    <div class="w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center">
                                        <span class="material-symbols-rounded text-sm animate-pulse">sensors</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <div class="bg-slate-900 premium-shadow rounded-[2.5rem] p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Aggregated Exposure</p>
                                <div class="flex items-end justify-between">
                                    <p class="text-4xl font-black text-white italic tracking-tighter">₹{{ number_format($customer->loans->sum('principal_amount'), 0) }}</p>
                                    <div class="w-10 h-10 bg-white/10 text-white rounded-xl flex items-center justify-center border border-white/10">
                                        <span class="material-symbols-rounded text-sm">account_balance_wallet</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>

                    <!-- Loan Ledger -->
                    <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Protocol Ledger</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Lifecycle history of all pawn instruments</p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <tr>
                                        <th class="px-10 py-5">Instrument ID</th>
                                        <th class="px-6 py-5">Classification</th>
                                        <th class="px-6 py-5 text-center">Collateral</th>
                                        <th class="px-6 py-5">Valuation</th>
                                        <th class="px-6 py-5 text-center">Status</th>
                                        <th class="px-10 py-5 text-right">Protocol Link</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($customer->loans->sortByDesc('created_at') as $loan)
                                    <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                        <td class="px-10 py-6">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase tracking-widest">{{ $loan->loan_date->format('d M Y') }}</p>
                                            <span class="text-sm font-black text-indigo-600 italic tracking-widest">#{{ $loan->ticket_number }}</span>
                                        </td>
                                        <td class="px-6 py-6">
                                            <span class="text-[10px] font-black text-slate-900 uppercase italic tracking-tighter bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">{{ $loan->loan_type }}</span>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <div class="relative inline-block" @mouseenter="activeTooltip = {{ $loan->id }}" @mouseleave="activeTooltip = null">
                                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mx-auto premium-shadow border border-slate-100 group-hover:bg-indigo-600 transition-colors duration-300">
                                                    <span class="material-symbols-rounded text-slate-400 text-xl group-hover:text-white">inventory_2</span>
                                                </div>
                                                
                                                <!-- Premium Tooltip -->
                                                <div x-show="activeTooltip === {{ $loan->id }}" 
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                    class="absolute z-50 w-72 bg-slate-900 text-white rounded-[2rem] p-8 shadow-2xl -left-32 bottom-full mb-6 text-left border border-white/10"
                                                    x-cloak>
                                                    <p class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-4 border-b border-indigo-500/20 pb-2">Article Manifest</p>
                                                    <div class="space-y-4">
                                                        @foreach($loan->items as $item)
                                                            <div class="border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                                                <p class="font-black text-white uppercase text-[11px] italic leading-tight">{{ $item->item_name }}</p>
                                                                <p class="text-slate-400 text-[9px] font-bold uppercase mt-1 tracking-widest">{{ $item->formatted_weight }} | {{ $item->purity }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="absolute w-4 h-4 bg-slate-900 rotate-45 -bottom-2 left-1/2 -ml-2 border-r border-b border-white/10"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 font-mono">
                                            <p class="text-sm font-black text-slate-900 leading-none italic">₹{{ number_format($loan->principal_amount, 2) }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">{{ (float)$loan->interest_rate }}% Periodic Accrual</p>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                                                {{ $loan->status == 'Active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $loan->status == 'Active' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                                                {{ $loan->status }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="{{ route('loans.show', $loan) }}" class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white transition-all duration-300 premium-shadow">
                                                <span class="material-symbols-rounded text-base">export_notes</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-10 py-20 text-center opacity-40">
                                            <span class="material-symbols-rounded text-6xl text-slate-200">contract_delete</span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-6 italic">No historical protocols found</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .premium-shadow { box-shadow: 0 20px 50px -12px rgba(15, 23, 42, 0.08); }
    </style>
</x-app-layout>
