<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                    <span class="material-icons text-gray-600">arrow_back</span>
                </a>
                <span class="material-icons text-blue-600 text-3xl">receipt</span>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800">
                        Loan #{{ $loan->ticket_number }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">View loan details and history</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                @if($loan->status === 'Active')
                    <a href="{{ route('loans.ticket', $loan) }}" 
                        class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-all">
                        <span class="material-icons text-sm">print</span>
                        <span>Print Ticket</span>
                    </a>
                    <a href="{{ route('loans.pawn-ticket', $loan) }}" 
                        class="inline-flex items-center space-x-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded-lg transition-all">
                        <span class="material-icons text-sm">download</span>
                        <span>PDF</span>
                    </a>
                    <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" 
                        class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all">
                        <span class="material-icons text-sm">payments</span>
                        <span>Add Payment</span>
                    </a>
                    <a href="{{ route('loans.edit', $loan) }}" 
                        class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all">
                        <span class="material-icons text-sm">edit</span>
                        <span>Edit</span>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Loan Summary Card -->
            <div class="md-card elevation-2 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Loan Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">Principal Amount</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($loan->principal_amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Interest Rate</p>
                        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $loan->interest_rate }}%</p>
                        <p class="text-xs text-gray-500">{{ $loan->interest_type }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Outstanding</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">₹{{ number_format($loan->outstanding_principal, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-1
                            {{ $loan->status === 'Active' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $loan->status === 'Overdue' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $loan->status === 'Closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ $loan->status }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="md-card elevation-2 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Customer Information</h3>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="material-icons text-white text-2xl">person</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $loan->customer->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $loan->customer->mobile }}</p>
                        <p class="text-sm text-gray-500">{{ $loan->customer->city }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="md-card elevation-2">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Payment History</h3>
                </div>
                <div class="p-6">
                    @if($loan->payments->count() > 0)
                        <div class="space-y-4">
                            @foreach($loan->payments as $payment)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                            <span class="material-icons text-green-600">payments</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">₹{{ number_format($payment->amount, 2) }}</p>
                                            <p class="text-sm text-gray-500">{{ $payment->payment_date->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-600">{{ $payment->payment_method }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">No payments recorded yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
