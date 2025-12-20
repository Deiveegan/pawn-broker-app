<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <span class="material-icons text-blue-600 text-3xl">payments</span>
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ __('Payments') }}
                </h2>
            </div>
            <a href="{{ route('payments.create') }}" 
                class="inline-flex items-center justify-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                <span class="material-icons text-sm">add</span>
                <span>Record Payment</span>
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Payments</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $payments->total() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-blue-600 text-2xl">payments</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Today's Collection</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">₹{{ number_format($payments->where('payment_date', '>=', now()->startOfDay())->sum('amount'), 2) }}</p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-green-600 text-2xl">today</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month</p>
                            <p class="text-3xl font-bold text-purple-600 mt-2">₹{{ number_format($payments->where('payment_date', '>=', now()->startOfMonth())->sum('amount'), 2) }}</p>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-purple-600 text-2xl">calendar_month</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Cash Payments</p>
                            <p class="text-3xl font-bold text-orange-600 mt-2">{{ $payments->where('payment_method', 'Cash')->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-orange-600 text-2xl">money</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Table Card -->
            <div class="md-card elevation-2">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <h3 class="text-lg font-semibold text-gray-800">All Payments</h3>
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-initial">
                            <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                            <input type="text" placeholder="Search payments..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Receipt #</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="material-icons text-green-600 text-sm">receipt</span>
                                            <span class="font-mono font-medium text-gray-900">{{ $payment->receipt_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-mono text-sm text-gray-700">{{ $payment->loan->ticket_number }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $payment->loan->customer->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->loan->customer->mobile }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-green-600">₹{{ number_format($payment->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-700">{{ $payment->payment_date->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $payment->payment_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <span class="material-icons text-xs mr-1">payment</span>
                                            {{ $payment->payment_method }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('payments.show', $payment) }}" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View Receipt">
                                                <span class="material-icons text-sm">visibility</span>
                                            </a>
                                            <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Print Receipt">
                                                <span class="material-icons text-sm">print</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-icons text-gray-300 text-6xl mb-4">payments</span>
                                            <p class="text-gray-500 text-lg font-medium">No payments found</p>
                                            <p class="text-gray-400 text-sm mt-1">Payments will appear here once recorded</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
