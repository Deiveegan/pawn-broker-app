<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('users.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                <span class="material-symbols-rounded">arrow_back</span>
            </a>
            <div class="bg-blue-600/10 p-2 rounded-2xl">
                <span class="material-symbols-rounded text-blue-600 text-3xl">manage_accounts</span>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    {{ __('Modify Clearance') }}
                </h2>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Personnel ID: {{ $user->id }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[3rem] border border-slate-200 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest italic">Identity Adjustment</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Updating terminal access parameters for {{ $user->name }}</p>
                </div>

                <form action="{{ route('users.update', $user) }}" method="POST" class="p-10 space-y-8">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Full Name -->
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Full Legal Name</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-rounded text-slate-400 group-focus-within:text-blue-600 transition-colors">person</span>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-900 placeholder-slate-300"
                                    placeholder="e.g. John Doe">
                            </div>
                            @error('name') <p class="text-[10px] font-bold text-rose-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-4">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Email Address</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="material-symbols-rounded text-slate-400 group-focus-within:text-blue-600 transition-colors">mail</span>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="block w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-50 rounded-2xl focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-bold text-slate-900 placeholder-slate-300"
                                    placeholder="john@example.com">
                            </div>
                            @error('email') <p class="text-[10px] font-bold text-rose-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="space-y-4">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Authority Level</label>
                        <div class="grid grid-cols-2 gap-6">
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="role" value="staff" class="peer sr-only" {{ old('role', $user->role) === 'staff' ? 'checked' : '' }}>
                                <div class="p-6 bg-slate-50 border-2 border-slate-50 rounded-3xl peer-checked:border-blue-500 peer-checked:bg-blue-50/50 transition-all hover:bg-slate-100">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center premium-shadow">
                                            <span class="material-symbols-rounded text-slate-400 group-peer-checked:text-blue-600 transition-colors">badge</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase tracking-tighter">Duty Staff</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Operational Access</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative group cursor-pointer">
                                <input type="radio" name="role" value="admin" class="peer sr-only" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                                <div class="p-6 bg-slate-50 border-2 border-slate-50 rounded-3xl peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 transition-all hover:bg-slate-100">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center premium-shadow">
                                            <span class="material-symbols-rounded text-slate-400 group-peer-checked:text-indigo-600 transition-colors">shield_person</span>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-slate-900 uppercase tracking-tighter">Terminal Admin</p>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Regulatory Access</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('role') <p class="text-[10px] font-bold text-rose-500 mt-1 uppercase tracking-widest">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="bg-indigo-50 rounded-3xl p-6 border border-indigo-100 flex items-start space-x-4">
                        <div class="bg-white p-2 rounded-xl premium-shadow">
                            <span class="material-symbols-rounded text-indigo-600 text-sm">security</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-indigo-900 uppercase tracking-widest mb-1">Security Advisory</p>
                            <p class="text-[9px] font-medium text-indigo-600 leading-relaxed uppercase tracking-tighter italic">Passwords cannot be adjusted from this panel for data integrity. Use the 'Access Identity' terminal from the personnel's session to update security keys.</p>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" class="w-full py-5 bg-indigo-700 text-white font-black text-xs uppercase tracking-[0.3em] rounded-[2rem] hover:bg-indigo-800 transition-all shadow-xl shadow-indigo-600/10 active:scale-[0.98]">
                            Commit Adjustments
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
