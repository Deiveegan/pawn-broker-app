<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('customers.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                    <span class="material-icons text-gray-600">arrow_back</span>
                </a>
                <span class="material-icons text-blue-600 text-3xl">account_circle</span>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                        {{ $customer->name }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Customer Profile & History</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('loans.create', ['customer_id' => $customer->id]) }}" 
                    class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                    <span class="material-icons text-sm">add</span>
                    <span>New Loan</span>
                </a>
                <a href="{{ route('customers.edit', $customer) }}" 
                    class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all ripple">
                    <span class="material-icons text-sm">edit</span>
                    <span>Edit Profile</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10" x-data="{ activeTooltip: null }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Profile Summary Card -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="md-card elevation-2 overflow-hidden">
                        <div class="h-32 bg-gradient-to-r from-blue-600 to-blue-700"></div>
                        <div class="px-6 pb-6 text-center">
                            <div class="relative -mt-16 mb-4 inline-block">
                                @if($customer->photo)
                                    <img src="{{ Storage::url($customer->photo) }}" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-white">
                                @else
                                    <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-blue-50 flex items-center justify-center text-blue-300">
                                        <span class="material-icons text-6xl">person</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-1 right-1 w-6 h-6 bg-green-500 border-2 border-white rounded-full"></div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">{{ $customer->name }}</h3>
                            <p class="text-gray-500 text-sm font-mono mt-1">ID: {{ str_pad($customer->id, 5, '0', STR_PAD_LEFT) }}</p>
                            
                            <div class="mt-6 flex justify-center space-x-4">
                                <a href="tel:{{ $customer->mobile }}" class="p-2 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 transition-all" title="Call Customer">
                                    <span class="material-icons text-xl">phone</span>
                                </a>
                                <a href="mailto:{{ $customer->email }}" class="p-2 bg-blue-50 text-blue-600 rounded-full hover:bg-blue-100 transition-all" title="Email Customer">
                                    <span class="material-icons text-xl">email</span>
                                </a>
                                <a href="https://wa.me/{{ $customer->mobile }}" class="p-2 bg-green-50 text-green-600 rounded-full hover:bg-green-100 transition-all" title="WhatsApp">
                                    <span class="material-icons text-xl">chat</span>
                                </a>
                            </div>
                        </div>
                        <div class="border-t border-gray-100 px-6 py-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Contact Details</h4>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <span class="material-icons text-gray-400 mr-3 text-sm mt-1">phone_iphone</span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $customer->mobile }}</p>
                                        <p class="text-xs text-gray-500">Mobile</p>
                                    </div>
                                </div>
                                @if($customer->email)
                                <div class="flex items-start">
                                    <span class="material-icons text-gray-400 mr-3 text-sm mt-1">email</span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $customer->email }}</p>
                                        <p class="text-xs text-gray-500">Email Address</p>
                                    </div>
                                </div>
                                @endif
                                <div class="flex items-start">
                                    <span class="material-icons text-gray-400 mr-3 text-sm mt-1">place</span>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $customer->address }}</p>
                                        <p class="text-xs text-gray-500">{{ $customer->city }}, {{ $customer->state }} - {{ $customer->pincode }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Identity Card -->
                    <div class="md-card elevation-1 p-6">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Verification Info</h4>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <span class="material-icons text-blue-600 mr-3">badge</span>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $customer->id_proof_type }}</p>
                                    <p class="text-xs text-gray-500">ID Type</p>
                                </div>
                            </div>
                            <p class="text-sm font-mono font-medium text-gray-700 bg-white px-2 py-1 rounded border border-gray-200">{{ $customer->id_proof_number }}</p>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="md-card elevation-1 p-6 text-center">
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Loans</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $customer->loans->count() }}</p>
                        </div>
                        <div class="md-card elevation-1 p-6 text-center">
                            <p class="text-sm font-medium text-gray-500 mb-1">Active Loans</p>
                            <p class="text-2xl font-bold text-green-600">{{ $customer->loans->where('status', 'Active')->count() }}</p>
                        </div>
                        <div class="md-card elevation-1 p-6 text-center border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Invested</p>
                            <p class="text-2xl font-bold text-blue-600">₹{{ number_format($customer->loans->sum('principal_amount'), 2) }}</p>
                        </div>
                    </div>

                    <!-- Loans History -->
                    <div class="md-card elevation-2 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-800">Loan History</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Ticket #</th>
                                        <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest text-center">Items</th>
                                        <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-black text-gray-400 uppercase tracking-widest text-center">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-widest">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @forelse($customer->loans->sortByDesc('created_at') as $loan)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="text-[10px] text-gray-400 font-bold mb-1">{{ $loan->loan_date->format('d M Y') }}</p>
                                            <span class="text-sm font-black text-blue-600 tracking-tighter">#{{ $loan->ticket_number }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-black text-gray-900 uppercase italic">{{ $loan->loan_type }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <!-- Info Icon Tooltip -->
                                            <div class="relative inline-block" @mouseenter="activeTooltip = {{ $loan->id }}" @mouseleave="activeTooltip = null">
                                                <span class="material-icons text-blue-600 cursor-pointer text-xl hover:scale-110 transition-transform">info</span>
                                                
                                                <!-- Popover -->
                                                <div x-show="activeTooltip === {{ $loan->id }}" 
                                                    x-transition:enter="transition ease-out duration-200"
                                                    x-transition:enter-start="opacity-0 translate-y-2"
                                                    x-transition:enter-end="opacity-100 translate-y-0"
                                                    class="absolute z-50 w-64 bg-gray-900 text-white rounded-xl p-4 shadow-2xl -left-28 bottom-full mb-3 text-left border border-white/10"
                                                    x-cloak>
                                                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-2">Item Details</p>
                                                    <ul class="space-y-2 text-xs">
                                                        @foreach($loan->items as $item)
                                                            <li class="border-b border-white/5 pb-2 last:border-0 last:pb-0">
                                                                <p class="font-bold text-white uppercase">{{ $item->item_name }}</p>
                                                                <p class="text-gray-400 italic text-[10px]">{{ $item->formatted_weight }} | {{ $item->purity }}</p>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="absolute w-3 h-3 bg-gray-900 rotate-45 -bottom-1.5 left-1/2 -ml-1.5 border-r border-b border-white/10"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-black text-gray-900 leading-none">₹{{ number_format($loan->principal_amount, 2) }}</p>
                                            <p class="text-[9px] text-gray-400 font-bold mt-1 uppercase">{{ (float)$loan->interest_rate }}% Int</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex items-center px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-widest
                                                {{ $loan->status == 'Active' ? 'bg-green-100 text-green-700 shadow-sm shadow-green-100' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $loan->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('loans.show', $loan) }}" class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-all">
                                                <span class="material-icons text-sm">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <span class="material-icons text-gray-200 text-4xl mb-2">history</span>
                                                <p class="text-gray-500 font-medium">No loan history available</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .font-black { font-weight: 900; }
    </style>
</x-app-layout>
