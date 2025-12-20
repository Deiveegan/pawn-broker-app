<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <span class="material-icons text-blue-600 text-3xl">receipt_long</span>
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ __('Loans') }}
                </h2>
            </div>
            <a href="{{ route('loans.create') }}" 
                class="inline-flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                <span class="material-icons text-sm">add</span>
                <span>New Loan</span>
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
                            <p class="text-sm font-medium text-gray-600">Total Loans</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $loans->total() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-blue-600 text-2xl">receipt_long</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Loans</p>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $loans->where('status', 'Active')->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-green-600 text-2xl">check_circle</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Overdue</p>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $loans->where('status', 'Overdue')->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-red-600 text-2xl">warning</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Closed</p>
                            <p class="text-3xl font-bold text-gray-600 mt-2">{{ $loans->where('status', 'Closed')->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-gray-600 text-2xl">done_all</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loans Table Card -->
            <div class="md-card elevation-2">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <h3 class="text-lg font-semibold text-gray-800">Active Loans</h3>
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-initial">
                            <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                            <input type="text" placeholder="Search loans..." 
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <button class="p-2 bg-gray-50 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100">
                            <span class="material-icons">filter_list</span>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ticket #</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($loans as $loan)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <span class="material-icons text-blue-600 text-sm">confirmation_number</span>
                                            <span class="font-mono font-medium text-gray-900">{{ $loan->ticket_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center elevation-1">
                                                <span class="material-icons text-white text-sm">person</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $loan->customer->name }}</div>
                                                <div class="text-sm text-gray-500 flex items-center space-x-1">
                                                    <span class="material-icons text-xs">phone</span>
                                                    <span>{{ $loan->customer->mobile }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">₹{{ number_format($loan->principal_amount, 2) }}</div>
                                        <div class="text-sm text-gray-500">Principal</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-700">{{ $loan->loan_date->format('d M Y') }}</div>
                                        <div class="text-sm text-gray-500">Due: {{ $loan->due_date->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'Active' => 'bg-green-100 text-green-800',
                                                'Overdue' => 'bg-red-100 text-red-800',
                                                'Closed' => 'bg-gray-100 text-gray-800',
                                                'Auctioned' => 'bg-orange-100 text-orange-800',
                                            ];
                                            $statusIcons = [
                                                'Active' => 'check_circle',
                                                'Overdue' => 'warning',
                                                'Closed' => 'done_all',
                                                'Auctioned' => 'gavel',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$loan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            <span class="material-icons text-xs mr-1">{{ $statusIcons[$loan->status] ?? 'info' }}</span>
                                            {{ $loan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('loans.show', $loan) }}" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                                <span class="material-icons text-sm">visibility</span>
                                            </a>
                                            @if($loan->status === 'Active')
                                                <a href="{{ route('loans.edit', $loan) }}" 
                                                    class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Edit">
                                                    <span class="material-icons text-sm">edit</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" 
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-all" title="Add Payment">
                                                <span class="material-icons text-sm">payments</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-icons text-gray-300 text-6xl mb-4">receipt_long</span>
                                            <p class="text-gray-500 text-lg font-medium">No loans found</p>
                                            <p class="text-gray-400 text-sm mt-1">Create your first loan to get started</p>
                                            <a href="{{ route('loans.create') }}" 
                                                class="mt-4 inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all">
                                                <span class="material-icons text-sm">add</span>
                                                <span>New Loan</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($loans->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $loans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
