<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('loans.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-indigo-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-indigo-600 text-3xl">edit_document</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Refine Instrument') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Ticket #{{ $loan->ticket_number }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <!-- Header Area -->
                <div class="bg-slate-900 px-10 py-10 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-black text-white uppercase tracking-widest">{{ $loan->customer->name }}</h3>
                            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-80 italic">Verified Primary Borrower</p>
                        </div>
                        <div class="text-right">
                             <span class="px-4 py-2 bg-white/10 rounded-xl text-white font-black text-xs tracking-widest backdrop-blur-sm border border-white/10 uppercase">
                                {{ $loan->status }}
                             </span>
                        </div>
                    </div>
                </div>

                <div class="p-0">
                    <form action="{{ route('loans.update', $loan) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Financial Recalibration -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">01</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Financial Parameters</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <!-- Loan Type -->
                                <div class="relative group md:col-span-2">
                                    <select name="loan_type" id="loan_type" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-xs premium-shadow">
                                        <option value="Gold" {{ old('loan_type', $loan->loan_type) == 'Gold' ? 'selected' : '' }}>Gold Asset</option>
                                        <option value="Silver" {{ old('loan_type', $loan->loan_type) == 'Silver' ? 'selected' : '' }}>Silver Asset</option>
                                        <option value="Electronics" {{ old('loan_type', $loan->loan_type) == 'Electronics' ? 'selected' : '' }}>Electronic Equipment</option>
                                        <option value="Others" {{ old('loan_type', $loan->loan_type) == 'Others' ? 'selected' : '' }}>Miscellaneous Collateral</option>
                                    </select>
                                    <label for="loan_type" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Collateral Class <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">inventory_2</span>
                                </div>

                                <!-- Principal (Read-only) -->
                                <div class="relative group">
                                    <input type="number" value="{{ $loan->principal_amount }}" readonly
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-slate-100 font-black text-3xl text-slate-400 cursor-not-allowed italic">
                                    <label class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Immutable Principal (₹)
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-200 pointer-events-none text-2xl">lock</span>
                                </div>

                                <!-- Interest Rate -->
                                <div class="relative group">
                                    <select name="interest_rate" id="interest_rate" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all appearance-none bg-white font-black text-slate-900 text-lg premium-shadow">
                                        @foreach([1, 1.5, 2, 2.5, 3, 4, 5] as $rate)
                                            <option value="{{ $rate }}" {{ old('interest_rate', (float)$loan->interest_rate) == $rate ? 'selected' : '' }}>
                                                {{ $rate }}% / Periodic
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="interest_rate" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Periodic Accrual % <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">trending_up</span>
                                </div>

                                <!-- Interest Style -->
                                <div class="relative group">
                                    <select name="interest_type" id="interest_type" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-xs premium-shadow">
                                        <option value="Flat" {{ old('interest_type', $loan->interest_type) == 'Flat' ? 'selected' : '' }}>Flat Amortization</option>
                                        <option value="Reducing" {{ old('interest_type', $loan->interest_type) == 'Reducing' ? 'selected' : '' }}>Diminishing Balance</option>
                                    </select>
                                    <label for="interest_type" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Amortization Logic <span class="text-rose-600">*</span>
                                    </label>
                                </div>

                                <!-- Duration -->
                                <div class="relative group">
                                    <input type="number" name="loan_period_months" id="loan_period_months" value="{{ old('loan_period_months', $loan->loan_period_months) }}" required min="1"
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all bg-white font-black text-slate-900 text-lg premium-shadow"
                                        placeholder="0">
                                    <label for="loan_period_months" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Temporal Window (Months) <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">timelapse</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Operational Constants -->
                        <div class="p-10 border-b border-slate-100">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">02</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Operational Metadata</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <!-- Date -->
                                <div class="relative group">
                                    <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-white font-black text-slate-900 text-sm premium-shadow">
                                    <label for="loan_date" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Origination Timestamp <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">calendar_month</span>
                                </div>

                                <!-- Status -->
                                <div class="relative group">
                                    <select name="status" id="status" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-[11px] premium-shadow">
                                        <option value="Active" {{ old('status', $loan->status) == 'Active' ? 'selected' : '' }}>Operational (Active)</option>
                                        <option value="Overdue" {{ old('status', $loan->status) == 'Overdue' ? 'selected' : '' }}>Maturity Breach (Overdue)</option>
                                        <option value="Closed" {{ old('status', $loan->status) == 'Closed' ? 'selected' : '' }}>Terminated (Closed)</option>
                                        <option value="Auctioned" {{ old('status', $loan->status) == 'Auctioned' ? 'selected' : '' }}>Liquidation Executed (Auctioned)</option>
                                    </select>
                                    <label for="status" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-rose-600 uppercase tracking-widest">
                                        Protocol Status <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-2xl">sensors</span>
                                </div>

                                <!-- Penalty -->
                                <div class="relative group md:col-span-2">
                                    <input type="number" name="penalty_rate" id="penalty_rate" value="{{ old('penalty_rate', $loan->penalty_rate) }}" step="0.01" min="0" max="100"
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-slate-50 font-bold text-slate-600 text-lg"
                                        placeholder="0.00">
                                    <label for="penalty_rate" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Non-Compliance Penalty %
                                    </label>
                                    <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-200 pointer-events-none">gavel</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Article Manifest -->
                        <div class="p-10 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">03</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Article Manifest</h4>
                            </div>

                            @php $item = $loan->items->first(); @endphp
                            <div class="space-y-10">
                                <div class="relative group">
                                    <textarea name="item_description" id="item_description" rows="2" required
                                        class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all bg-white font-medium text-slate-900 text-sm premium-shadow resize-none italic"
                                        placeholder="Detailed physical characteristics and identification marks...">{{ old('item_description', $item->description ?? '') }}</textarea>
                                    <label for="item_description" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">
                                        Technical Description <span class="text-rose-600">*</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    <div class="relative group">
                                        <input type="number" name="item_weight" id="item_weight" value="{{ old('item_weight', $item->weight ?? '') }}" step="0.001" min="0"
                                            class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-white font-black text-slate-900 text-lg premium-shadow">
                                        <label for="item_weight" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">Measured Mass (gms)</label>
                                        <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">monitor_weight</span>
                                    </div>
                                    <div class="relative group">
                                        <input type="text" name="item_purity" id="item_purity" value="{{ old('item_purity', $item->purity ?? '') }}"
                                            class="w-full px-8 py-6 border border-slate-200 rounded-[2rem] bg-white font-black text-indigo-600 text-lg premium-shadow tracking-widest"
                                            placeholder="Standard Purity...">
                                        <label for="item_purity" class="absolute left-8 -top-2.5 bg-white px-2 text-[10px] font-black text-indigo-600 uppercase tracking-widest">Elemental Purity</label>
                                        <span class="material-symbols-rounded absolute right-8 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">diamond</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="p-10 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('loans.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] hover:text-rose-600 transition-colors flex items-center group">
                                <span class="material-symbols-rounded text-base mr-2 group-hover:shake">cancel</span>
                                <span>Abort Session</span>
                            </a>
                            <button type="submit" 
                                class="w-full sm:w-auto px-16 py-6 bg-slate-900 text-white font-black rounded-[2.5rem] shadow-2xl shadow-slate-900/20 hover:bg-slate-800 transition-all uppercase tracking-[0.2em] text-[11px] flex items-center justify-center space-x-3 hover:scale-[1.02]">
                                <span class="material-symbols-rounded text-xl">docs_add_on</span>
                                <span>Commit Protocol refinement</span>
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
