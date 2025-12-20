<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-3">
                <span class="material-icons text-blue-600 text-3xl">people</span>
                <h2 class="font-semibold text-2xl text-gray-800">
                    {{ __('Customers') }}
                </h2>
            </div>
            <a href="{{ route('customers.create') }}" 
                class="inline-flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                <span class="material-icons text-sm">add</span>
                <span>Add Customer</span>
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
                            <p class="text-sm font-medium text-gray-600">Total Customers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $customers->total() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-blue-600 text-2xl">people</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Active Loans</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $customers->sum(fn($c) => $c->loans->where('status', 'Active')->count()) }}</p>
                        </div>
                        <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-green-600 text-2xl">receipt_long</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $customers->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-purple-600 text-2xl">trending_up</span>
                        </div>
                    </div>
                </div>

                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Today</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $customers->where('created_at', '>=', now()->startOfDay())->count() }}</p>
                        </div>
                        <div class="w-14 h-14 bg-orange-100 rounded-full flex items-center justify-center">
                            <span class="material-icons text-orange-600 text-2xl">today</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customers Table Card -->
            <div class="md-card elevation-2">
                <!-- Card Header -->
                <div class="px-6 py-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                    <h3 class="text-lg font-semibold text-gray-800">Customer Directory</h3>
                    <div class="flex items-center space-x-3 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-initial">
                            <span class="material-icons absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                            <input type="text" placeholder="Search customers..." 
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
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Loans</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center elevation-1">
                                                <span class="material-icons text-white text-sm">person</span>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                                <div class="text-sm text-gray-500 font-mono">ID: {{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2 text-gray-700">
                                            <span class="material-icons text-sm text-gray-400">phone</span>
                                            <span>{{ $customer->mobile }}</span>
                                        </div>
                                        @if($customer->email)
                                            <div class="flex items-center space-x-2 text-gray-500 text-sm mt-1">
                                                <span class="material-icons text-xs">email</span>
                                                <span>{{ $customer->email }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2 text-gray-700">
                                            <span class="material-icons text-sm text-gray-400">location_on</span>
                                            <span>{{ $customer->city }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $activeLoans = $customer->loans->where('status', 'Active')->count();
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $activeLoans > 0 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            <span class="material-icons text-xs mr-1">receipt</span>
                                            {{ $activeLoans }} Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('customers.show', $customer) }}" 
                                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="View">
                                                <span class="material-icons text-sm">visibility</span>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer) }}" 
                                                class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all" title="Edit">
                                                <span class="material-icons text-sm">edit</span>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-all" 
                                                    onclick="return confirm('Are you sure you want to delete this customer?')"
                                                    title="Delete">
                                                    <span class="material-icons text-sm">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="material-icons text-gray-300 text-6xl mb-4">people_outline</span>
                                            <p class="text-gray-500 text-lg font-medium">No customers found</p>
                                            <p class="text-gray-400 text-sm mt-1">Get started by adding your first customer</p>
                                            <a href="{{ route('customers.create') }}" 
                                                class="mt-4 inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all">
                                                <span class="material-icons text-sm">add</span>
                                                <span>Add Customer</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
