<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-6 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('payments.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border borshadow-indigo-600/10 text-slate-400 hover:text-emerald-600 hover:border-emerald-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-emerald-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-emerald-600 text-3xl">receipt_long</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight leading-none font-heading">
                        Receipt #{{ $payment->receipt_number }}
                    </h2>
                    <div class="flex items-center space-x-2 mt-2">
                        <span class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] italic">Payment Received</span>
                        <span class="text-[10px] text-emerald-600/40">•</span>
                        <span class="text-[10px] text-emerald-600 font-black uppercase tracking-[0.2em] italic">{{ $payment->shop ? $payment->shop->name : config('app.name') }}</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('payments.receipt', $payment) }}" class="btn-premium btn-premium-primary">
                    <span class="material-symbols-rounded text-base text-emerald-400 mr-2">download</span>
                    <span>Download PDF</span>
                </a>
                <button onclick="window.print()" class="btn-premium btn-premium-secondary">
                    <span class="material-symbols-rounded text-base mr-2">print</span>
                    <span>Print</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[3rem] border border-slate-100 overflow-hidden">
                <!-- Status Header -->
                <div class="bg-indigo-700 px-10 py-16 text-center relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10">
                        <div class="mb-6">
                            @if($payment->shop && $payment->shop->logo)
                                <img src="{{ asset('storage/' . $payment->shop->logo) }}" alt="Shop Logo" class="h-12 mx-auto mb-4">
                            @endif
                            <h4 class="text-emerald-400 text-xs font-black uppercase tracking-[0.3em] font-heading">{{ $payment->shop ? $payment->shop->name : config('app.name') }}</h4>
                        </div>
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-emerald-500/10 rounded-[2rem] mb-8 border border-emerald-500/20">
                            <span class="material-symbols-rounded text-emerald-500 text-5xl">verified</span>
                        </div>
                        <h3 class="text-3xl font-black text-white italic tracking-tight font-heading">Payment Received</h3>
                        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-3">Payment ID: {{ $payment->transaction_id ?? 'PX-'.str_pad($payment->id, 8, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>

                <div class="p-12 space-y-12">
                    <!-- Amount Section -->
                    <div class="text-center pb-12 border-b border-slate-50">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Paid Amount</p>
                        <p class="text-6xl font-black text-slate-900 mt-4 font-heading italic tracking-tighter">₹{{ number_format($payment->amount, 2) }}</p>
                        <div class="mt-8">
                            <span class="px-6 py-2 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-xl border border-emerald-100 uppercase tracking-[0.15em] font-heading shadow-sm">
                                {{ str_replace('_', ' ', $payment->payment_type) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                        <!-- Left: Transaction Metadata -->
                        <div class="space-y-8">
                            <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-widest font-heading italic">Payment Details</h4>
                            <div class="space-y-5">
                                <div class="flex justify-between items-center group">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Payment Date</span>
                                    <span class="text-xs font-black text-slate-900 font-heading italic">{{ $payment->payment_date->format('d M, Y') }} @ {{ $payment->payment_date->format('H:i') }}</span>
                                </div>
                                <div class="flex justify-between items-center group">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Payment Mode</span>
                                    <span class="text-xs font-black text-indigo-600 font-heading italic uppercase tracking-widest">{{ $payment->payment_method }}</span>
                                </div>
                                <div class="flex justify-between items-center group">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</span>
                                    <span class="flex items-center text-xs font-black text-emerald-600 font-heading italic uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                                        Received
                                    </span>
                                </div>
                            </div>

                            @if($payment->notes)
                            <div class="mt-8 p-6 bg-slate-50 rounded-[2rem] border border-slate-100">
                                <h5 class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-3 italic">Staff Notes</h5>
                                <p class="text-xs text-slate-500 leading-relaxed font-bold italic">"{{ $payment->notes }}"</p>
                            </div>
                            @endif
                        </div>

                        <!-- Right: Linked Instrument -->
                        <div class="space-y-8">
                            <h4 class="text-[11px] font-black text-slate-900 uppercase tracking-widest font-heading italic">Customer Details</h4>
                            <a href="{{ route('loans.show', $payment->loan) }}" class="block group">
                                <div class="p-8 bg-indigo-700 rounded-[2.5rem] border border-indigo-600/50 group-hover:bg-indigo-800 transition-all duration-500 relative overflow-hidden">
                                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
                                    <div class="flex items-center justify-between mb-6 relative z-10">
                                        <span class="text-[9px] font-black text-indigo-400 bg-indigo-400/10 px-3 py-1 rounded-lg border border-indigo-400/20 font-heading">LOAN-{{ $payment->loan->ticket_number }}</span>
                                        <span class="material-symbols-rounded text-slate-500 group-hover:text-white group-hover:translate-x-1 transition-all">arrow_forward</span>
                                    </div>
                                    <p class="text-xl font-black text-white font-heading italic tracking-tight">{{ $payment->loan->customer->name }}</p>
                                    <div class="flex items-center text-[11px] font-black text-slate-400 mt-2 uppercase tracking-widest">
                                        <span class="material-symbols-rounded text-sm mr-2 text-indigo-400/60">phone_iphone</span>
                                        {{ $payment->loan->customer->mobile }}
                                    </div>
                                    <div class="mt-8 pt-6 border-t border-white/5 relative z-10">
                                        <div class="flex justify-between items-center">
                                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Loan Amount</span>
                                            <span class="text-sm font-black text-white font-heading italic">₹{{ number_format($payment->loan->principal_amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="bg-slate-50 px-10 py-6 border-t border-slate-100 text-center">
                    <p class="text-[9px] text-slate-300 font-bold uppercase tracking-[0.25em]">Computer Generated Receipt</p>
                </div>
            </div>

            <!-- Contextual Operations -->
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <a href="{{ route('payments.create') }}" class="btn-premium btn-premium-secondary p-8 flex-1">
                    <span class="material-symbols-rounded text-emerald-600 mr-3">add_card</span>
                    <span>New Payment</span>
                </a>
                <a href="{{ route('dashboard') }}" class="btn-premium btn-premium-primary p-8 flex-1">
                    <span class="material-symbols-rounded text-white mr-3">dashboard</span>
                    <span>Back to Dashboard</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, .header-shadow, .mt-10 { display: none !important; }
            .py-10 { padding: 0 !important; }
            .premium-shadow { box-shadow: none !important; border: 1px solid #eee !important; }
            .bg-indigo-700 { background-color: #4338ca !important; color-adjust: exact; }
            .font-heading { font-family: 'Outfit', sans-serif !important; }
        }
    </style>
</x-app-layout>
