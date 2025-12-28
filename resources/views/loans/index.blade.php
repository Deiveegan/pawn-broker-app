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
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Active asset management ledger</p>
                </div>
            </div>
            <a href="{{ route('loans.create') }}" class="btn-primary px-8 py-3 rounded-2xl elevation-2 hover:elevation-3 flex items-center space-x-2 text-sm font-bold tracking-tight">
                <span class="material-symbols-rounded text-lg">add_circle</span>
                <span>Initiate New Loan</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Global Metric Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-blue-600">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Scale</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Issued</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 tracking-tighter">{{ number_format($loans->total()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-emerald-600">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">In-Flight</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Active Streams</p>
                    <p class="text-3xl font-extrabold text-emerald-600 mt-4 tracking-tighter">{{ number_format($loans->where('status', 'Active')->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-rose-600">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Critical</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Overdue Assets</p>
                    <p class="text-3xl font-extrabold text-rose-600 mt-4 tracking-tighter">{{ number_format($loans->where('status', 'Overdue')->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-slate-400">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Archived</p>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Closed Accounts</p>
                    <p class="text-3xl font-extrabold text-slate-400 mt-4 tracking-tighter">{{ number_format($loans->where('status', 'Closed')->count()) }}</p>
                </div>
            </div>

            <!-- Ledger View -->
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-slate-50/50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic leading-none">Portfolio Summary</h3>
                    <div class="flex items-center space-x-4">
                        <div class="relative group">
                            <span class="material-symbols-rounded absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-blue-600 transition-colors">filter_center_focus</span>
                            <input type="text" placeholder="Locate Ticket #..." 
                                class="pl-12 pr-6 py-3 bg-white border border-slate-200 rounded-2xl text-sm font-bold text-slate-900 focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all premium-shadow w-72">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Transaction UID</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Primary Holder</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Capital Metrics</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">Temporal Data</th>
                                <th class="px-8 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-center">Lifecycle</th>
                                <th class="px-10 py-6 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] text-right">Directives</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($loans as $loan)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                    <td class="px-10 py-6">
                                        <div class="flex items-center space-x-3">
                                            <span class="w-2 h-2 rounded-full {{ $loan->status === 'Active' ? 'bg-emerald-500' : ($loan->status === 'Overdue' ? 'bg-rose-500' : 'bg-slate-300') }}"></span>
                                            <span class="font-mono font-black text-slate-900 tracking-tighter text-base">#{{ $loan->ticket_number }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">
                                                <span class="material-symbols-rounded text-slate-400 text-lg">person</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-extrabold text-slate-900 leading-tight">{{ $loan->customer->name }}</div>
                                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-0.5">{{ $loan->customer->mobile }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-0.5">
                                            <div class="text-sm font-black text-slate-900 flex items-center">
                                                <span class="text-xs mr-0.5">₹</span>{{ number_format($loan->principal_amount, 2) }}
                                            </div>
                                            <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Base Principal</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col space-y-1">
                                            <div class="text-xs font-bold text-slate-900 whitespace-nowrap">{{ $loan->loan_date->format('M d, Y') }}</div>
                                            <div class="text-[10px] font-black text-rose-500 uppercase tracking-tighter italic">Exp: {{ $loan->due_date->format('M d, Y') }}</div>
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
                                        <span class="inline-flex px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest {{ $theme['bg'] }} {{ $theme['text'] }} border {{ $theme['border'] }} items-center space-x-1.5">
                                            <span class="material-symbols-rounded text-xs">{{ $theme['icon'] }}</span>
                                            <span>{{ $loan->status }}</span>
                                        </span>
                                    </td>
                                    <td class="px-10 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('loans.show', $loan) }}" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-50 text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all rounded-xl" title="Audit Trail">
                                                <span class="material-symbols-rounded text-xl">query_stats</span>
                                            </a>
                                            @if($loan->status === 'Active')
                                                <a href="{{ route('loans.edit', $loan) }}" class="w-10 h-10 flex items-center justify-center bg-white border-2 border-slate-50 text-slate-400 hover:text-amber-600 hover:border-amber-100 hover:bg-amber-50 transition-all rounded-xl" title="Modify Parameters">
                                                    <span class="material-symbols-rounded text-xl">edit_square</span>
                                                </a>
                                            @endif
                                            <a href="{{ route('payments.create', ['loan_id' => $loan->id]) }}" class="w-10 h-10 flex items-center justify-center bg-slate-900 text-white hover:bg-emerald-600 transition-all rounded-xl shadow-lg shadow-slate-900/10 hover:shadow-emerald-600/20" title="Process Payment">
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
                                                <p class="text-slate-900 text-lg font-black tracking-tight uppercase">Void Portfolio</p>
                                                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-1">No financial streams detected in the current ledger</p>
                                            </div>
                                            <a href="{{ route('loans.create') }}" class="btn-primary px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] flex items-center space-x-3">
                                                <span class="material-symbols-rounded text-sm">add_circle</span>
                                                <span>Initiate First Transaction</span>
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
