<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('payments.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-emerald-600 hover:border-emerald-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-emerald-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-emerald-600 text-3xl">payments</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Post Transaction') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Acquisition of financial inflows</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <!-- Header Area -->
                <div class="bg-indigo-700 px-10 py-10 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-600/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">Revenue Registration</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-80 italic">Formal execution of debt servicing or principal reduction</p>
                    </div>
                </div>

                <div class="p-0">
                    <form action="{{ route('payments.store') }}" method="POST">
                        @csrf

                        <!-- Section 1: Instrument Linkage -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">01</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Details</h4>
                            </div>

                            <div class="relative group">
                                <select name="loan_id" id="loan_id" required
                                    class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-emerald-600/5 focus:border-emerald-600 transition-all appearance-none bg-white font-extrabold text-slate-900 text-lg premium-shadow">
                                    <option value="">Search Ticket #</option>
                                    @foreach($loans as $loan)
                                        <option value="{{ $loan->id }}" {{ (isset($loan_id) && $loan_id == $loan->id) || old('loan_id') == $loan->id ? 'selected' : '' }}>
                                            #{{ $loan->ticket_number }} - {{ $loan->customer->name }} (O/S: ₹{{ number_format($loan->outstanding_principal, 0) }})
                                        </option>
                                    @endforeach
                                </select>
                                <label for="loan_id" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                    Select Loan Ticket <span class="text-rose-600 text-xs">*</span>
                                </label>
                                <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-2xl">search_insights</span>
                                @error('loan_id')
                                    <p class="mt-2 ml-4 text-[10px] text-rose-600 font-bold uppercase tracking-widest flex items-center">
                                        <span class="material-symbols-rounded text-xs mr-1">warning</span>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Section 2: Inflow Parameters -->
                        <div class="p-10">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">02</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Payment Details</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <!-- Amount -->
                                <div class="relative group">
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-emerald-600/5 focus:border-emerald-600 transition-all font-black text-3xl text-emerald-600 bg-white premium-shadow"
                                        placeholder="0.00">
                                    <label for="amount" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        Transaction Value (₹) <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-2xl">account_balance_wallet</span>
                                    @error('amount')
                                        <p class="mt-2 ml-4 text-[10px] text-rose-600 font-bold uppercase tracking-widest flex items-center">
                                            <span class="material-symbols-rounded text-xs mr-1">warning</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Payment Type -->
                                <div class="relative group">
                                    <select name="payment_type" id="payment_type" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-emerald-600/5 focus:border-emerald-600 transition-all appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-xs premium-shadow">
                                        <option value="interest" {{ old('payment_type') == 'interest' ? 'selected' : '' }}>Interest Accrual Service</option>
                                        <option value="principal" {{ old('payment_type') == 'principal' ? 'selected' : '' }}>Principal Reduction</option>
                                        <option value="full_settlement" {{ old('payment_type') == 'full_settlement' ? 'selected' : '' }}>Full Settlement</option>
                                    </select>
                                    <label for="payment_type" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        Payment For <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">account_tree</span>
                                </div>

                                <!-- Method -->
                                <div class="relative group">
                                    <select name="payment_method" id="payment_method" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-[11px] premium-shadow">
                                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Physical Tender (Cash)</option>
                                        <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Digital Inflow (UPI/Bank)</option>
                                        <option value="Cheque" {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                    <label for="payment_method" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        Payment Mode <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">point_of_sale</span>
                                </div>

                                <!-- Date -->
                                <div class="relative group">
                                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-white font-black text-slate-900 text-sm premium-shadow">
                                    <label for="payment_date" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-emerald-600 uppercase tracking-widest">
                                        Execution Timestamp <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">event_available</span>
                                </div>

                                <!-- Reference -->
                                <div class="relative group md:col-span-2">
                                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-slate-50 italic text-slate-500 font-medium text-sm"
                                        placeholder="External transaction hash or reference ID...">
                                    <label for="transaction_id" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Payment Reference (ID)
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-200 pointer-events-none">fingerprint</span>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="p-10 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('payments.index') }}" class="btn-premium btn-premium-secondary">
                                <span class="material-symbols-rounded text-base mr-2">cancel</span>
                                <span>Abort Session</span>
                            </a>
                            <button type="submit" class="btn-premium btn-premium-primary px-16">
                                <span class="material-symbols-rounded text-xl mr-2">receipt_long</span>
                                <span>Save Payment</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }
        .group:hover .group-hover\:shake {
            animation: shake 0.2s ease-in-out infinite;
        }
    </style>
</x-app-layout>
