<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-emerald-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-emerald-600 text-3xl">payments</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight font-heading">
                        {{ __('Payments List') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Track all your collection here</p>
                </div>
            </div>
            <a href="{{ route('payments.create') }}" class="btn-primary px-8 py-3 rounded-2xl elevation-2 hover:elevation-3 flex items-center space-x-2 text-sm font-bold tracking-tight font-heading">
                <span class="material-symbols-rounded text-lg">add_circle</span>
                <span>New Payment</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Global Metric Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-50 rounded-full blur-2xl group-hover:bg-blue-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Summary</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Payments</p>
                    <p class="text-5xl font-black text-slate-900 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($payments->total()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Today</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Collections Today</p>
                    <div class="flex items-baseline space-x-1 mt-4">
                        <span class="text-sm font-black text-emerald-600 font-heading">₹</span>
                        <p class="text-4xl font-black text-emerald-600 leading-none font-heading italic tracking-tighter">{{ number_format($payments->where('payment_date', '>=', now()->startOfDay())->sum('amount') / 1000, 1) }}K</p>
                    </div>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-indigo-50 rounded-full blur-2xl group-hover:bg-indigo-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">This Month</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Collections This Month</p>
                    <div class="flex items-baseline space-x-1 mt-4">
                        <span class="text-sm font-black text-indigo-600 font-heading">₹</span>
                        <p class="text-4xl font-black text-indigo-600 leading-none font-heading italic tracking-tighter">{{ number_format($payments->where('payment_date', '>=', now()->startOfMonth())->sum('amount') / 1000, 1) }}K</p>
                    </div>
                </div>

                <div class="bg-indigo-700 premium-shadow rounded-[2rem] p-8 border border-slate-800 relative overflow-hidden group text-white">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 font-heading">Cash Mode</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Payments by Cash</p>
                    <p class="text-5xl font-black text-white mt-4 leading-none font-heading italic tracking-tighter">{{ $payments->where('payment_method', 'Cash')->count() }}</p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-slate-50/30">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic leading-none font-heading">Recent Payments</h3>
                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-blue-600 transition-colors">filter_list</span>
                            <input type="text" placeholder="Search Receipt No..." 
                                class="pl-12 pr-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all premium-shadow w-72 font-heading">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/50">
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Receipt No</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Loan ID</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Customer Name</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Amount</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Date</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right font-heading">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                                <span class="material-symbols-rounded text-sm">receipt</span>
                                            </div>
                                            <span class="font-black text-slate-900 tracking-tighter text-sm font-heading">#{{ $payment->receipt_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-black text-blue-600 uppercase tracking-widest font-heading italic">LOAN-{{ $payment->loan->ticket_number }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Active Loan</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center">
                                                <span class="material-symbols-rounded text-slate-400 text-xs text-center">person</span>
                                            </div>
                                            <div class="text-xs font-extrabold text-slate-900 font-heading">{{ $payment->loan->customer->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="text-base font-black text-emerald-600 font-heading italic">₹{{ number_format($payment->amount, 2) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-slate-900 font-heading uppercase">{{ $payment->payment_date->format('d M, Y') }}</span>
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">{{ $payment->payment_date->format('H:i') }} HRS</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-2">
                                            <span class="px-3 py-1 bg-blue-50 text-blue-700 text-[9px] font-black rounded-lg uppercase tracking-widest font-heading border border-blue-100">{{ $payment->payment_method }}</span>
                                            <a href="{{ route('payments.show', $payment) }}" class="w-8 h-8 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-white rounded-lg transition-all premium-shadow">
                                                <span class="material-symbols-rounded text-lg">visibility</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-10 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center">
                                                <span class="material-symbols-rounded text-slate-200 text-5xl">payments</span>
                                            </div>
                                            <div>
                                                <p class="text-slate-900 text-lg font-black tracking-tight uppercase font-heading">No Payments Found</p>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">You haven't recorded any payments yet</p>
                                            </div>
                                            <a href="{{ route('payments.create') }}" class="btn-primary px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center space-x-3 font-heading shadow-xl shadow-indigo-600/10">
                                                <span class="material-symbols-rounded text-sm">add_circle</span>
                                                <span>Add Your First Payment</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($payments->hasPages())
                    <div class="px-10 py-8 bg-slate-50 border-t border-slate-100">
                        {{ $payments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
