<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-600/10 p-2 rounded-2xl">
                <span class="material-symbols-rounded text-blue-600 text-3xl">dashboard</span>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    {{ __('Executive Summary') }}
                </h2>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Real-time operational overview</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            <!-- Welcome Card -->
            <div class="bg-slate-900 premium-shadow rounded-[3rem] p-10 relative overflow-hidden text-white">
                <div class="absolute -top-20 -right-20 w-80 h-80 bg-blue-600/20 rounded-full blur-[100px]"></div>
                <div class="absolute -bottom-20 -left-20 w-60 h-60 bg-emerald-600/10 rounded-full blur-[80px]"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-10">
                    <div>
                        <h3 class="text-3xl font-black tracking-tight mb-2">Salutations, {{ explode(' ', Auth::user()->name)[0] }}!</h3>
                        <p class="text-slate-400 font-medium max-w-md uppercase tracking-widest text-[10px]">Your pawn brokerage ecosystem is performing at optimal parameters.</p>
                        
                        <div class="mt-10 flex items-center gap-4">
                            <a href="{{ route('loans.create') }}" class="btn-primary px-8 py-4 rounded-2xl flex items-center space-x-3 text-xs font-black uppercase tracking-widest transition-all hover:scale-105">
                                <span class="material-symbols-rounded text-xl">add_circle</span>
                                <span>Initiate Loan</span>
                            </a>
                            <a href="{{ route('payments.create') }}" class="px-8 py-4 bg-white/5 border border-white/10 rounded-2xl flex items-center space-x-3 text-xs font-black uppercase tracking-widest text-white hover:bg-white/10 transition-all">
                                <span class="material-symbols-rounded text-xl">payments</span>
                                <span>Record Return</span>
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block opacity-20">
                        <span class="material-symbols-rounded text-[120px]">cognition</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-blue-600 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-6">
                        <span class="material-symbols-rounded text-blue-600 bg-blue-50 p-3 rounded-xl">groups</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Growth</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Clients</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 tracking-tighter">{{ number_format(\App\Models\Customer::count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-indigo-600 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-6">
                        <span class="material-symbols-rounded text-indigo-600 bg-indigo-50 p-3 rounded-xl">receipt_long</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Active</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Managed Loans</p>
                    <p class="text-3xl font-extrabold text-slate-900 mt-4 tracking-tighter">{{ number_format(\App\Models\Loan::where('status', 'Active')->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-emerald-600 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-6">
                        <span class="material-symbols-rounded text-emerald-600 bg-emerald-50 p-3 rounded-xl">currency_rupee</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Liquidity</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Gross Collection</p>
                    <div class="flex items-baseline space-x-1 mt-4">
                        <span class="text-sm font-black text-slate-400">₹</span>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tighter">{{ number_format(\App\Models\Payment::sum('amount') / 1000, 1) }}K+</p>
                    </div>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border-b-4 border-rose-600 hover:transform hover:-translate-y-1 transition-all">
                    <div class="flex items-center justify-between mb-6">
                        <span class="material-symbols-rounded text-rose-600 bg-rose-50 p-3 rounded-xl">warning</span>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Attention</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Overdue Assets</p>
                    <p class="text-3xl font-extrabold text-rose-600 mt-4 tracking-tighter">{{ number_format(\App\Models\Loan::where('status', 'Overdue')->count()) }}</p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recent Customers -->
                <div class="lg:col-span-2">
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Latest Client Enlistments</h3>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">Verification queue entries</p>
                            </div>
                            <a href="{{ route('customers.index') }}" class="px-4 py-2 bg-white border border-slate-200 rounded-xl text-[10px] font-black text-blue-600 uppercase tracking-widest hover:bg-blue-50 transition-all premium-shadow">View Registry</a>
                        </div>
                        <div class="p-0">
                            <table class="w-full border-collapse">
                                <tbody class="divide-y divide-slate-100">
                                    @forelse(\App\Models\Customer::latest()->take(5)->get() as $customer)
                                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                        <td class="px-10 py-6">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center text-white mr-5 shadow-lg shadow-slate-900/10">
                                                    <span class="material-symbols-rounded text-xl">person</span>
                                                </div>
                                                <div>
                                                    <p class="text-base font-extrabold text-slate-900 leading-tight">{{ $customer->name }}</p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $customer->mobile }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center space-x-2 text-slate-500 font-semibold text-xs italic">
                                                <span class="material-symbols-rounded text-sm">location_city</span>
                                                <span class="uppercase tracking-widest">{{ $customer->city ?: 'UNMAPPED' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="{{ route('customers.show', $customer) }}" class="w-10 h-10 inline-flex items-center justify-center bg-white border-2 border-slate-50 text-slate-300 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 rounded-xl transition-all">
                                                <span class="material-symbols-rounded">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-10 py-20 text-center">
                                            <span class="material-symbols-rounded text-slate-200 text-5xl mb-4">group_off</span>
                                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest italic">Inventory currently vacant</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Shortcuts column -->
                <div class="space-y-10">
                    <div class="bg-white premium-shadow rounded-[2.5rem] p-10 border border-slate-200">
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 italic">Tactical Shortcuts</h4>
                        <div class="grid grid-cols-2 gap-6">
                            <a href="{{ route('loans.index') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-blue-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-blue-600 group-hover:text-white transition-colors text-3xl">receipt_long</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Loan Index</p>
                            </a>
                            <a href="{{ route('payments.index') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-emerald-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-emerald-600 group-hover:text-white transition-colors text-3xl">payments</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Finance</p>
                            </a>
                            <a href="#" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-indigo-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-indigo-600 group-hover:text-white transition-colors text-3xl">analytics</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Analytics</p>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-slate-900 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-slate-900 group-hover:text-white transition-colors text-3xl">settings_account_box</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Identity</p>
                            </a>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-600 premium-shadow rounded-[2.5rem] p-10 text-white relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-indigo-800 opacity-100"></div>
                        <div class="relative z-10">
                            <h4 class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.2em] mb-6">System Insight</h4>
                            <p class="text-sm font-bold leading-relaxed mb-8 italic">"Optimization is not a destination, it is a continuous pursuit of operational excellence."</p>
                            <div class="flex items-center space-x-3 text-indigo-200">
                                <div class="w-2 h-2 bg-indigo-300 rounded-full animate-pulse shadow-[0_0_8px_rgba(165,180,252,0.8)]"></div>
                                <span class="text-[9px] font-black uppercase tracking-widest">Autonomous Core Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
