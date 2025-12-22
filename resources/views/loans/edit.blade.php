<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('loans.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">edit_document</span>
            <h2 class="font-semibold text-2xl text-gray-800">
                {{ __('Edit Loan') }}: #{{ $loan->ticket_number }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="md-card elevation-2">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Loan Configuration</h3>
                    <p class="text-blue-100 text-sm mt-1">Update loan parameters and terms</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('loans.update', $loan) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Customer Info (Read Only in Edit for standard business logic) -->
                        <div class="p-4 bg-blue-50 rounded-xl flex items-center justify-between border border-blue-100">
                            <div class="flex items-center">
                                <span class="material-icons text-blue-600 mr-3">person</span>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $loan->customer->name }}</p>
                                    <p class="text-xs text-gray-500">Customer</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-mono font-bold text-blue-600">#{{ $loan->ticket_number }}</p>
                                <p class="text-xs text-gray-500">Ticket Number</p>
                            </div>
                        </div>

                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Principal & Interest
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Loan Type -->
                                <div class="relative md:col-span-2">
                                    <select name="loan_type" id="loan_type" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="Gold" {{ old('loan_type', $loan->loan_type) == 'Gold' ? 'selected' : '' }}>Gold</option>
                                        <option value="Silver" {{ old('loan_type', $loan->loan_type) == 'Silver' ? 'selected' : '' }}>Silver</option>
                                        <option value="Electronics" {{ old('loan_type', $loan->loan_type) == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                        <option value="Others" {{ old('loan_type', $loan->loan_type) == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <label for="loan_type" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Loan Type <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>
                                <div class="relative">
                                    <input type="number" name="principal_amount" id="principal_amount" value="{{ old('principal_amount', $loan->principal_amount) }}" required step="0.01" min="0"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent border-gray-200 bg-gray-50 cursor-not-allowed"
                                        placeholder="Principal" readonly>
                                    <label for="principal_amount" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-400">
                                        Principal Amount (₹) - Cannot be modified
                                    </label>
                                </div>

                                <div class="relative">
                                    <select name="interest_rate" id="interest_rate" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        @foreach([1, 1.5, 2, 2.5, 3, 4, 5] as $rate)
                                            <option value="{{ $rate }}" {{ old('interest_rate', (float)$loan->interest_rate) == $rate ? 'selected' : '' }}>
                                                {{ $rate }}% per month
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="interest_rate" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Interest Rate (% per month) <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                    @error('interest_rate')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <select name="interest_type" id="interest_type" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="Flat" {{ old('interest_type', $loan->interest_type) == 'Flat' ? 'selected' : '' }}>Flat Interest</option>
                                        <option value="Reducing" {{ old('interest_type', $loan->interest_type) == 'Reducing' ? 'selected' : '' }}>Reducing Balance</option>
                                    </select>
                                    <label for="interest_type" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Interest Type <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <div class="relative">
                                    <input type="number" name="loan_period_months" id="loan_period_months" value="{{ old('loan_period_months', $loan->loan_period_months) }}" required min="1"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Duration">
                                    <label for="loan_period_months" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Loan Period (Months) <span class="text-red-500">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Dates & Penalties -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Dates & Penalties
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative">
                                    <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', $loan->loan_date->format('Y-m-d')) }}" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors">
                                    <label for="loan_date" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Loan Date <span class="text-red-500">*</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <select name="status" id="status" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="Active" {{ old('status', $loan->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Overdue" {{ old('status', $loan->status) == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="Closed" {{ old('status', $loan->status) == 'Closed' ? 'selected' : '' }}>Closed</option>
                                        <option value="Auctioned" {{ old('status', $loan->status) == 'Auctioned' ? 'selected' : '' }}>Auctioned</option>
                                    </select>
                                    <label for="status" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Loan Status <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <div class="relative">
                                    <input type="number" name="penalty_rate" id="penalty_rate" value="{{ old('penalty_rate', $loan->penalty_rate) }}" step="0.01" min="0" max="100"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Penalty Rate">
                                    <label for="penalty_rate" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Penalty Rate (% per month)
                                    </label>
                                </div>
                                
                                </div>
                            </div>
                        </div>

                        <!-- Item Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">3</span>
                                Item Details
                            </h4>
                            @php $item = $loan->items->first(); @endphp
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Description -->
                                <div class="relative md:col-span-2">
                                    <textarea name="item_description" id="item_description" rows="2" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent resize-none"
                                        placeholder="Item Description">{{ old('item_description', $item->description ?? '') }}</textarea>
                                    <label for="item_description" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Item Description <span class="text-red-500">*</span>
                                    </label>
                                </div>

                                <!-- Weight -->
                                <div class="relative">
                                    <input type="number" name="item_weight" id="item_weight" value="{{ old('item_weight', $item->weight ?? '') }}" step="0.001" min="0"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Weight">
                                    <label for="item_weight" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Weight (gms)
                                    </label>
                                </div>

                                <!-- Purity -->
                                <div class="relative">
                                    <input type="text" name="item_purity" id="item_purity" value="{{ old('item_purity', $item->purity ?? '') }}"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Purity">
                                    <label for="item_purity" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Purity (e.g. 22K, 916)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                            <a href="{{ route('loans.index') }}" 
                                class="px-6 py-3 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-10 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg elevation-2 hover:elevation-3 transition-all ripple">
                                <div class="flex items-center">
                                    <span class="material-icons mr-2">update</span>
                                    Update Loan
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
