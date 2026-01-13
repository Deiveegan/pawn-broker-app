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
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-2 italic">Verified Customer Profile</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.create', ['customer_id' => $customer->id]) }}" class="btn-premium btn-premium-success">
                    <span class="material-symbols-rounded text-base mr-2">add_box</span>
                    <span>New Loan</span>
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="btn-premium btn-premium-primary">
                    <span class="material-symbols-rounded text-base text-blue-400 mr-2">edit_square</span>
                    <span>Edit Details</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="{ activeTooltip: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
                <!-- Identity Sidebar -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Profile Card -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden relative group">
                        <div class="h-32 bg-indigo-700 overflow-hidden relative">
                             <!-- Decorative Patterns -->
                             <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
                             <div class="absolute bottom-0 left-0 w-24 h-24 bg-blue-500/10 rounded-full -ml-12 -mb-12 blur-xl"></div>
                        </div>
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
                                    <span class="material-symbols-rounded text-white text-[12px] font-bold">check</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight font-heading">{{ $customer->name }}</h3>
                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-2 italic font-heading">Customer ID: {{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</p>
                            
                            <div class="mt-8 flex justify-center space-x-4">
                                <a href="tel:{{ $customer->mobile }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-500 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded text-xl">call</span>
                                </a>
                                <a href="https://wa.me/{{ $customer->mobile }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-500 rounded-full hover:bg-emerald-600 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded text-xl leading-none">chat</span>
                                </a>
                                @if($customer->email)
                                <a href="mailto:{{ $customer->email }}" class="w-12 h-12 flex items-center justify-center bg-slate-50 text-slate-500 rounded-full hover:bg-indigo-700 hover:text-white transition-all duration-300 premium-shadow group/icon">
                                    <span class="material-symbols-rounded text-xl">mail</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="border-t border-slate-50 px-8 py-8 bg-slate-50/30">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 font-heading">Contact Information</h4>
                            <div class="space-y-6">
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">smartphone</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 italic font-heading">+91 {{ $customer->mobile }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest leading-none mt-1">Phone Number</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center shrink-0 premium-shadow mr-4">
                                        <span class="material-symbols-rounded text-slate-400 text-sm">location_on</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-medium text-slate-600 italic leading-snug">{{ $customer->address }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest leading-none mt-2 font-heading">{{ $customer->city }}, {{ $customer->pincode }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Asset Verification Card -->
                    <div class="bg-indigo-700 premium-shadow rounded-[2.5rem] p-8 text-white relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                        <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10 font-heading">Identity Verification</h4>
                        <div class="flex items-center justify-between p-5 bg-white/5 rounded-2xl border border-white/10 relative z-10 transition-colors group-hover:bg-white/10">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center mr-4">
                                    <span class="material-symbols-rounded text-blue-400">badge</span>
                                </div>
                                <div>
                                    <p class="text-xs font-black text-white uppercase tracking-widest font-heading">{{ $customer->id_proof_type }}</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase mt-1 italic">Type of identity document</p>
                                </div>
                            </div>
                        </div>
                        <p class="mt-6 text-2xl font-black text-white italic tracking-[0.1em] bg-white/5 p-5 rounded-2xl text-center border-2 border-white/5 group-hover:border-blue-500/30 transition-all font-heading leading-none">{{ $customer->id_proof_number }}</p>
                    </div>
                </div>

                <!-- Operational History -->
                <div class="lg:col-span-3 space-y-10">
                    <!-- Global Statistics -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-50 rounded-full blur-2xl group-hover:bg-slate-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 font-heading">All Loans</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-5xl font-black text-indigo-700 italic tracking-tighter font-heading">{{ $customer->loans->count() }}</p>
                                    <div class="w-12 h-12 bg-indigo-700 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-700/20">
                                        <span class="material-symbols-rounded text-xl">history</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 font-heading">Current Loans</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-5xl font-black text-emerald-600 italic tracking-tighter font-heading">{{ $customer->loans->where('status', 'Active')->count() }}</p>
                                    <div class="w-12 h-12 bg-emerald-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-600/20">
                                        <span class="material-symbols-rounded text-xl animate-pulse">sensors</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                        <div class="bg-indigo-700 premium-shadow rounded-[2.5rem] p-8 relative overflow-hidden group">
                           <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                           <div class="relative z-10">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 font-heading">Total Loan Amount</p>
                                <div class="flex items-center justify-between">
                                    <p class="text-4xl font-black text-white italic tracking-tighter font-heading">₹{{ number_format($customer->loans->sum('principal_amount'), 0) }}</p>
                                    <div class="w-12 h-12 bg-white/10 text-white rounded-2xl flex items-center justify-center border border-white/10 shadow-lg">
                                        <span class="material-symbols-rounded text-xl">payments</span>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>

                    <!-- Loan Ledger -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest font-heading italic">Loan List</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-tight">History of all loans</p>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <tr>
                                        <th class="px-10 py-6">Loan ID</th>
                                        <th class="px-6 py-6">Loan Type</th>
                                        <th class="px-6 py-6 text-center">Jewellery</th>
                                        <th class="px-6 py-6">Amount</th>
                                        <th class="px-6 py-6 text-center">Status</th>
                                        <th class="px-10 py-6 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @forelse($customer->loans->sortByDesc('created_at') as $loan)
                                    <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                        <td class="px-10 py-6">
                                            <p class="text-[10px] text-slate-400 font-bold mb-1 uppercase tracking-widest">{{ $loan->loan_date->format('d M Y') }}</p>
                                            <span class="text-sm font-black text-blue-600 italic tracking-[0.1em] font-heading">#{{ $loan->ticket_number }}</span>
                                        </td>
                                        <td class="px-6 py-6">
                                            <span class="text-[10px] font-black text-slate-900 uppercase italic tracking-tighter bg-slate-100 px-4 py-1.5 rounded-lg border border-slate-200 font-heading">{{ $loan->loan_type }}</span>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <div class="relative inline-block" @mouseenter="activeTooltip = {{ $loan->id }}" @mouseleave="activeTooltip = null">
                                                <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center mx-auto premium-shadow border border-slate-100 group-hover:bg-indigo-700 transition-colors duration-300">
                                                    <span class="material-symbols-rounded text-slate-400 text-xl group-hover:text-white">inventory_2</span>
                                                </div>
                                                
                                                <!-- Premium Tooltip -->
                                                <div x-show="activeTooltip === {{ $loan->id }}" 
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                                    class="absolute z-50 w-72 bg-indigo-700 text-white rounded-[2rem] p-8 shadow-2xl -left-32 bottom-full mb-6 text-left border border-white/10"
                                                    x-cloak>
                                                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.2em] mb-4 border-b border-blue-500/20 pb-2 font-heading">Jewellery Details</p>
                                                    <div class="space-y-4">
                                                        @foreach($loan->items as $item)
                                                            <div class="border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                                                <p class="font-black text-white uppercase text-[11px] italic leading-tight font-heading">{{ $item->item_name }}</p>
                                                                <p class="text-slate-400 text-[9px] font-bold uppercase mt-1 tracking-widest">{{ $item->formatted_weight }} | {{ $item->purity }}</p>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    <div class="absolute w-4 h-4 bg-indigo-700 rotate-45 -bottom-2 left-1/2 -ml-2 border-r border-b border-white/10"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-6 font-mono">
                                            <p class="text-sm font-black text-slate-900 leading-none italic font-heading">₹{{ number_format($loan->principal_amount, 2) }}</p>
                                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">3% Monthly Interest</p>
                                        </td>
                                        <td class="px-6 py-6 text-center">
                                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest font-heading
                                                {{ $loan->status == 'Active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $loan->status == 'Active' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                                                {{ $loan->status }}
                                            </span>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="{{ route('loans.show', $loan) }}" class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-700 hover:text-white transition-all duration-300 premium-shadow">
                                                <span class="material-symbols-rounded text-base">export_notes</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-10 py-20 text-center opacity-40">
                                            <span class="material-symbols-rounded text-6xl text-slate-200">contract_delete</span>
                                            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-6 italic font-heading">No past loans found</p>
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
