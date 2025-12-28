<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('loans.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">add_circle</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('New Loan Origination') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Instrument creation protocol</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12" x-data="loanForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <!-- Card Header Area -->
                <div class="bg-slate-900 px-10 py-10 relative overflow-hidden">
                    <div class="absolute -top-20 -right-20 w-80 h-80 bg-blue-600/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">Core Valuation Metrics</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-80 italic">Precision appraisal and risk mitigation tools</p>
                    </div>
                </div>

                <!-- Form Body -->
                <div class="p-0">
                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf

                        <!-- Section 1: Customer & Timing -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">01</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Client Identity & Temporal Context</h4>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <!-- Customer Selection -->
                                @if(request('customer_id') && ($preSelectedCustomer = $customers->find(request('customer_id'))))
                                    <div class="p-6 bg-white rounded-3xl border border-blue-200 flex items-center justify-between premium-shadow">
                                        <div class="flex items-center">
                                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center text-white mr-5 shadow-lg shadow-slate-900/10">
                                                <span class="material-symbols-rounded text-2xl">person_check</span>
                                            </div>
                                            <div>
                                                <p class="text-[9px] text-blue-600 font-black uppercase tracking-widest leading-none mb-1.5">Authorized Borrower</p>
                                                <p class="text-lg font-extrabold text-slate-900 leading-none uppercase tracking-tight">{{ $preSelectedCustomer->name }}</p>
                                                <p class="text-[10px] text-slate-400 font-bold mt-2 tracking-widest uppercase">{{ $preSelectedCustomer->mobile }}</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="customer_id" value="{{ $preSelectedCustomer->id }}">
                                        <a href="{{ route('loans.create') }}" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors">
                                            <span class="material-symbols-rounded text-lg">edit</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="relative group">
                                        <select name="customer_id" id="customer_id" required
                                            class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all appearance-none bg-white font-bold text-slate-900 text-sm premium-shadow">
                                            <option value="">Locate Registered Client</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} ({{ $customer->mobile }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="customer_id" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                            Borrower Selection <span class="text-rose-600 text-xs">*</span>
                                        </label>
                                        <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">person_search</span>
                                    </div>
                                @endif

                                <!-- Loan Date -->
                                <div class="relative group">
                                    <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-black text-slate-900 text-sm premium-shadow">
                                    <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Documentation Date</label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">calendar_today</span>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Market & Valuation -->
                        <div class="p-10 border-b border-slate-100">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">02</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Collateral Appraisal & Valuation</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                                <!-- Loan Type -->
                                <div class="relative">
                                    <select name="loan_type" id="loan_type" required x-model="loanType" @change="onLoanTypeChange()"
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all appearance-none bg-white font-black uppercase text-[11px] tracking-widest italic text-slate-900 premium-shadow">
                                        <option value="">Asset Class</option>
                                        <option value="Gold">Aurum (Gold)</option>
                                        <option value="Silver">Argentum (Silver)</option>
                                        <option value="Electronics">Technological Assets</option>
                                        <option value="Others">Miscellaneous</option>
                                    </select>
                                    <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Category</label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none text-xl">category</span>
                                </div>

                                <!-- Market Rate -->
                                <div class="relative" x-show="loanType === 'Gold' || loanType === 'Silver'">
                                    <input type="number" name="market_rate" id="market_rate" x-model="marketRate" @input="calculateAmounts()" step="0.01" min="0" placeholder="0.00"
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all font-black text-xl text-slate-900 bg-white premium-shadow">
                                    <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Real-time Rate (₹/gm)</label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-emerald-500 pointer-events-none text-xl">trending_up</span>
                                </div>

                                <!-- Calculated Valuation Info -->
                                <div class="lg:col-span-2 grid grid-cols-2 gap-4" x-show="loanType === 'Gold' || loanType === 'Silver'">
                                    <div class="p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 flex flex-col justify-center">
                                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest leading-none mb-2">Estimated Appraisal</p>
                                        <div class="flex items-baseline space-x-1">
                                            <span class="text-xs font-black text-slate-400">₹</span>
                                            <span x-text="formatCurrency(valuationAmount)" class="text-xl font-black text-slate-900 tracking-tighter"></span>
                                        </div>
                                    </div>
                                    <div class="p-5 bg-blue-600 rounded-[1.5rem] text-white flex flex-col justify-center shadow-lg shadow-blue-600/20">
                                        <p class="text-[9px] text-blue-200 font-black uppercase tracking-widest leading-none mb-2">Loanable Capital</p>
                                        <div class="flex items-baseline space-x-1">
                                            <span class="text-xs font-black text-blue-300">₹</span>
                                            <span x-text="formatCurrency(principalAmount)" class="text-xl font-black text-white tracking-tighter"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="valuation_amount" :value="valuationAmount">
                                    <input type="hidden" name="total_weight" :value="totalWeight">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Financial Terms -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">03</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Financial Parameters & Amortization</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                                <!-- Principal Amount -->
                                <div class="relative">
                                    <input type="number" name="principal_amount" id="principal_amount" x-model="principalAmount" required step="0.01" min="0" 
                                        :readonly="loanType === 'Gold' || loanType === 'Silver'"
                                        class="w-full px-6 py-6 border border-slate-200 rounded-[1.5rem] transition-all font-black text-3xl text-blue-600 bg-white premium-shadow"
                                        :class="{'bg-slate-50/50 cursor-not-allowed': loanType === 'Gold' || loanType === 'Silver'}">
                                    <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest flex items-center">
                                        Disbursement Principal (₹)
                                        <span x-show="loanType === 'Gold' || loanType === 'Silver'" class="ml-2 text-[8px] bg-slate-900 text-white px-2 py-0.5 rounded-full tracking-widest">80% LTV</span>
                                    </label>
                                </div>

                                <!-- Interest Setup -->
                                <div class="grid grid-cols-2 gap-5">
                                    <div class="relative group">
                                        <select name="interest_rate" id="interest_rate" required x-model="interestRate"
                                            class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] appearance-none bg-white font-black text-slate-900 text-sm premium-shadow">
                                            @foreach([1, 1.5, 2, 2.5, 3, 4, 5] as $rate)
                                                <option value="{{ $rate }}">{{ $rate }}% / MO</option>
                                            @endforeach
                                        </select>
                                        <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Interest Rate</label>
                                        <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">percent</span>
                                    </div>
                                    <div class="relative group">
                                        <select name="interest_type" id="interest_type" required class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] appearance-none bg-white font-black text-[10px] uppercase tracking-widest text-slate-500 premium-shadow">
                                            <option value="Flat">Flat Accrual</option>
                                            <option value="Reducing">Reducing Balance</option>
                                        </select>
                                        <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Model</label>
                                    </div>
                                </div>

                                <!-- Duration -->
                                <div class="relative group">
                                    <input type="number" name="loan_period_months" value="12" required 
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] font-black text-slate-900 bg-white premium-shadow">
                                    <label class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Tenure (Months)</label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">schedule</span>
                                </div>

                                <div class="md:col-span-3">
                                    <textarea name="remarks" rows="2" class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] resize-none italic text-sm text-slate-500 bg-white premium-shadow" placeholder="Tactical remarks or operational disclosures..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Article Details -->
                        <div class="p-10">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">04</div>
                                    <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Article Manifest & Technical Manifest</h4>
                                    <div x-show="totalWeight > 0" class="ml-6">
                                        <span x-text="formattedTotalWeight" class="text-[10px] font-black text-slate-900 bg-amber-100 px-4 py-1.5 rounded-full border border-amber-200 shadow-sm animate-pulse-subtle"></span>
                                    </div>
                                </div>
                                <button type="button" @click="addItem()" class="inline-flex items-center space-x-3 px-8 py-4 bg-slate-900 text-white rounded-2xl hover:bg-slate-800 transition-all font-black text-[10px] uppercase tracking-[0.2em] shadow-xl shadow-slate-900/10">
                                    <span class="material-symbols-rounded text-lg">add_box</span>
                                    <span>Register Article</span>
                                </button>
                            </div>

                            <div class="space-y-10">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="p-8 border-2 border-slate-50 rounded-[2.5rem] relative bg-slate-50/50 hover:bg-white hover:border-blue-100 transition-all group premium-shadow">
                                        <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                            class="absolute -top-4 -right-4 w-10 h-10 bg-white text-rose-600 border border-rose-100 rounded-full flex items-center justify-center hover:bg-rose-600 hover:text-white transition-all shadow-lg group-hover:scale-110">
                                            <span class="material-symbols-rounded text-base">delete</span>
                                        </button>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                            <!-- Item Type -->
                                            <div class="relative">
                                                <select x-model="item.item_name" :name="'items['+index+'][item_name]'" required
                                                    class="w-full px-5 py-4 border border-slate-200 rounded-[1.25rem] appearance-none bg-white font-black text-slate-900 uppercase italic text-[11px] tracking-widest premium-shadow">
                                                    <option value="">Asset Specification</option>
                                                    <template x-for="name in getCommonItemNames()" :key="name">
                                                        <option :value="name" x-text="name"></option>
                                                    </template>
                                                    <option value="Others">Non-standard Entry</option>
                                                </select>
                                                <label class="absolute left-5 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Inventory Type</label>
                                            </div>

                                            <div class="relative" x-show="item.item_name === 'Others'">
                                                <input type="text" :name="'items['+index+'][custom_item_name]'" x-model="item.custom_name"
                                                    class="w-full px-5 py-4 border border-blue-200 rounded-[1.25rem] font-bold italic text-sm bg-white premium-shadow" placeholder="Specify nomenclature...">
                                                <label class="absolute left-5 -top-2.5 bg-white px-2 text-[9px] font-black text-blue-600 uppercase tracking-widest">Custom Identity</label>
                                            </div>

                                            <div class="relative">
                                                <select x-model="item.purity" :name="'items['+index+'][purity]'" required
                                                    class="w-full px-5 py-4 border border-slate-200 rounded-[1.25rem] appearance-none bg-white font-black text-[11px] uppercase tracking-widest text-slate-900 premium-shadow">
                                                    <option value="">Assay Standard</option>
                                                    <template x-for="p in getPurityValues()" :key="p">
                                                        <option :value="p" x-text="p"></option>
                                                    </template>
                                                </select>
                                                <label class="absolute left-5 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Certificate</label>
                                            </div>

                                            <!-- Weight Grid -->
                                            <div class="md:col-span-3 grid grid-cols-2 md:grid-cols-4 gap-6 bg-white p-6 rounded-[2rem] border border-slate-100 premium-shadow">
                                                <div class="relative">
                                                    <select x-model.number="item.sovereign" @change="updateItemTotal(index)" class="w-full px-4 py-3 border border-blue-100 rounded-xl appearance-none bg-blue-50/50 font-black text-blue-700 text-sm">
                                                        <template x-for="s in 11" :key="s-1">
                                                            <option :value="s-1" x-text="s-1 + ' SAV'"></option>
                                                        </template>
                                                    </select>
                                                    <label class="absolute left-3 -top-2.5 bg-white px-1 text-[8px] font-black text-blue-400 uppercase tracking-widest italic">Sovereign</label>
                                                </div>
                                                <div class="relative">
                                                    <select x-model.number="item.grams" @change="updateItemTotal(index)" class="w-full px-4 py-3 border border-slate-100 rounded-xl appearance-none bg-slate-50/50 font-black text-slate-900 text-sm">
                                                        <template x-for="g in 9" :key="g-1">
                                                            <option :value="g-1" x-text="g-1 + ' G'"></option>
                                                        </template>
                                                        <option value="2">2G (Alt)</option>
                                                        <option value="4">4G (Alt)</option>
                                                        <option value="8">8G (Alt)</option>
                                                    </select>
                                                    <label class="absolute left-3 -top-2.5 bg-white px-1 text-[8px] font-black text-slate-400 uppercase tracking-widest italic">Grams</label>
                                                </div>
                                                <div class="relative">
                                                    <select x-model.number="item.milli" @change="updateItemTotal(index)" class="w-full px-4 py-3 border border-slate-100 rounded-xl appearance-none bg-slate-50/50 font-black text-slate-900 text-sm">
                                                        <option value="0">0 MG</option>
                                                        <template x-for="m in Array.from({length: 20}, (_, i) => (i + 1) * 5)" :key="m">
                                                            <option :value="m" x-text="m + ' MG'"></option>
                                                        </template>
                                                        <option value="100">100 MG</option>
                                                    </select>
                                                    <label class="absolute left-3 -top-2.5 bg-white px-1 text-[8px] font-black text-slate-400 uppercase tracking-widest italic">Millis</label>
                                                </div>
                                                <div class="flex items-center justify-end px-4 border-l border-slate-100">
                                                    <div class="text-right">
                                                        <p class="text-[9px] font-black text-slate-300 uppercase leading-none mb-1">Total Mass</p>
                                                        <p class="text-lg font-black text-slate-900 tracking-tighter"><span x-text="item.weight.toFixed(3)"></span> <span class="text-[10px] text-slate-400">GMS</span></p>
                                                    </div>
                                                </div>
                                                <input type="hidden" :name="'items['+index+'][weight]'" :value="item.weight">
                                            </div>

                                            <div class="md:col-span-3">
                                                <input type="text" :name="'items['+index+'][description]'" x-model="item.description" required
                                                    class="w-full px-6 py-4 border border-slate-100 rounded-[1.25rem] bg-slate-50 text-xs font-bold text-slate-600 placeholder:text-slate-300 italic" placeholder="Detailed physical observations / Stone data / Wear indicators...">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Submit Protocol -->
                        <div class="p-10 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('loans.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] hover:text-rose-600 transition-colors flex items-center group">
                                <span class="material-symbols-rounded text-base mr-2 group-hover:shake">cancel</span>
                                <span>Terminate Protocol</span>
                            </a>
                            <button type="submit" 
                                class="w-full sm:w-auto px-16 py-5 bg-slate-900 text-white font-black rounded-3xl shadow-2xl shadow-slate-900/20 hover:bg-slate-800 transition-all uppercase tracking-[0.2em] text-[11px] flex items-center justify-center space-x-3 hover:scale-[1.02]">
                                <span class="material-symbols-rounded text-xl">token</span>
                                <span>Authorize & Instantiate Instrument</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loanForm() {
            return {
                loanType: '',
                interestRate: '3',
                marketRate: 0,
                totalWeight: 0,
                valuationAmount: 0,
                principalAmount: 0,
                formattedTotalWeight: '0.000 GMS',
                items: [
                    { item_name: '', custom_name: '', description: '', sovereign: 0, grams: 0, milli: 0, weight: 0, purity: '' }
                ],
                onLoanTypeChange() {
                    this.updateInterestRate();
                    this.calculateAmounts();
                },
                updateInterestRate() {
                    if (this.loanType === 'Gold') this.interestRate = '3';
                    else if (this.loanType === 'Silver') this.interestRate = '2';
                },
                addItem() {
                    this.items.push({ item_name: '', custom_name: '', description: '', sovereign: 0, grams: 0, milli: 0, weight: 0, purity: '' });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                    this.calculateAmounts();
                },
                updateItemTotal(index) {
                    let item = this.items[index];
                    item.weight = (item.sovereign * 8) + item.grams + (item.milli / 1000);
                    this.calculateAmounts();
                },
                calculateAmounts() {
                    this.totalWeight = this.items.reduce((sum, item) => sum + (parseFloat(item.weight) || 0), 0);
                    
                    let totalSovereign = Math.floor(this.totalWeight / 8);
                    let remainingGrams = this.totalWeight % 8;
                    let displayGrams = Math.floor(remainingGrams);
                    let displayMilli = Math.round((remainingGrams - displayGrams) * 1000);
                    
                    let parts = [];
                    if (totalSovereign > 0) parts.push(totalSovereign + ' SAV');
                    if (displayGrams > 0) parts.push(displayGrams + ' G');
                    if (displayMilli > 0) parts.push(displayMilli + ' MG');
                    this.formattedTotalWeight = parts.length > 0 ? parts.join(' ') : '0.000 GMS';

                    if (this.loanType === 'Gold' || this.loanType === 'Silver') {
                        this.valuationAmount = this.totalWeight * (parseFloat(this.marketRate) || 0);
                        this.principalAmount = (this.valuationAmount * 0.8).toFixed(2);
                    } else {
                        // Maintain manual entry threshold
                    }
                },
                getCommonItemNames() {
                    if (this.loanType === 'Gold') return ['Marriage Chain', 'Standard Ring', 'Earring Set', 'Statement Necklace', 'Hand Bangle', 'Anklet Metti', 'Bullion Coin'];
                    if (this.loanType === 'Silver') return ['Traditional Golusu', 'Argentum Ring', 'Design Chain', 'Ritual Vessel', 'Pooja Equipment'];
                    if (this.loanType === 'Electronics') return ['High-end Smartphone', 'Computing Workstation', 'Mobile Tablet'];
                    return [];
                },
                getPurityValues() {
                    if (this.loanType === 'Gold') return ['22K (916 BIS)', '24K (999 PURE)', '18K (750 STD)', '14K (585 ECO)'];
                    if (this.loanType === 'Silver') return ['92.5 (STERLING)', '99.9 (PURE)', '80.0 (TRADITIONAL)'];
                    return [];
                },
                formatCurrency(value) {
                    return new Intl.NumberFormat('en-IN', { minimumFractionDigits: 2 }).format(value);
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .font-black { font-weight: 900; }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }
        .group:hover .group-hover\:shake {
            animation: shake 0.2s ease-in-out infinite;
        }
        .animate-pulse-subtle {
            animation: pulse-subtle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-subtle {
            50% { opacity: .8; transform: scale(0.98); }
        }
    </style>
</x-app-layout>
