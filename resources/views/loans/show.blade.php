<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                    <span class="material-icons text-gray-600">arrow_back</span>
                </a>
                <span class="material-icons text-blue-600 text-3xl">receipt</span>
                <div>
                    <h2 class="font-black text-xl sm:text-2xl text-gray-800 leading-none">
                        Loan #{{ $loan->ticket_number }}
                    </h2>
                    <p class="text-[10px] sm:text-xs text-gray-400 font-bold uppercase tracking-widest mt-1">Digital Ledger Record</p>
                </div>
            </div>
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 sm:pb-0 scrollbar-hide">
                @if($loan->status === 'Active')
                    <a href="{{ route('loans.ticket', $loan) }}" 
                        class="inline-flex items-center space-x-1 shrink-0 bg-white border border-gray-200 text-gray-700 font-black text-[10px] uppercase tracking-tighter px-3 py-2 rounded-lg hover:bg-gray-50 transition-all">
                        <span class="material-icons text-sm">print</span>
                        <span>Ticket</span>
                    </a>
                    <a href="{{ route('loans.pawn-ticket', $loan) }}" 
                        class="inline-flex items-center space-x-1 shrink-0 bg-blue-50 text-blue-700 font-black text-[10px] uppercase tracking-tighter px-3 py-2 rounded-lg hover:bg-blue-100 transition-all">
                        <span class="material-icons text-sm">download</span>
                        <span>PDF</span>
                    </a>
                    <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" 
                        class="inline-flex items-center space-x-1 shrink-0 bg-green-600 text-white font-black text-[10px] uppercase tracking-tighter px-4 py-2 rounded-lg hover:bg-green-700 transition-all shadow-lg shadow-green-100">
                        <span class="material-icons text-sm">payments</span>
                        <span>Pay</span>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            
            <!-- Financial Overview Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <!-- Principal Card -->
                <div class="md-card elevation-2 overflow-hidden border-l-4 border-blue-600 bg-white">
                    <div class="p-5 sm:p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Principal Amount</p>
                        <p class="text-2xl sm:text-3xl font-black text-blue-600 mt-2">₹{{ number_format($loan->principal_amount, 2) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-[10px] font-black text-gray-500 uppercase font-mono">{{ $loan->loan_type }}</span>
                            <span class="text-[9px] bg-blue-100 text-blue-700 px-2 py-0.5 rounded font-black uppercase tracking-tighter">80% LTV Locked</span>
                        </div>
                    </div>
                </div>

                <!-- Interest Card -->
                <div class="md-card elevation-2 overflow-hidden border-l-4 border-purple-600 bg-white">
                    <div class="p-5 sm:p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Accrued Interest</p>
                        <p class="text-2xl sm:text-3xl font-black text-purple-600 mt-2">₹{{ number_format($loan->interest_accrued, 2) }}</p>
                        <div class="mt-4 flex items-center justify-between text-[10px] text-gray-500 font-black uppercase tracking-tighter">
                            <span>{{ $loan->formatted_time_passed }}</span>
                            <span>@ {{ (float)$loan->interest_rate }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Market Value Card (Hidden on mobile maybe? No, keep it) -->
                <div class="md-card elevation-2 overflow-hidden border-l-4 border-green-600 bg-white sm:col-span-2 lg:col-span-1">
                    <div class="p-5 sm:p-6">
                        <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest leading-none">Market Valuation</p>
                        <p class="text-2xl sm:text-3xl font-black text-gray-900 mt-2">₹{{ number_format($loan->valuation_amount, 2) }}</p>
                        <div class="mt-4 flex items-center justify-between text-[10px] text-gray-500 font-black uppercase tracking-tighter">
                            <span>₹{{ number_format($loan->market_rate, 2) }}/gm</span>
                            <span class="text-green-600">Active Collateral</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Articles & Payments -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Pawned Articles -->
                    <div class="md-card elevation-2 bg-white overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-2 sm:space-y-0">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Pawned Articles</h3>
                            <div class="flex items-center space-x-2">
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[10px] font-black border border-blue-100">
                                    Total: {{ number_format($loan->total_weight, 3) }} gms
                                </span>
                            </div>
                        </div>
                        
                        <!-- Mobile Item View (Stacks) -->
                        <div class="block sm:hidden divide-y divide-gray-100">
                            @foreach($loan->items as $item)
                                <div class="p-5 space-y-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="text-xs font-black text-gray-900 uppercase">{{ $item->item_name }}</p>
                                            <p class="text-[10px] text-blue-600 font-black mt-1">{{ $item->purity }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-black text-gray-900 leading-none">{{ $item->formatted_weight }}</p>
                                            <p class="text-[10px] text-gray-400 font-bold mt-1">({{ number_format($item->weight, 3) }} gms)</p>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-gray-500 italic bg-gray-50 p-2 rounded">{{ $item->description }}</p>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-widest text-left">
                                    <tr>
                                        <th class="px-6 py-4">Article</th>
                                        <th class="px-6 py-4">Purity</th>
                                        <th class="px-6 py-4">Description</th>
                                        <th class="px-6 py-4 text-right">Weight Details</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($loan->items as $item)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-5 font-black text-gray-900 uppercase text-xs">{{ $item->item_name }}</td>
                                            <td class="px-6 py-5">
                                                <span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded font-black text-[10px]">{{ $item->purity }}</span>
                                            </td>
                                            <td class="px-6 py-5 text-[10px] text-gray-500 italic">{{ $item->description }}</td>
                                            <td class="px-6 py-5 text-right">
                                                <p class="text-xs font-black text-gray-900 leading-none">{{ $item->formatted_weight }}</p>
                                                <p class="text-[10px] text-gray-400 font-bold mt-1">({{ number_format($item->weight, 3) }} gms)</p>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payment Ledger -->
                    <div class="md-card elevation-2 bg-white overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/30">
                            <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest">Payment History</h3>
                        </div>
                        <div class="p-5">
                            @if($loan->payments->count() > 0)
                                <div class="space-y-3">
                                    @foreach($loan->payments as $payment)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-green-200 transition-colors">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center shrink-0">
                                                    <span class="material-icons text-green-600 text-sm">payments</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-black text-gray-900">₹{{ number_format($payment->amount, 2) }}</p>
                                                    <p class="text-[9px] text-gray-400 font-black uppercase tracking-widest mt-0.5">{{ $payment->payment_date->format('d M Y') }}</p>
                                                </div>
                                            </div>
                                            <span class="hidden sm:inline-block text-[9px] font-black text-gray-400 uppercase tracking-widest bg-white border border-gray-200 px-3 py-1 rounded-full">{{ $payment->payment_method }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-10">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <span class="material-icons text-gray-300">history</span>
                                    </div>
                                    <p class="text-xs text-gray-400 font-black uppercase tracking-widest">No transaction history</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar (Stacks on Mobile) -->
                <div class="space-y-6">
                    <!-- O/S Breakdown Card -->
                    <div class="md-card elevation-3 border-2 border-red-100 bg-white overflow-hidden">
                        <div class="p-6 bg-red-50/50 border-b border-red-50">
                            <h3 class="text-xs font-black text-red-400 uppercase tracking-widest mb-4">Redemption Status</h3>
                            
                            <div class="space-y-6 relative before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-red-100">
                                <div class="relative pl-8">
                                    <div class="absolute left-1.5 top-1 w-3 h-3 bg-red-200 rounded-full border-2 border-white"></div>
                                    <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 leading-none">Maturity Target</p>
                                    <div class="flex justify-between items-baseline">
                                        <p class="text-xs font-black text-gray-800 uppercase">{{ $loan->due_date->format('d M Y') }}</p>
                                        <p class="text-[10px] font-black text-gray-400">Total: ₹{{ number_format($loan->maturity_value, 2) }}</p>
                                    </div>
                                </div>

                                <div class="relative pl-8">
                                    <div class="absolute left-1.5 top-1 w-3 h-3 bg-red-600 rounded-full border-2 border-white"></div>
                                    <p class="text-[9px] font-black text-red-600 uppercase tracking-widest mb-1 leading-none">Closing Balance (Today)</p>
                                    <p class="text-3xl font-black text-red-600 tracking-tighter italic">₹{{ number_format($loan->remaining_balance, 2) }}</p>
                                    <p class="text-[9px] text-red-400 font-bold uppercase tracking-tighter mt-1">Calculated as of {{ now()->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                            <span class="text-[10px] font-black text-gray-400 uppercase">Loan Status</span>
                            <span class="px-3 py-1 rounded bg-red-600 text-white text-[9px] font-black uppercase tracking-widest">{{ $loan->status }}</span>
                        </div>
                    </div>

                    <!-- Customer Detail Card -->
                    <div class="md-card elevation-2 bg-gray-900 text-white p-6 overflow-hidden relative">
                        <!-- Decoration -->
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <span class="material-icons text-8xl">verified_user</span>
                        </div>
                        
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shrink-0 shadow-lg shadow-blue-900/50">
                                <span class="material-icons text-white">person</span>
                            </div>
                            <div>
                                <h4 class="font-black text-base uppercase tracking-tight leading-none truncate w-40">{{ $loan->customer->name }}</h4>
                                <p class="text-[10px] text-gray-400 font-black mt-1 uppercase tracking-widest">+91 {{ $loan->customer->mobile }}</p>
                            </div>
                        </div>

                        <div class="space-y-4 pt-6 border-t border-white/5 relative z-10">
                            <div class="flex items-start space-x-3">
                                <span class="material-icons text-gray-500 text-sm mt-0.5">place</span>
                                <p class="text-[11px] text-gray-300 leading-relaxed font-bold">{{ $loan->customer->address }}, {{ $loan->customer->city }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="material-icons text-gray-500 text-sm">badge</span>
                                <p class="text-[11px] font-black text-blue-400 uppercase tracking-widest">{{ $loan->customer->id_proof_type }} Verified</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('customers.show', $loan->customer) }}" class="mt-8 w-full block text-center py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                            View Full Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .font-black { font-weight: 900; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</x-app-layout>
