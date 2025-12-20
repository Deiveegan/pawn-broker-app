<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('loans.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">add_circle</span>
            <h2 class="font-semibold text-2xl text-gray-800">
                {{ __('Create New Loan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Material Design Card -->
            <div class="md-card elevation-2">
                <!-- Card Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Loan Information</h3>
                    <p class="text-blue-100 text-sm mt-1">Fill in the details below to create a new loan</p>
                </div>

                <!-- Card Body -->
                <div class="p-8">
                    <form action="{{ route('loans.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Customer Selection -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Customer Selection
                            </h4>
                            <div class="relative">
                                <select name="customer_id" id="customer_id" required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->mobile }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="customer_id" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                    Customer <span class="text-red-500">*</span>
                                </label>
                                <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                @error('customer_id')
                                    <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                        <span class="material-icons text-xs mr-1">error</span>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Loan Details -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Loan Details
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Principal Amount -->
                                <div class="relative">
                                    <input type="number" name="principal_amount" id="principal_amount" value="{{ old('principal_amount') }}" required step="0.01" min="0"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Principal Amount">
                                    <label for="principal_amount" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Principal Amount (₹) <span class="text-red-500">*</span>
                                    </label>
                                    @error('principal_amount')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Interest Rate -->
                                <div class="relative">
                                    <input type="number" name="interest_rate" id="interest_rate" value="{{ old('interest_rate') }}" required step="0.01" min="0" max="100"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Interest Rate">
                                    <label for="interest_rate" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Interest Rate (% per month) <span class="text-red-500">*</span>
                                    </label>
                                    @error('interest_rate')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Interest Type -->
                                <div class="relative">
                                    <select name="interest_type" id="interest_type" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="">Select Interest Type</option>
                                        <option value="Flat" {{ old('interest_type') == 'Flat' ? 'selected' : '' }}>Flat Interest</option>
                                        <option value="Reducing" {{ old('interest_type') == 'Reducing' ? 'selected' : '' }}>Reducing Balance</option>
                                    </select>
                                    <label for="interest_type" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Interest Type <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                    @error('interest_type')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Loan Period -->
                                <div class="relative">
                                    <input type="number" name="loan_period_months" id="loan_period_months" value="{{ old('loan_period_months') }}" required min="1"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Loan Period">
                                    <label for="loan_period_months" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Loan Period (Months) <span class="text-red-500">*</span>
                                    </label>
                                    @error('loan_period_months')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Loan Date -->
                                <div class="relative">
                                    <input type="date" name="loan_date" id="loan_date" value="{{ old('loan_date', date('Y-m-d')) }}" required
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors"
                                        placeholder="Loan Date">
                                    <label for="loan_date" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        Loan Date <span class="text-red-500">*</span>
                                    </label>
                                    @error('loan_date')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Grace Period -->
                                <div class="relative">
                                    <input type="number" name="grace_period_days" id="grace_period_days" value="{{ old('grace_period_days', 0) }}" min="0" max="90"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Grace Period">
                                    <label for="grace_period_days" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Grace Period (Days)
                                    </label>
                                    @error('grace_period_days')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Penalty Rate -->
                                <div class="relative">
                                    <input type="number" name="penalty_rate" id="penalty_rate" value="{{ old('penalty_rate', 0) }}" step="0.01" min="0" max="100"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Penalty Rate">
                                    <label for="penalty_rate" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Penalty Rate (% per month)
                                    </label>
                                    @error('penalty_rate')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div class="relative md:col-span-2">
                                    <textarea name="remarks" id="remarks" rows="3"
                                        class="peer w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent resize-none"
                                        placeholder="Remarks">{{ old('remarks') }}</textarea>
                                    <label for="remarks" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Remarks (Optional)
                                    </label>
                                    @error('remarks')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center">
                                            <span class="material-icons text-xs mr-1">error</span>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('loans.index') }}" 
                                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors duration-200 flex items-center">
                                <span class="material-icons text-sm mr-2">close</span>
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg elevation-2 hover:elevation-3 transition-all duration-200 flex items-center ripple">
                                <span class="material-icons text-sm mr-2">check</span>
                                Create Loan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
