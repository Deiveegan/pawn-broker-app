<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <span class="material-icons text-blue-600 text-3xl">dashboard</span>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Administrative Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Card -->
            <div class="md-card elevation-2 overflow-hidden bg-gradient-to-r from-blue-600 to-blue-800 px-8 py-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="text-center md:text-left">
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-blue-100 text-base sm:text-lg opacity-90">Manage your pawn business with ease.</p>
                        <div class="mt-6 flex flex-col sm:flex-row justify-center md:justify-start space-y-3 sm:space-y-0 sm:space-x-4">
                            <a href="{{ route('loans.create') }}" class="px-6 py-2 bg-white text-blue-700 font-bold rounded-full elevation-1 hover:elevation-3 transition-all text-center">
                                + New Loan
                            </a>
                            <a href="{{ route('payments.create') }}" class="px-6 py-2 bg-blue-500 text-white font-bold rounded-full elevation-1 hover:bg-blue-400 transition-all text-center">
                                Record Payment
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <span class="material-icons text-white/20 text-[100px]">account_balance</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Customer Stat -->
                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Customers</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Customer::count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-blue-600">people</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-green-600">
                        <span class="material-icons text-xs mr-1">trending_up</span>
                        <span>Active status</span>
                    </div>
                </div>

                <!-- Loan Stat -->
                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Loans</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ \App\Models\Loan::where('status', 'Active')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-indigo-600">receipt_long</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-blue-600">
                        <span class="material-icons text-xs mr-1">info</span>
                        <span>In progress</span>
                    </div>
                </div>

                <!-- Collection Stat -->
                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Collection</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">₹{{ number_format(\App\Models\Payment::sum('amount') / 1000, 1) }}K</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-green-600">payments</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-green-600">
                        <span class="material-icons text-xs mr-1">check_circle</span>
                        <span>Cumulative</span>
                    </div>
                </div>

                <!-- Overdue Stat -->
                <div class="md-card elevation-1 p-6 hover:elevation-2 transition-all">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Overdue</p>
                            <p class="text-3xl font-bold text-red-600 mt-1">{{ \App\Models\Loan::where('status', 'Overdue')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <span class="material-icons text-red-600">warning</span>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-red-600">
                        <span class="material-icons text-xs mr-1">priority_high</span>
                        <span>Needs attention</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Quick Links -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Customers -->
                <div class="lg:col-span-2 md-card elevation-2 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-800">Recently Added Customers</h3>
                        <a href="{{ route('customers.index') }}" class="text-sm text-blue-600 font-bold hover:underline">View All</a>
                    </div>
                    <div class="p-0">
                        <table class="min-w-full">
                            <tbody class="divide-y divide-gray-100">
                                @forelse(\App\Models\Customer::latest()->take(5)->get() as $customer)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-3">
                                            <span class="material-icons text-sm">person</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $customer->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $customer->mobile }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $customer->city }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('customers.show', $customer) }}" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
                                            <span class="material-icons text-sm">visibility</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="px-6 py-10 text-center text-gray-400 italic">No customers yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions / Shortcuts -->
                <div class="space-y-6">
                    <div class="md-card elevation-1 p-6">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Quick Shortcuts</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('loans.index') }}" class="p-4 bg-gray-50 rounded-xl hover:bg-blue-50 transition-all text-center group">
                                <span class="material-icons text-blue-600 group-hover:scale-110 transition-transform">receipt_long</span>
                                <p class="text-xs font-bold text-gray-700 mt-2">All Loans</p>
                            </a>
                            <a href="{{ route('payments.index') }}" class="p-4 bg-gray-50 rounded-xl hover:bg-green-50 transition-all text-center group">
                                <span class="material-icons text-green-600 group-hover:scale-110 transition-transform">payments</span>
                                <p class="text-xs font-bold text-gray-700 mt-2">Registers</p>
                            </a>
                            <a href="#" class="p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-all text-center group">
                                <span class="material-icons text-purple-600 group-hover:scale-110 transition-transform">assessment</span>
                                <p class="text-xs font-bold text-gray-700 mt-2">Reports</p>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="p-4 bg-gray-50 rounded-xl hover:bg-orange-50 transition-all text-center group">
                                <span class="material-icons text-orange-600 group-hover:scale-110 transition-transform">settings</span>
                                <p class="text-xs font-bold text-gray-700 mt-2">Profile</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
