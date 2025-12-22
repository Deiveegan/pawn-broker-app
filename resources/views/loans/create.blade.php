<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('loans.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">add_circle</span>
            <h2 class="font-black text-2xl text-gray-800 tracking-tighter uppercase">
                {{ __('New Loan Origination') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10" x-data="loanForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="md-card elevation-2 overflow-hidden bg-white">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h3 class="text-xl font-black text-white uppercase tracking-widest">Loan Information</h3>
                    <p class="text-blue-100 text-[10px] font-bold uppercase tracking-widest mt-1 opacity-80">Calculate precisely based on weight and market rate</p>
                </div>

                <!-- Card Body -->
                <div class="p-0">
                    <form action="{{ route('loans.store') }}" method="POST">
                        @csrf

                        <!-- Section 1: Customer & Timing -->
                        <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                                Step 1: Client & Date
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Customer Selection -->
                                @if(request('customer_id') && ($preSelectedCustomer = $customers->find(request('customer_id'))))
                                    <div class="p-5 bg-white rounded-2xl border-2 border-blue-200 flex items-center justify-between shadow-sm">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mr-4 shadow-lg shadow-blue-100">
                                                <span class="material-icons text-2xl">person</span>
                                            </div>
                                            <div>
                                                <p class="text-[9px] text-blue-600 font-black uppercase tracking-widest">Selected Client</p>
                                                <p class="text-lg font-black text-gray-900 leading-none uppercase">{{ $preSelectedCustomer->name }}</p>
                                                <p class="text-xs text-gray-500 font-bold mt-1 tracking-tighter">{{ $preSelectedCustomer->mobile }}</p>
                                            </div>
                                        </div>
                                        <input type="hidden" name="customer_id" value="{{ $preSelectedCustomer->id }}">
                                        <a href="{{ route('loans.create') }}" class="p-2 bg-blue-50 text-blue-600 rounded-xl hover:bg-blue-100 transition-colors">
                                            <span class="material-icons text-sm">edit</span>
                                        </a>
                                    </div>
                                @else
                                    <div class="relative">
                                        <select name="customer_id" id="customer_id" required
                                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-all appearance-none bg-white font-bold text-gray-700 shadow-sm">
                                            <option value="">Search/Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }} - {{ $customer->mobile }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="customer_id" class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                            Borrower Name <span class="text-red-500">*</span>
                                        </label>
                                        <span class="material-icons absolute right-4 top-4.5 text-gray-400 pointer-events-none">search</span>
                                    </div>
                                @endif

                                <!-- Loan Date -->
                                <div class="relative">
                                    <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" required
                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 focus:outline-none transition-all bg-white font-bold text-gray-700 shadow-sm">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Agreement Date</label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Market & Valuation -->
                        <div class="p-8 border-b border-gray-100">
                            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-6 bg-green-600 rounded-full mr-3"></span>
                                Step 2: Asset Valuation
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Loan Type -->
                                <div class="relative lg:col-span-1">
                                    <select name="loan_type" id="loan_type" required x-model="loanType" @change="onLoanTypeChange()"
                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 transition-all appearance-none bg-white font-black uppercase text-xs tracking-widest italic">
                                        <option value="">Asset Type</option>
                                        <option value="Gold">Gold</option>
                                        <option value="Silver">Silver</option>
                                        <option value="Electronics">Electronics</option>
                                        <option value="Others">Others</option>
                                    </select>
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Category</label>
                                    <span class="material-icons absolute right-4 top-4.5 text-gray-400 pointer-events-none">category</span>
                                </div>

                                <!-- Market Rate -->
                                <div class="relative lg:col-span-1" x-show="loanType === 'Gold' || loanType === 'Silver'">
                                    <input type="number" name="market_rate" id="market_rate" x-model="marketRate" @input="calculateAmounts()" step="0.01" min="0" placeholder="0.00"
                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 transition-all font-black text-xl text-gray-900 leading-none shadow-sm">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Rate (₹/gm)</label>
                                </div>

                                <!-- Calculated Valuation Info -->
                                <div class="lg:col-span-2 grid grid-cols-2 gap-4" x-show="loanType === 'Gold' || loanType === 'Silver'">
                                    <div class="p-4 bg-green-50 rounded-2xl border border-green-100">
                                        <p class="text-[9px] text-green-600 font-black uppercase tracking-widest leading-none">Market Value</p>
                                        <p class="text-xl font-black text-gray-900 mt-2">₹<span x-text="formatCurrency(valuationAmount)"></span></p>
                                    </div>
                                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                                        <p class="text-[9px] text-blue-600 font-black uppercase tracking-widest leading-none">Security Value</p>
                                        <p class="text-xl font-black text-gray-900 mt-2">₹<span x-text="formatCurrency(principalAmount)"></span></p>
                                    </div>
                                    <input type="hidden" name="valuation_amount" :value="valuationAmount">
                                    <input type="hidden" name="total_weight" :value="totalWeight">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Financial Terms -->
                        <div class="p-8 border-b border-gray-100 bg-gray-50/30">
                            <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center">
                                <span class="w-2 h-6 bg-purple-600 rounded-full mr-3"></span>
                                Step 3: Finance & Terms
                            </h4>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <!-- Principal Amount -->
                                <div class="relative">
                                    <input type="number" name="principal_amount" id="principal_amount" x-model="principalAmount" required step="0.01" min="0" 
                                        :readonly="loanType === 'Gold' || loanType === 'Silver'"
                                        class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl transition-all font-black text-2xl text-blue-700 bg-white"
                                        :class="{'bg-gray-50 cursor-not-allowed': loanType === 'Gold' || loanType === 'Silver'}">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Loan Amount (₹)
                                        <span x-show="loanType === 'Gold' || loanType === 'Silver'" class="text-[9px] bg-blue-600 text-white px-1.5 py-0.5 rounded ml-1 tracking-tighter shadow-sm shadow-blue-200">80% LTV</span>
                                    </label>
                                </div>

                                <!-- Interest Setup -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <select name="interest_rate" id="interest_rate" required x-model="interestRate"
                                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl focus:border-blue-500 appearance-none bg-white font-black text-sm">
                                            @foreach([1, 1.5, 2, 2.5, 3, 4, 5] as $rate)
                                                <option value="{{ $rate }}">{{ $rate }}%</option>
                                            @endforeach
                                        </select>
                                        <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Int. Rate</label>
                                    </div>
                                    <div class="relative">
                                        <select name="interest_type" id="interest_type" required class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl appearance-none bg-white font-black text-xs uppercase tracking-tighter text-gray-500">
                                            <option value="Flat">Flat</option>
                                            <option value="Reducing">Reducing</option>
                                        </select>
                                        <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Int. Type</label>
                                    </div>
                                </div>

                                <!-- Duration & Notes -->
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="relative">
                                        <input type="number" name="loan_period_months" value="12" required 
                                            class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl font-black text-gray-900">
                                        <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Period (Months)</label>
                                    </div>
                                </div>
                                <div class="md:col-span-3">
                                    <textarea name="remarks" rows="1" class="w-full px-4 py-4 border-2 border-gray-200 rounded-2xl resize-none italic text-sm text-gray-500" placeholder="Internal remarks / Special conditions..."></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Article Details -->
                        <div class="p-8">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                                <h4 class="text-sm font-black text-gray-400 uppercase tracking-widest flex items-center">
                                    <span class="w-2 h-6 bg-orange-500 rounded-full mr-3"></span>
                                    Step 4: Pledged Articles
                                    <div x-show="totalWeight > 0" class="ml-4 flex items-center space-x-2">
                                        <span x-text="formattedTotalWeight" class="text-[10px] font-black text-orange-600 bg-orange-50 px-3 py-1 rounded-full border border-orange-100 shadow-sm"></span>
                                    </div>
                                </h4>
                                <button type="button" @click="addItem()" class="inline-flex items-center space-x-2 px-6 py-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition-all font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-100">
                                    <span class="material-icons text-sm">add</span>
                                    <span>Append Article</span>
                                </button>
                            </div>

                            <div class="space-y-6">
                                <template x-for="(item, index) in items" :key="index">
                                    <div class="p-6 border-2 border-gray-100 rounded-[2rem] relative bg-white hover:border-orange-200 transition-all shadow-sm">
                                        <button type="button" @click="removeItem(index)" x-show="items.length > 1"
                                            class="absolute -top-3 -right-3 bg-red-100 text-red-600 rounded-xl p-1.5 hover:bg-red-600 hover:text-white transition-all shadow-md">
                                            <span class="material-icons text-sm">close</span>
                                        </button>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                            <!-- Item Type -->
                                            <div class="relative">
                                                <select x-model="item.item_name" :name="'items['+index+'][item_name]'" required
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 transition-all appearance-none bg-white font-black text-gray-700 uppercase italic text-[10px]">
                                                    <option value="">Select Article</option>
                                                    <template x-for="name in getCommonItemNames()" :key="name">
                                                        <option :value="name" x-text="name"></option>
                                                    </template>
                                                    <option value="Others">Custom Entry</option>
                                                </select>
                                                <label class="absolute left-3 -top-2 bg-white px-2 text-[9px] font-black text-gray-400 uppercase">Item Category</label>
                                            </div>

                                            <div class="relative" x-show="item.item_name === 'Others'">
                                                <input type="text" :name="'items['+index+'][custom_item_name]'" x-model="item.custom_name"
                                                    class="w-full px-4 py-3 border-2 border-orange-200 rounded-xl font-bold italic" placeholder="Enter name">
                                                <label class="absolute left-3 -top-2 bg-white px-2 text-[9px] font-black text-orange-600 uppercase">Custom Name</label>
                                            </div>

                                            <div class="relative">
                                                <select x-model="item.purity" :name="'items['+index+'][purity]'" required
                                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl appearance-none bg-white font-black text-[10px] uppercase">
                                                    <option value="">Purity Level</option>
                                                    <template x-for="p in getPurityValues()" :key="p">
                                                        <option :value="p" x-text="p"></option>
                                                    </template>
                                                </select>
                                                <label class="absolute left-3 -top-2 bg-white px-2 text-[9px] font-black text-gray-400 uppercase">Standard</label>
                                            </div>

                                            <!-- Weight Grid -->
                                            <div class="md:col-span-3 grid grid-cols-3 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                                <div class="relative">
                                                    <select x-model.number="item.sovereign" @change="updateItemTotal(index)" class="w-full px-3 py-2 border-2 border-blue-200 rounded-xl appearance-none bg-white font-black text-blue-600 text-sm">
                                                        <template x-for="s in 11" :key="s-1">
                                                            <option :value="s-1" x-text="s-1 + ' Sav'"></option>
                                                        </template>
                                                    </select>
                                                    <label class="absolute left-2 -top-2 bg-white px-1 text-[9px] font-black text-blue-400 uppercase">Sav</label>
                                                </div>
                                                <div class="relative">
                                                    <select x-model.number="item.grams" @change="updateItemTotal(index)" class="w-full px-3 py-2 border-2 border-gray-200 rounded-xl appearance-none bg-white font-black text-sm">
                                                        <template x-for="g in 9" :key="g-1">
                                                            <option :value="g-1" x-text="g-1 + ' g'"></option>
                                                        </template>
                                                        <option value="2">2g</option>
                                                        <option value="4">4g</option>
                                                        <option value="8">8g</option>
                                                    </select>
                                                    <label class="absolute left-2 -top-2 bg-white px-1 text-[9px] font-black text-gray-400 uppercase">Gm</label>
                                                </div>
                                                <div class="relative">
                                                    <select x-model.number="item.milli" @change="updateItemTotal(index)" class="w-full px-3 py-2 border-2 border-gray-200 rounded-xl appearance-none bg-white font-black text-sm">
                                                        <option value="0">0 mg</option>
                                                        <template x-for="m in Array.from({length: 20}, (_, i) => (i + 1) * 5)" :key="m">
                                                            <option :value="m" x-text="m + ' mg'"></option>
                                                        </template>
                                                        <option value="100">100 mg</option>
                                                    </select>
                                                    <label class="absolute left-2 -top-2 bg-white px-1 text-[9px] font-black text-gray-400 uppercase">Mg</label>
                                                </div>
                                                <div class="hidden md:flex items-center justify-center">
                                                    <p class="text-[10px] font-black text-gray-300 uppercase italic">= <span x-text="item.weight.toFixed(3)" class="text-gray-900 text-sm"></span> gms</p>
                                                </div>
                                                <input type="hidden" :name="'items['+index+'][weight]'" :value="item.weight">
                                            </div>

                                            <div class="md:col-span-3">
                                                <input type="text" :name="'items['+index+'][description]'" x-model="item.description" required
                                                    class="w-full px-4 py-3 border-2 border-gray-100 rounded-xl bg-gray-50/50 italic text-[11px] font-medium" placeholder="Condition note: e.g. Minor scratches, no stone damage...">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Submit Logic -->
                        <div class="p-8 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                            <a href="{{ route('loans.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] hover:text-gray-600 transition-colors">Abort Transaction</a>
                            <button type="submit" 
                                class="w-full sm:w-auto px-12 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs flex items-center justify-center space-x-2">
                                <span class="material-icons text-sm">verified</span>
                                <span>Originate Loan Record</span>
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
                formattedTotalWeight: '0 gms',
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
                    if (totalSovereign > 0) parts.push(totalSovereign + ' Sav');
                    if (displayGrams > 0) parts.push(displayGrams + ' g');
                    if (displayMilli > 0) parts.push(displayMilli + ' mg');
                    this.formattedTotalWeight = parts.length > 0 ? parts.join(' ') : '0 gms';

                    if (this.loanType === 'Gold' || this.loanType === 'Silver') {
                        this.valuationAmount = this.totalWeight * (parseFloat(this.marketRate) || 0);
                        this.principalAmount = (this.valuationAmount * 0.8).toFixed(2);
                    } else {
                        // Keep manual entry for electronics/others if valuation is 0
                    }
                },
                getCommonItemNames() {
                    if (this.loanType === 'Gold') return ['Ring', 'Chain', 'Earring', 'Necklace', 'Bangle', 'Metti', 'Coin'];
                    if (this.loanType === 'Silver') return ['Anklet (Golusu)', 'Ring', 'Chain', 'Vessel', 'Pooja Items'];
                    if (this.loanType === 'Electronics') return ['Smartphone', 'Laptop', 'Tablet'];
                    return [];
                },
                getPurityValues() {
                    if (this.loanType === 'Gold') return ['22K (916)', '24K (999)', '18K (750)', '14K (585)'];
                    if (this.loanType === 'Silver') return ['92.5 (Sterling)', '99.9 (Pure)', '80.0 (Regular)'];
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
    </style>
</x-app-layout>
