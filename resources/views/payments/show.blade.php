<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('payments.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                    <span class="material-icons text-gray-600">arrow_back</span>
                </a>
                <span class="material-icons text-green-600 text-3xl">receipt_long</span>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800">
                        Receipt #{{ $payment->receipt_number }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Payment Confirmation</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('payments.receipt', $payment) }}" 
                    class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                    <span class="material-icons text-sm">download</span>
                    <span>Download PDF</span>
                </a>
                <button onclick="window.print()" 
                    class="inline-flex items-center space-x-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-lg transition-all">
                    <span class="material-icons text-sm">print</span>
                    <span>Print</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="md-card elevation-3 overflow-hidden">
                <!-- Success Header -->
                <div class="bg-green-600 px-8 py-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4">
                        <span class="material-icons text-white text-5xl">check_circle</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Payment Received Successfully</h3>
                    <p class="text-green-100 mt-2 opacity-90">Transaction ID: {{ $payment->transaction_id ?? 'N/A' }}</p>
                </div>

                <div class="p-8 space-y-8">
                    <!-- Amount Section -->
                    <div class="text-center pb-8 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-500 uppercase tracking-widest">Amount Paid</p>
                        <p class="text-5xl font-extrabold text-gray-900 mt-2">₹{{ number_format($payment->amount, 2) }}</p>
                        <div class="mt-4 inline-flex items-center px-4 py-1.5 rounded-full bg-green-50 text-green-700 text-sm font-bold border border-green-100 uppercase tracking-wide">
                            {{ str_replace('_', ' ', $payment->payment_type) }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Left: Payment Details -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Transaction Info</h4>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Date & Time</span>
                                    <span class="font-semibold text-gray-900">{{ $payment->payment_date->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Method</span>
                                    <span class="font-semibold text-gray-900">{{ $payment->payment_method }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Status</span>
                                    <span class="text-green-600 font-bold flex items-center">
                                        <span class="material-icons text-xs mr-1 text-[16px]">verified</span>
                                        Captured
                                    </span>
                                </div>
                            </div>

                            @if($payment->notes)
                            <div class="mt-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                <h5 class="text-xs font-bold text-gray-400 uppercase mb-2">Notes</h5>
                                <p class="text-sm text-gray-700 leading-relaxed italic">"{{ $payment->notes }}"</p>
                            </div>
                            @endif
                        </div>

                        <!-- Right: Loan & Customer -->
                        <div class="space-y-6">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Against Loan</h4>
                            <a href="{{ route('loans.show', $payment->loan) }}" class="block group">
                                <div class="p-4 bg-blue-50 rounded-xl border border-blue-100 group-hover:bg-blue-100 transition-all">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs font-bold text-blue-600 bg-white px-2 py-0.5 rounded border border-blue-200">#{{ $payment->loan->ticket_number }}</span>
                                        <span class="material-icons text-blue-300 group-hover:translate-x-1 transition-transform">chevron_right</span>
                                    </div>
                                    <p class="text-lg font-bold text-gray-900">{{ $payment->loan->customer->name }}</p>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <span class="material-icons text-sm mr-1">phone</span>
                                        {{ $payment->loan->customer->mobile }}
                                    </div>
                                    <div class="mt-4 pt-3 border-t border-blue-200/50">
                                        <div class="flex justify-between text-xs">
                                            <span class="text-blue-600">O/S Before Payment</span>
                                            <span class="font-bold text-gray-900">₹{{ number_format($payment->loan->outstanding_principal + $payment->amount, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="bg-gray-50 px-8 py-5 border-t border-gray-100 flex justify-center">
                    <p class="text-xs text-gray-400">This is a system generated digital receipt.</p>
                </div>
            </div>

            <!-- Next Possible Actions -->
            <div class="mt-8 grid grid-cols-2 gap-4">
                <a href="{{ route('payments.create') }}" class="md-card elevation-1 p-4 flex items-center justify-center space-x-3 hover:bg-green-50 transition-all">
                    <span class="material-icons text-green-600">add_card</span>
                    <span class="font-bold text-gray-700">New Payment</span>
                </a>
                <a href="{{ route('dashboard') }}" class="md-card elevation-1 p-4 flex items-center justify-center space-x-3 hover:bg-blue-50 transition-all">
                    <span class="material-icons text-blue-600">dashboard</span>
                    <span class="font-bold text-gray-700">Back to Home</span>
                </a>
            </div>
        </div>
    </div>

    <style>
        @media print {
            nav, .x-slot-header, .mt-8 { display: none !important; }
            .py-10 { padding-top: 0 !important; }
            .md-card { elevation: 0 !important; border: 1px solid #eee; }
        }
    </style>
</x-app-layout>
