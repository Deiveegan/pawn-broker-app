<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">badge</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Staff Management') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest">Internal team access & roles</p>
                </div>
            </div>
            <a href="{{ route('users.create') }}" class="px-8 py-3 bg-indigo-700 text-white font-black text-[10px] uppercase tracking-widest rounded-xl hover:bg-indigo-800 transition-all shadow-xl shadow-indigo-600/20 flex items-center space-x-2">
                <span class="material-symbols-rounded text-lg">person_add</span>
                <span>Enlist New Staff</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div>
                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">Active Duty Roster</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Authorized personnel for this terminal</p>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/50 border-b border-slate-200">
                                <th class="px-10 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em]">Personnel Identity</th>
                                <th class="px-8 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-center">Access Authority</th>
                                <th class="px-8 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-center">Security Status</th>
                                <th class="px-10 py-6 text-xs font-bold uppercase text-slate-500 tracking-[0.15em] text-right">Operations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-slate-50/50 transition-all duration-300 group">
                                    <td class="px-10 py-8">
                                         <div class="flex items-center space-x-5">
                                             <div class="w-12 h-12 rounded-2xl bg-indigo-700 flex items-center justify-center text-white shadow-lg shadow-indigo-600/10 group-hover:scale-110 transition-all">
                                                 <span class="material-symbols-rounded text-xl">person</span>
                                             </div>
                                             <div>
                                                 <p class="text-base font-extrabold text-slate-900 tracking-tight leading-none group-hover:text-blue-600 transition-colors">{{ $user->name }}</p>
                                                 <div class="flex items-center space-x-2 mt-2">
                                                     <span class="material-symbols-rounded text-slate-400 text-sm">mail</span>
                                                     <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $user->email }}</p>
                                                 </div>
                                             </div>
                                         </div>
                                    </td>
                                    <td class="px-8 py-8 text-center">
                                        <span class="inline-flex px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $user->role === 'admin' ? 'bg-indigo-50 text-indigo-600 border border-indigo-100' : 'bg-blue-50 text-blue-600 border border-blue-100' }}">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-8 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                            <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Authorized</span>
                                        </div>
                                    </td>
                                    <td class="px-10 py-8 text-right">
                                         <div class="flex items-center justify-end space-x-3">
                                             <a href="{{ route('users.edit', $user) }}" class="w-10 h-10 flex items-center justify-center bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-600 hover:text-white transition-all border border-blue-100" title="Modify Clearance">
                                                 <span class="material-symbols-rounded text-xl leading-none">edit_square</span>
                                             </a>
                                             <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Revoke access for this personnel?')">
                                                 @csrf
                                                 @method('DELETE')
                                                 <button type="submit" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all border border-rose-100" title="Revoke Access">
                                                     <span class="material-symbols-rounded text-xl leading-none">person_remove</span>
                                                 </button>
                                             </form>
                                         </div>
                                     </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-10 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2.5rem] flex items-center justify-center mb-6">
                                                <span class="material-symbols-rounded text-slate-200 text-5xl">group_off</span>
                                            </div>
                                            <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] italic">No additional personnel registered to this terminal</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-indigo-700 premium-shadow rounded-[2.5rem] p-10 text-white relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10">Governance Protocol</h4>
                    <p class="text-sm font-medium text-slate-400 leading-relaxed mb-8 relative z-10 italic">Only personnel with 'Admin' authority can modify, enlist, or revoke access for other team members. Staff members have restricted access to configuration terminals.</p>
                    <div class="flex items-center space-x-3 text-emerald-400 relative z-10">
                        <span class="material-symbols-rounded text-base">verified_user</span>
                        <span class="text-[9px] font-black uppercase tracking-[0.2em]">End-to-end security enforced</span>
                    </div>
                </div>
                
                <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 p-10 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Total Unit Strength</p>
                        <p class="text-4xl font-black text-slate-900 tracking-tighter italic">{{ $users->count() + 1 }}</p>
                        <p class="text-[9px] text-slate-500 font-bold uppercase mt-4">Including your secure uplink</p>
                    </div>
                    <div class="w-20 h-20 bg-blue-50 rounded-[2.5rem] flex items-center justify-center">
                        <span class="material-symbols-rounded text-blue-600 text-4xl">diversity_3</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
