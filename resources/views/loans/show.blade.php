<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-6 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('loans.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-indigo-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-indigo-600 text-3xl">contract</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-none">
                        Instrument #{{ $loan->ticket_number }}
                    </h2>
                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-2 italic shadow-sm">Authenticated Ledger Document</p>
                </div>
            </div>
            <div class="flex items-center space-x-3 overflow-x-auto pb-2 sm:pb-0 scrollbar-hide">
                @if($loan->status === 'Active')
                    <a href="{{ route('loans.ticket', $loan) }}" 
                        class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-all premium-shadow flex items-center space-x-2">
                        <span class="material-symbols-rounded text-base">print</span>
                        <span>Ticket</span>
                    </a>
                    <a href="{{ route('loans.pawn-ticket', $loan) }}" 
                        class="px-5 py-2.5 bg-slate-900 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-900/10 flex items-center space-x-2">
                        <span class="material-symbols-rounded text-base text-indigo-400">download</span>
                        <span>Export PDF</span>
                    </a>
                    <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" 
                        class="px-6 py-2.5 bg-emerald-600 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 flex items-center space-x-2">
                        <span class="material-symbols-rounded text-base">payments</span>
                        <span>Post Payment</span>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Financial Matrix -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Principal -->
                <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none relative z-10">Principal Obligation</p>
                    <p class="text-3xl font-black text-slate-900 mt-4 relative z-10 italic">₹{{ number_format($loan->principal_amount, 2) }}</p>
                    <div class="mt-6 flex items-center justify-between relative z-10">
                        <span class="px-3 py-1 bg-slate-900 text-white text-[9px] font-black uppercase rounded-lg tracking-widest italic">{{ $loan->loan_type }}</span>
                        <span class="text-[9px] font-black text-indigo-600 uppercase">LTV: 80% Locked</span>
                    </div>
                </div>

                <!-- Interest -->
                <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors"></div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none relative z-10">Accrued Interest</p>
                    <p class="text-3xl font-black text-rose-600 mt-4 relative z-10 italic">₹{{ number_format($loan->interest_accrued, 2) }}</p>
                    <div class="mt-6 flex items-center justify-between relative z-10 text-[9px] font-black uppercase tracking-widest">
                        <span class="text-slate-500 italic">{{ (float)$loan->interest_rate }}% Monthly</span>
                        <span class="text-rose-400">{{ $loan->formatted_time_passed }} Passed</span>
                    </div>
                </div>

                <!-- Market Value -->
                <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-8 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none relative z-10">Asset Valuation</p>
                    <p class="text-3xl font-black text-slate-900 mt-4 relative z-10 italic">₹{{ number_format($loan->valuation_amount, 2) }}</p>
                    <div class="mt-6 flex items-center justify-between relative z-10 text-[9px] font-black uppercase tracking-widest text-slate-500">
                        <span>₹{{ number_format($loan->market_rate, 2) }}/gm</span>
                        <span class="text-emerald-600 flex items-center"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1 animate-pulse"></span> Active Collateral</span>
                    </div>
                </div>

                <!-- Closing Balance -->
                <div class="bg-slate-900 premium-shadow rounded-[2.5rem] p-8 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-widest leading-none">Net Recouperas</p>
                    <p class="text-3xl font-black text-white mt-4 italic tracking-tighter">₹{{ number_format($loan->remaining_balance, 2) }}</p>
                    <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between">
                        <span class="text-[9px] font-black text-slate-500 uppercase">Settlement Target</span>
                        @php
                            $daysLeft = now()->diffInDays($loan->due_date, false);
                        @endphp
                        <span class="text-[9px] font-black {{ $daysLeft < 0 ? 'text-rose-500' : 'text-emerald-400' }} uppercase">
                            {{ $daysLeft < 0 ? abs($daysLeft).' Days Overdue' : $daysLeft.' Days Remaining' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Protocol Manifest -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Article Manifest -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Article Manifest</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Verified physical collateral assets</p>
                            </div>
                            <div class="text-right">
                                <span class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20">
                                    Total Weight: {{ number_format($loan->total_weight, 3) }} gms
                                </span>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                                    <tr>
                                        <th class="px-10 py-5">Nomenclature</th>
                                        <th class="px-6 py-5">Elemental Purity</th>
                                        <th class="px-6 py-5">Technical Specs</th>
                                        <th class="px-10 py-5 text-right">Mass Quantum</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    @foreach($loan->items as $item)
                                        <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                            <td class="px-10 py-6">
                                                <p class="font-black text-slate-900 uppercase text-xs italic">{{ $item->item_name }}</p>
                                            </td>
                                            <td class="px-6 py-6">
                                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-black text-[9px] border border-indigo-100 uppercase tracking-tighter">
                                                    {{ $item->purity }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-6">
                                                <p class="text-[10px] text-slate-500 font-medium italic max-w-xs">{{ $item->description }}</p>
                                            </td>
                                            <td class="px-10 py-6 text-right">
                                                <p class="text-sm font-black text-slate-900 leading-none italic">{{ $item->formatted_weight }}</p>
                                                <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">Net: {{ number_format($item->weight, 3) }} gms</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Transaction Ledger -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Financial Ledger</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Acquisition history & inflow events</p>
                        </div>
                        <div class="p-4 sm:p-10">
                            @if($loan->payments->count() > 0)
                                <div class="space-y-4">
                                    @foreach($loan->payments->sortByDesc('payment_date') as $payment)
                                        <div class="flex items-center justify-between px-8 py-6 bg-slate-50/50 rounded-[2rem] border border-slate-100 hover:border-emerald-200 hover:bg-white transition-all duration-300 group">
                                            <div class="flex items-center space-x-6">
                                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shrink-0 premium-shadow group-hover:bg-emerald-600 transition-colors">
                                                    <span class="material-symbols-rounded text-slate-400 text-xl group-hover:text-white">receipt_long</span>
                                                </div>
                                                <div>
                                                    <p class="text-lg font-black text-slate-900 italic">₹{{ number_format($payment->amount, 2) }}</p>
                                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">{{ $payment->payment_date->format('d M Y') }} • {{ $payment->payment_type }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right hidden sm:block">
                                                <span class="px-4 py-1.5 rounded-full bg-white text-slate-400 text-[9px] font-black uppercase tracking-widest border border-slate-100 group-hover:border-emerald-100 group-hover:text-emerald-600 transition-all">{{ $payment->payment_method }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-16 opacity-40">
                                    <span class="material-symbols-rounded text-6xl text-slate-200">history_edu</span>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-6 italic">No ledger entries detected</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Entity Information -->
                <div class="space-y-10">
                    <!-- Borrower Profile -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden relative group">
                        <div class="absolute inset-0 bg-slate-900 opacity-0 group-hover:opacity-[0.02] transition-opacity duration-500"></div>
                        <div class="p-10">
                            <div class="flex items-center space-x-6 mb-8">
                                <div class="relative">
                                    @if($loan->customer->photo)
                                        <img src="{{ Storage::url($loan->customer->photo) }}" class="w-20 h-20 rounded-[1.5rem] object-cover premium-shadow border-4 border-slate-50">
                                    @else
                                        <div class="w-20 h-20 rounded-[1.5rem] bg-indigo-50 flex items-center justify-center text-indigo-200 premium-shadow">
                                            <span class="material-symbols-rounded text-4xl">person_pin</span>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-2 -right-2 bg-emerald-500 w-6 h-6 rounded-lg border-4 border-white flex items-center justify-center">
                                        <span class="material-symbols-rounded text-[10px] text-white">verified</span>
                                    </div>
                                </div>
                                <div class="flex-1 truncate">
                                    <h4 class="font-black text-lg text-slate-900 uppercase tracking-tight leading-none truncate">{{ $loan->customer->name }}</h4>
                                    <p class="text-[10px] text-indigo-600 font-black mt-2 uppercase tracking-widest">+91 {{ $loan->customer->mobile }}</p>
                                </div>
                            </div>

                            <div class="space-y-6 pt-8 border-t border-slate-100 relative z-10">
                                <div class="flex items-start space-x-4">
                                    <span class="material-symbols-rounded text-slate-300 text-xl mt-0.5">home_pin</span>
                                    <div>
                                        <p class="text-[11px] text-slate-500 leading-relaxed font-medium italic">{{ $loan->customer->address }}</p>
                                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">{{ $loan->customer->city }}, {{ $loan->customer->state }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="material-symbols-rounded text-slate-300 text-xl">shield_person</span>
                                    <p class="text-[10px] font-black text-slate-900 uppercase tracking-widest">{{ $loan->customer->id_proof_type }} Authenticated</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('customers.show', $loan->customer) }}" 
                                class="mt-10 w-full flex items-center justify-center py-4 bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-400 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 group/btn">
                                <span>Inspect Borrower Profile</span>
                                <span class="material-symbols-rounded text-sm ml-2 group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        </div>
                    </div>

                    <!-- Maturity Countdown -->
                    <div class="bg-indigo-900 premium-shadow rounded-[2.5rem] p-10 text-white relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
                        <div class="relative z-10">
                            <h4 class="text-[10px] font-black uppercase tracking-[0.25em] text-indigo-300 mb-8">Maturity Countdown</h4>
                            <div class="space-y-8">
                                <div>
                                    <p class="text-[10px] text-white/40 uppercase font-black tracking-widest leading-none">Origination Date</p>
                                    <p class="text-sm font-black mt-2 italic text-indigo-100">{{ $loan->loan_date->format('d F Y') }}</p>
                                </div>
                                <div class="pt-6 border-t border-white/10">
                                    <p class="text-[10px] text-white/40 uppercase font-black tracking-widest leading-none">Expected Liquidation</p>
                                    <p class="text-sm font-black mt-2 italic text-indigo-100">{{ $loan->due_date->format('d F Y') }}</p>
                                </div>
                                <div class="pt-10">
                                    <div class="flex justify-between items-end mb-4">
                                        <p class="text-5xl font-black italic tracking-tighter leading-none">{{ $daysLeft < 0 ? 'MATURED' : $daysLeft }}</p>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-indigo-300 opacity-60">{{ $daysLeft < 0 ? 'Lapsed' : 'Days left' }}</p>
                                    </div>
                                    <div class="w-full h-2 bg-white/10 rounded-full overflow-hidden">
                                        @php
                                            $totalDays = $loan->loan_period_months * 30;
                                            $percent = $totalDays > 0 ? max(0, min(100, (1 - ($daysLeft / $totalDays)) * 100)) : 100;
                                        @endphp
                                        <div class="h-full bg-indigo-400 rounded-full" style="width: {{ $percent }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .premium-shadow { box-shadow: 0 20px 50px -12px rgba(15, 23, 42, 0.08); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
