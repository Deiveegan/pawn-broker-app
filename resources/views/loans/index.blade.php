<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">receipt_long</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Loan Portfolio') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Manage all your loans here</p>
                </div>
            </div>
            <a href="{{ route('loans.create') }}" class="btn-premium btn-premium-primary">
                <span class="material-symbols-rounded text-lg mr-2">add_circle</span>
                <span>New Loan</span>
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
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">All Loans</p>
                    <p class="text-5xl font-black text-slate-900 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($loans->total()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-emerald-50 rounded-full blur-2xl group-hover:bg-emerald-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Active</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Current Loans</p>
                    <p class="text-5xl font-black text-emerald-600 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($loans->where('status', 'Active')->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-rose-50 rounded-full blur-2xl group-hover:bg-rose-100 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 font-heading">Attention</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Pending Due</p>
                    <p class="text-5xl font-black text-rose-600 mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($loans->where('status', 'Overdue')->count()) }}</p>
                </div>

                <div class="bg-indigo-700 premium-shadow rounded-[2rem] p-8 border border-slate-800 relative overflow-hidden group text-white">
                    <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors"></div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 font-heading">History</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Closed Loans</p>
                    <p class="text-5xl font-black text-white mt-4 leading-none font-heading italic tracking-tighter">{{ number_format($loans->where('status', 'Closed')->count()) }}</p>
                </div>
            </div>

            <!-- Ledger View -->
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-slate-50/30">
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic leading-none font-heading">All Loans</h3>
                        <div class="flex items-center space-x-4">
                            <div class="relative group">
                                <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-blue-600 transition-colors">filter_center_focus</span>
                                <input type="text" placeholder="Search Ticket Number..." 
                                    class="pl-12 pr-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all premium-shadow w-72 font-heading">
                            </div>
                        </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-50 bg-slate-50/50">
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Ticket No</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Customer Name</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Capital Amount</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] font-heading">Important Dates</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center font-heading">Status</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right font-heading">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($loans as $loan)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-3">
                                            <span class="w-2 h-2 rounded-full {{ $loan->status === 'Active' ? 'bg-emerald-500 animate-pulse outline outline-4 outline-emerald-500/20' : ($loan->status === 'Overdue' ? 'bg-rose-500 animate-pulse outline outline-4 outline-rose-500/20' : 'bg-slate-300') }}"></span>
                                            <span class="font-black text-blue-600 tracking-[0.1em] text-base font-heading italic">#{{ $loan->ticket_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-indigo-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-600/10 group-hover:scale-110 transition-all">
                                                <span class="material-symbols-rounded text-white text-lg">person</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-extrabold text-slate-900 leading-tight font-heading">{{ $loan->customer->name }}</div>
                                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">{{ $loan->customer->mobile }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-0.5">
                                            <div class="text-base font-black text-slate-900 flex items-center font-heading italic">
                                                <span class="text-xs mr-0.5">₹</span>{{ number_format($loan->principal_amount, 2) }}
                                            </div>
                                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Principal Amount</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-1">
                                            <div class="text-[11px] font-black text-slate-900 whitespace-nowrap font-heading uppercase tracking-tighter">{{ $loan->loan_date->format('M d, Y') }}</div>
                                            <div class="text-[10px] font-black text-rose-500 uppercase tracking-tighter italic font-heading">Due: {{ $loan->due_date->format('M d, Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @php
                                            $statusThemes = [
                                                'Active' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-100', 'icon' => 'verified'],
                                                'Overdue' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-100', 'icon' => 'error_med'],
                                                'Closed' => ['bg' => 'bg-slate-50', 'text' => 'text-slate-500', 'border' => 'border-slate-100', 'icon' => 'inventory_2'],
                                                'Auctioned' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-100', 'icon' => 'gavel'],
                                            ];
                                            $theme = $statusThemes[$loan->status] ?? $statusThemes['Closed'];
                                        @endphp
                                        <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $theme['bg'] }} {{ $theme['text'] }} border {{ $theme['border'] }} items-center space-x-1.5 font-heading group-hover:bg-indigo-700 group-hover:text-white group-hover:border-slate-800 transition-all">
                                            <span class="material-symbols-rounded text-xs">{{ $theme['icon'] }}</span>
                                            <span>{{ $loan->status }}</span>
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('loans.show', $loan) }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-white rounded-xl premium-shadow" title="View Details">
                                                <span class="material-symbols-rounded text-xl">query_stats</span>
                                            </a>
                                            @if($loan->status === 'Active')
                                                <a href="{{ route('loans.edit', $loan) }}" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 hover:text-amber-600 hover:bg-white transition-all rounded-xl premium-shadow" title="Edit Loan">
                                                    <span class="material-symbols-rounded text-xl">edit_square</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" class="w-10 h-10 flex items-center justify-center bg-indigo-700 text-white hover:bg-emerald-600 transition-all rounded-xl shadow-lg shadow-indigo-600/10 hover:shadow-emerald-600/20" title="Receive Payment">
                                                <span class="material-symbols-rounded text-xl">payments</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-10 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-4">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center">
                                                <span class="material-symbols-rounded text-slate-200 text-5xl">inventory</span>
                                            </div>
                                            <div>
                                                <p class="text-slate-900 text-lg font-black tracking-tight uppercase font-heading">No Loans Found</p>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">You haven't added any loans yet</p>
                                            </div>
                                            <a href="{{ route('loans.create') }}" class="btn-premium btn-premium-primary">
                                                <span class="material-symbols-rounded text-sm mr-2">add_circle</span>
                                                <span>Add Your First Loan</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($loans->hasPages())
                    <div class="px-10 py-8 bg-slate-50 border-t border-slate-100">
                        {{ $loans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
