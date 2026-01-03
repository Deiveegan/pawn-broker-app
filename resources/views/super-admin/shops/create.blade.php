<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('super-admin.shops.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-all premium-shadow">
                <span class="material-symbols-rounded text-slate-600">arrow_back</span>
            </a>
            <div class="bg-blue-600/10 p-2 rounded-2xl">
                <span class="material-symbols-rounded text-blue-600 text-3xl">add_business</span>
            </div>
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                    {{ __('Partner Onboarding') }}
                </h2>
                <p class="text-xs font-medium text-slate-500 uppercase tracking-widest text-[9px]">Initialize new tenant environment</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('super-admin.shops.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-10">
                    <!-- Shop Information -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="bg-slate-900 px-10 py-6 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] italic">Identity Profile</h3>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Tenant Brand & Logistics</p>
                            </div>
                            <span class="material-symbols-rounded text-blue-400 text-3xl">domain</span>
                        </div>
                        <div class="p-10 space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative group">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Legal Shop name</label>
                                    <input type="text" name="shop_name" id="shop_name" required
                                        value="{{ old('shop_name') }}"
                                        class="w-full px-5 py-4 bg-slate-50 border-2 @error('shop_name') border-rose-500 @else border-slate-100 group-hover:border-slate-200 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="e.g. Diamond Pawn Brokers">
                                    @error('shop_name')
                                        <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="relative group">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Brand Visual (Logo)</label>
                                    <div class="relative">
                                        <input type="file" name="shop_logo" id="shop_logo"
                                            class="w-full px-5 py-3.5 bg-slate-50 border-2 @error('shop_logo') border-rose-500 @else border-slate-100 @enderror rounded-2xl file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all text-sm font-bold text-slate-500">
                                    </div>
                                    @error('shop_logo')
                                        <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Headquarters Address</label>
                                <textarea name="shop_address" id="shop_address" rows="3"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 @error('shop_address') border-rose-500 @else border-slate-100 group-hover:border-slate-200 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-semibold text-slate-700 italic" placeholder="Provide full physical location details...">{{ old('shop_address') }}</textarea>
                                @error('shop_address')
                                    <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Admin User Information -->
                    <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                        <div class="bg-blue-600 px-10 py-6 flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-black text-white uppercase tracking-[0.2em] italic">Security Master</h3>
                                <p class="text-[9px] text-blue-100 font-bold uppercase tracking-widest mt-1">Primary Administrative Authority</p>
                            </div>
                            <span class="material-symbols-rounded text-white text-3xl">shield_person</span>
                        </div>
                        <div class="p-10 space-y-8">
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Administrator Full Name</label>
                                <input type="text" name="admin_name" id="admin_name" required
                                    value="{{ old('admin_name') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 @error('admin_name') border-rose-500 @else border-slate-100 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="Master User Identity">
                                @error('admin_name')
                                    <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Administrative Email (System Login)</label>
                                <input type="email" name="admin_email" id="admin_email" required
                                    value="{{ old('admin_email') }}"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 @error('admin_email') border-rose-500 @else border-slate-100 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="admin@enterprise.com">
                                @error('admin_email')
                                    <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Contact Mobile Number</label>
                                <input type="text" name="admin_mobile" id="admin_mobile" required
                                    value="{{ old('admin_mobile') }}"
                                    pattern="[0-9]{10}"
                                    maxlength="10"
                                    class="w-full px-5 py-4 bg-slate-50 border-2 @error('admin_mobile') border-rose-500 @else border-slate-100 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="Eg. 9876543210">
                                @error('admin_mobile')
                                    <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative group">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Access Password</label>
                                    <input type="password" name="admin_password" id="admin_password" required
                                        class="w-full px-5 py-4 bg-slate-50 border-2 @error('admin_password') border-rose-500 @else border-slate-100 @enderror rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="••••••••">
                                    @error('admin_password')
                                        <p class="text-rose-600 text-[10px] font-bold mt-2 ml-1 uppercase tracking-wider">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="relative group">
                                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2 ml-1">Verify Password</label>
                                    <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" required
                                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/5 transition-all font-bold text-slate-900" placeholder="••••••••">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('super-admin.shops.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-slate-600 transition-colors">Abort Onboarding</a>
                        <button type="submit" class="px-16 py-5 btn-primary text-white font-black rounded-3xl shadow-2xl hover:shadow-blue-900/20 transition-all uppercase tracking-[0.2em] text-xs flex items-center space-x-4">
                            <span class="material-symbols-rounded text-xl">rocket_launch</span>
                            <span>Generate Ecosystem</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
