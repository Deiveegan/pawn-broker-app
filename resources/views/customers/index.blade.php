<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">groups</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Customers') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Manage your customers list</p>
                </div>
            </div>
            <a href="{{ route('customers.create') }}" class="btn-premium btn-premium-primary">
                <span class="material-symbols-rounded text-lg mr-2">person_add</span>
                <span>Add Customer</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Summary</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Total Customers</p>
                    <p class="text-5xl font-black text-slate-900 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($customers->total()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Active Loans</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Loans Currently Given</p>
                    <p class="text-5xl font-black text-emerald-600 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($customers->sum(fn($c) => $c->loans->where('status', 'Active')->count())) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">This Month</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">New Joining (Month)</p>
                    <p class="text-5xl font-black text-indigo-600 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($customers->where('created_at', '>=', now()->startOfMonth())->count()) }}</p>
                </div>

                <div class="bg-indigo-700 premium-shadow rounded-[2rem] p-8 border border-slate-800 relative overflow-hidden group text-white">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 font-heading">Today</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Joining Today</p>
                    <p class="text-5xl font-black text-white mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($customers->where('created_at', '>=', now()->startOfDay())->count()) }}</p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-slate-50/30">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic leading-none font-heading">Customer List</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-blue-600 transition-colors">search</span>
                                <input type="text" placeholder="Search Names..." 
                                    class="pl-12 pr-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all premium-shadow w-72 font-heading">
                            </div>
                        </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/50">
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Customer Name</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Phone Number</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">City</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center font-heading">Loan Status</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right font-heading">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-indigo-700/50 transition-all duration-300 group">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-5">
                                            <div class="w-14 h-14 bg-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/10 group-hover:scale-105 transition-all">
                                                <span class="material-symbols-rounded text-white text-xl">person</span>
                                            </div>
                                            <div>
                                                <div class="text-base font-extrabold text-slate-900 leading-tight font-heading">{{ $customer->name }}</div>
                                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1 font-heading">ID: {{ str_pad($customer->id, 6, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center space-x-2 text-slate-900 font-black text-sm font-heading italic">
                                                <span class="material-symbols-rounded text-slate-400 text-sm">phone_iphone</span>
                                                <span>{{ $customer->mobile }}</span>
                                            </div>
                                            @if($customer->email)
                                                <div class="flex items-center space-x-2 text-slate-400 text-[10px] font-bold tracking-tight uppercase">
                                                    <span class="material-symbols-rounded text-xs">alternate_email</span>
                                                    <span>{{ $customer->email }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-2 text-slate-500 font-bold text-[10px] uppercase tracking-widest italic">
                                            <span class="material-symbols-rounded text-sm">near_me</span>
                                            <span>{{ $customer->city ?: 'UNMAPPED' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php $activeLoans = $customer->loans->where('status', 'Active')->count(); @endphp
                                        @if($activeLoans > 0)
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100 font-heading group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                                {{ $activeLoans }} ACTIVE LOAN
                                            </span>
                                        @else
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-100 text-slate-500 border border-slate-200 opacity-60 font-heading">
                                                NO ACTIVE LOANS
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('customers.show', $customer) }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-white transition-all rounded-xl premium-shadow" title="View Profile">
                                                <span class="material-symbols-rounded text-xl">visibility</span>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-amber-600 hover:bg-white transition-all rounded-xl premium-shadow" title="Edit Customer">
                                                <span class="material-symbols-rounded text-xl">edit_note</span>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-300 hover:text-rose-600 hover:bg-white transition-all rounded-xl premium-shadow" onclick="return confirm('Execute deletion protocol?')" title="Delete Identity">
                                                    <span class="material-symbols-rounded text-xl">delete_sweep</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-10 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center">
                                                <span class="material-symbols-rounded text-slate-200 text-5xl">group_off</span>
                                            </div>
                                            <div>
                                                <p class="text-slate-900 text-lg font-black tracking-tight uppercase font-heading">No Customers Found</p>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">You haven't added any customers yet</p>
                                            </div>
                                            <a href="{{ route('customers.create') }}" class="btn-premium btn-premium-primary">
                                                <span class="material-symbols-rounded text-sm mr-2">person_add</span>
                                                <span>Add Your First Customer</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($customers->hasPages())
                    <div class="px-10 py-8 bg-slate-50 border-t border-slate-100">
                        {{ $customers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
