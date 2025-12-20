<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('payments.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-green-600 text-3xl">add_card</span>
            <h2 class="font-semibold text-2xl text-gray-800">
                {{ __('Record Payment') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="md-card elevation-2">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Transaction Details</h3>
                    <p class="text-green-100 text-sm mt-1">Select a loan and enter payment amount</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('payments.store') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Loan Selection -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-green-100 text-green-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Select Active Loan
                            </h4>
                            <div class="relative">
                                <select name="loan_id" id="loan_id" required
                                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors appearance-none bg-white">
                                    <option value="">Choose Loan Ticket</option>
                                    @foreach($loans as $loan)
                                        <option value="{{ $loan->id }}" {{ (isset($loan_id) && $loan_id == $loan->id) || old('loan_id') == $loan->id ? 'selected' : '' }}>
                                            #{{ $loan->ticket_number }} - {{ $loan->customer->name }} (₹{{ number_format($loan->outstanding_principal, 0) }} O/S)
                                        </option>
                                    @endforeach
                                </select>
                                <label for="loan_id" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-green-600">
                                    Loan Ticket <span class="text-red-500">*</span>
                                </label>
                                <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                @error('loan_id')
                                    <p class="mt-1.5 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Info -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-green-100 text-green-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Payment Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative">
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required step="0.01" min="0.01"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Amount">
                                    <label for="amount" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-green-600">
                                        Payment Amount (₹) <span class="text-red-500">*</span>
                                    </label>
                                    @error('amount')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <select name="payment_type" id="payment_type" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="interest" {{ old('payment_type') == 'interest' ? 'selected' : '' }}>Interest Payment</option>
                                        <option value="principal" {{ old('payment_type') == 'principal' ? 'selected' : '' }}>Principal Payment</option>
                                        <option value="full_settlement" {{ old('payment_type') == 'full_settlement' ? 'selected' : '' }}>Full Settlement</option>
                                    </select>
                                    <label for="payment_type" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-green-600">
                                        Payment Type <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <div class="relative">
                                    <select name="payment_method" id="payment_method" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online Transfer / UPI</option>
                                        <option value="Cheque" {{ old('payment_method') == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    </select>
                                    <label for="payment_method" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-green-600">
                                        Payment Method <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <div class="relative">
                                    <input type="date" name="payment_date" id="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors">
                                    <label for="payment_date" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-green-600">
                                        Payment Date <span class="text-red-500">*</span>
                                    </label>
                                </div>

                                <div class="relative">
                                    <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="TXN ID">
                                    <label for="transaction_id" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-green-600">
                                        Reference / TXN ID (Optional)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                            <a href="{{ route('payments.index') }}" 
                                class="px-6 py-3 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-10 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg elevation-2 hover:elevation-3 transition-all ripple">
                                <div class="flex items-center">
                                    <span class="material-icons mr-2">receipt</span>
                                    Post Payment
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
