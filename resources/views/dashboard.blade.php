<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <div class="bg-blue-600/10 p-2 rounded-2xl">
                <span class="material-symbols-rounded text-blue-600 text-3xl">dashboard</span>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Live Shop Status</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-br from-indigo-600 via-blue-700 to-slate-900 premium-shadow rounded-[3.5rem] p-12 relative overflow-hidden group">
                <!-- Decorative Elements -->
                <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-[100px] group-hover:bg-white/20 transition-all duration-700"></div>
                <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-blue-400/20 rounded-full blur-[80px]"></div>
                <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-indigo-400/10 rounded-full blur-3xl animate-pulse"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-12">
                    <div class="animate-fade-in-up">
                        <div class="flex items-center space-x-3 mb-6">
                            <span class="px-4 py-1.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-full text-[10px] font-black text-blue-100 uppercase tracking-[0.2em] font-heading">System Status: Online</span>
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                            </span>
                        </div>
                        <h3 class="text-5xl font-black tracking-tight text-white mb-4 font-heading leading-tight">
                            Welcome, <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-blue-200">{{ explode(' ', Auth::user()->name)[0] }}</span>!
                        </h3>
                        <p class="text-blue-100/70 font-bold max-w-lg uppercase tracking-widest text-xs font-heading">
                            Welcome to your shop management panel. All your loans and payments are tracked here.
                        </p>
                        
                        <div class="mt-12 flex flex-wrap items-center gap-6">
                            <a href="{{ route('loans.create') }}" class="btn-premium btn-premium-secondary px-10 py-5">
                                <span class="material-symbols-rounded text-xl mr-3">add_circle</span>
                                <span>New Loan Entry</span>
                            </a>
                            <a href="{{ route('payments.create') }}" class="btn-premium btn-premium-secondary px-10 py-5">
                                <span class="material-symbols-rounded text-xl mr-3">payments</span>
                                <span>New Payment</span>
                            </a>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="w-64 h-64 bg-white/5 border border-white/10 backdrop-blur-2xl rounded-[3rem] flex items-center justify-center relative group-hover:rotate-6 transition-transform duration-700">
                            <span class="material-symbols-rounded text-[140px] text-white/20">analytics</span>
                            <!-- Orbiting Element -->
                            <div class="absolute -top-4 -right-4 w-12 h-12 bg-white/10 backdrop-blur-lg border border-white/20 rounded-2xl flex items-center justify-center animate-bounce">
                                <span class="material-symbols-rounded text-white text-xl">trending_up</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 hover:transform hover:-translate-y-1 transition-all group">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                            <span class="material-symbols-rounded text-2xl">groups</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-heading">Growth</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Customers</p>
                    <p class="text-4xl font-extrabold text-slate-900 mt-4 tracking-tighter font-heading">{{ number_format(\App\Models\Customer::count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 hover:transform hover:-translate-y-1 transition-all group">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                            <span class="material-symbols-rounded text-2xl">contract</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-heading">Active</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Active Loans</p>
                    <p class="text-4xl font-extrabold text-slate-900 mt-4 tracking-tighter font-heading">{{ number_format(\App\Models\Loan::where('status', 'Active')->count()) }}</p>
                </div>

                <div class="bg-white premium-shadow rounded-[2rem] p-8 border border-slate-100 hover:transform hover:-translate-y-1 transition-all group">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                            <span class="material-symbols-rounded text-2xl">currency_rupee</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-heading">Cash Flow</span>
                    </div>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest leading-none">Total Collection</p>
                    <div class="flex items-baseline space-x-1 mt-4">
                        <span class="text-sm font-black text-slate-400 font-heading">₹</span>
                        <p class="text-4xl font-extrabold text-slate-900 tracking-tighter font-heading">{{ number_format(\App\Models\Payment::sum('amount') / 1000, 1) }}K+</p>
                    </div>
                </div>

                <div class="bg-indigo-700 premium-shadow rounded-[2rem] p-8 hover:transform hover:-translate-y-1 transition-all group border border-slate-800">
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white group-hover:bg-white group-hover:text-slate-900 transition-all">
                            <span class="material-symbols-rounded text-2xl">warning</span>
                        </div>
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest font-heading">Attention</span>
                    </div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Pending Due</p>
                    <p class="text-4xl font-extrabold text-rose-500 mt-4 tracking-tighter font-heading">{{ number_format(\App\Models\Loan::where('status', 'Overdue')->count()) }}</p>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recent Customers -->
                <div class="lg:col-span-2">
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-100 overflow-hidden">
                        <div class="px-10 py-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/30">
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest font-heading italic">Recently Added Customers</h3>
                                <p class="text-[10px] text-slate-500 font-bold uppercase mt-1 tracking-tight">New registrations</p>
                            </div>
                            <a href="{{ route('customers.index') }}" class="btn-premium btn-premium-secondary px-6 py-2.5">View All</a>
                        </div>
                        <div class="p-0">
                            <table class="w-full border-collapse">
                                <tbody class="divide-y divide-slate-50">
                                    @forelse(\App\Models\Customer::latest()->take(5)->get() as $customer)
                                    <tr class="hover:bg-slate-50/50 transition-all duration-300">
                                        <td class="px-10 py-6">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 rounded-2xl bg-indigo-700 flex items-center justify-center text-white mr-5 shadow-lg shadow-indigo-600/10">
                                                    <span class="material-symbols-rounded text-xl">person</span>
                                                </div>
                                                <div>
                                                    <p class="text-base font-extrabold text-slate-900 leading-tight font-heading">{{ $customer->name }}</p>
                                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mt-1">{{ $customer->mobile }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center space-x-2 text-slate-500 font-bold text-[10px] uppercase tracking-widest italic">
                                                <span class="material-symbols-rounded text-sm">location_city</span>
                                                <span>{{ $customer->city ?: 'UNMAPPED' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="{{ route('customers.show', $customer) }}" class="w-10 h-10 inline-flex items-center justify-center bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-white rounded-xl transition-all premium-shadow">
                                                <span class="material-symbols-rounded">visibility</span>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td class="px-10 py-20 text-center">
                                            <span class="material-symbols-rounded text-slate-200 text-5xl mb-4">group_off</span>
                                            <p class="text-slate-400 text-xs font-bold uppercase tracking-widest italic font-heading">No customers found</p>
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
                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 italic">Quick Actions</h4>
                        <div class="grid grid-cols-2 gap-6">
                            <a href="{{ route('loans.index') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-blue-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-blue-600 group-hover:text-white transition-colors text-3xl">receipt_long</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">All Loans</p>
                            </a>
                            <a href="{{ route('payments.index') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-emerald-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-emerald-600 group-hover:text-white transition-colors text-3xl">payments</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Payments</p>
                            </a>
                            <a href="#" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-indigo-600 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-indigo-600 group-hover:text-white transition-colors text-3xl">analytics</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Reports</p>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="p-6 bg-slate-50 rounded-[2rem] hover:bg-indigo-700 transition-all group flex flex-col items-center text-center">
                                <span class="material-symbols-rounded text-slate-900 group-hover:text-white transition-colors text-3xl">settings_account_box</span>
                                <p class="text-[10px] font-black text-slate-900 group-hover:text-white mt-4 uppercase tracking-tighter">Profile</p>
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
                                <span class="text-[9px] font-black uppercase tracking-widest">System Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
