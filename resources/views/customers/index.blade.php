<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">groups</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Customer Directory') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Manage your shop's client base</p>
                </div>
            </div>
            <a href="{{ route('customers.create') }}" class="btn-primary px-8 py-3 rounded-2xl elevation-2 hover:elevation-3 flex items-center space-x-2 text-sm font-bold tracking-tight">
                <span class="material-symbols-rounded text-lg">person_add</span>
                <span>Register Client</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-blue-600">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Portfolio</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Global Clients</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 leading-none">{{ number_format($customers->total()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-emerald-600">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Loan Volume</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Active Engagements</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 leading-none">{{ number_format($customers->sum(fn($c) => $c->loans->where('status', 'Active')->count())) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-blue-400">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Growth Metric</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Monthly Onboarding</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 leading-none">{{ number_format($customers->where('created_at', '>=', now()->startOfMonth())->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-amber-500">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Velocity</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Today's Entry</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 leading-none">{{ number_format($customers->where('created_at', '>=', now()->startOfDay())->count()) }}</p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-slate-50/50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic leading-none">Client Ledger</h3>
                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-blue-600 transition-colors">search</span>
                            <input type="text" placeholder="Filter identities..." 
                                class="pl-12 pr-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all premium-shadow w-72">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Individual Identity</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Contact Node</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Geographic</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center">Exposure</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right">Operational</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-5">
                                            <div class="w-14 h-14 bg-slate-900 rounded-2xl flex items-center justify-center shadow-lg shadow-slate-900/10">
                                                <span class="material-symbols-rounded text-white text-xl">person</span>
                                            </div>
                                            <div>
                                                <div class="text-base font-extrabold text-slate-900 leading-tight">{{ $customer->name }}</div>
                                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">UXID: {{ str_pad($customer->id, 6, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-1">
                                            <div class="flex items-center space-x-2 text-slate-900 font-bold text-sm">
                                                <span class="material-symbols-rounded text-slate-400 text-sm">phone_iphone</span>
                                                <span>{{ $customer->mobile }}</span>
                                            </div>
                                            @if($customer->email)
                                                <div class="flex items-center space-x-2 text-slate-400 text-[10px] font-bold tracking-tight">
                                                    <span class="material-symbols-rounded text-xs">alternate_email</span>
                                                    <span>{{ $customer->email }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-2 text-slate-500 font-semibold text-xs">
                                            <span class="material-symbols-rounded text-sm">near_me</span>
                                            <span class="uppercase tracking-widest">{{ $customer->city ?: 'UNMAPPED' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php $activeLoans = $customer->loans->where('status', 'Active')->count(); @endphp
                                        @if($activeLoans > 0)
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                {{ $activeLoans }} ACTIVE DEBTS
                                            </span>
                                        @else
                                            <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest bg-slate-100 text-slate-500 border border-slate-200 opacity-60">
                                                CLEAR ACCOUNT
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('customers.show', $customer) }}" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-50 text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all rounded-xl" title="Deep View">
                                                <span class="material-symbols-rounded text-xl">visibility</span>
                                            </a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-50 text-slate-400 hover:text-amber-600 hover:border-amber-100 hover:bg-amber-50 transition-all rounded-xl" title="Update Identity">
                                                <span class="material-symbols-rounded text-xl">edit_note</span>
                                            </a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-50 text-slate-300 hover:text-rose-600 hover:border-rose-100 hover:bg-rose-50 transition-all rounded-xl" onclick="return confirm('Execute deletion protocol?')" title="Delete Identity">
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
                                                <p class="text-slate-900 text-lg font-black tracking-tight uppercase">Null Client Index</p>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">No identities detected in the current environment</p>
                                            </div>
                                            <a href="{{ route('customers.create') }}" class="btn-primary px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center space-x-3">
                                                <span class="material-symbols-rounded text-sm">person_add</span>
                                                <span>Initialize First Entry</span>
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
