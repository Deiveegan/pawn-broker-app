<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('super-admin.shops.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">add_business</span>
            <h2 class="font-black text-2xl text-gray-800 tracking-tighter uppercase">
                {{ __('Onboard New Partner') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('super-admin.shops.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-8">
                    <!-- Shop Information -->
                    <div class="md-card elevation-2 overflow-hidden bg-white">
                        <div class="bg-gray-900 px-8 py-5 flex items-center justify-between">
                            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Shop Profile (Tenant)</h3>
                            <span class="material-icons text-blue-400">storefront</span>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <input type="text" name="shop_name" id="shop_name" required
                                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all font-black uppercase text-sm" placeholder="Enterprise Name">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Shop Name</label>
                                </div>
                                <div class="relative">
                                    <input type="file" name="shop_logo" id="shop_logo"
                                        class="w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-400">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Brand Logo</label>
                                </div>
                            </div>
                            <div class="relative">
                                <textarea name="shop_address" id="shop_address" rows="2"
                                    class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all text-sm italic" placeholder="Full physical address..."></textarea>
                                <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Office Address</label>
                            </div>
                        </div>
                    </div>

                    <!-- Admin User Information -->
                    <div class="md-card elevation-2 overflow-hidden bg-white">
                        <div class="bg-blue-600 px-8 py-5 flex items-center justify-between">
                            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Administrative Master Account</h3>
                            <span class="material-icons text-white">person_add</span>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="relative">
                                <input type="text" name="admin_name" id="admin_name" required
                                    class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all font-black uppercase text-sm" placeholder="Full Administrative Name">
                                <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Primary Contact Name</label>
                            </div>
                            <div class="relative">
                                <input type="email" name="admin_email" id="admin_email" required
                                    class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all font-bold text-sm" placeholder="admin@shop.com">
                                <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Official Email (Login ID)</label>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <input type="password" name="admin_password" id="admin_password" required
                                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all text-sm" placeholder="••••••••">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Secure Password</label>
                                </div>
                                <div class="relative">
                                    <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" required
                                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all text-sm" placeholder="••••••••">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <a href="{{ route('super-admin.shops.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Cancel Onboarding</a>
                        <button type="submit" class="px-12 py-4 bg-gray-900 text-white font-black rounded-2xl shadow-xl hover:bg-black transition-all uppercase tracking-widest text-xs flex items-center space-x-3">
                            <span class="material-icons text-sm">rocket_launch</span>
                            <span>Initialize Shop Account</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
