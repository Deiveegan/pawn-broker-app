<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('super-admin.shops.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">edit</span>
            <h2 class="font-black text-2xl text-gray-800 tracking-tighter uppercase">
                {{ __('Refine Partner Profile') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('super-admin.shops.update', $shop) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-8">
                    <!-- Shop Information -->
                    <div class="md-card elevation-2 overflow-hidden bg-white text-center">
                        <div class="bg-gray-900 px-8 py-5 flex items-center justify-between">
                            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] italic">Operational Context</h3>
                            <span class="px-2 py-0.5 rounded bg-blue-600 text-[8px] font-black text-white uppercase tracking-tighter">ID: {{ str_pad($shop->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="flex flex-col items-center mb-10">
                                <div class="w-32 h-32 rounded-3xl bg-white border-2 border-dashed border-gray-100 p-2 shadow-inner group relative overflow-hidden flex items-center justify-center">
                                    @if($shop->logo)
                                        <img src="{{ Storage::url($shop->logo) }}" class="w-full h-full object-contain">
                                    @else
                                        <span class="material-icons text-gray-200 text-6xl">store</span>
                                    @endif
                                </div>
                                <p class="text-[9px] font-bold text-gray-400 mt-4 uppercase tracking-widest leading-none italic">Current Registered Logo</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <input type="text" name="name" id="name" value="{{ old('name', $shop->name) }}" required
                                        class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all font-black uppercase text-sm">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Enterprise Name</label>
                                </div>
                                <div class="relative">
                                    <input type="file" name="logo" id="logo"
                                        class="w-full px-4 py-3.5 border-2 border-gray-100 rounded-2xl text-xs font-bold text-gray-400">
                                    <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Update Logo</label>
                                </div>
                            </div>

                            <div class="relative">
                                <textarea name="address" id="address" rows="2"
                                    class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all text-sm italic">{{ old('address', $shop->address) }}</textarea>
                                <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Physical Address</label>
                            </div>

                            <div class="relative">
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $shop->mobile) }}"
                                    pattern="[0-9]{10}"
                                    maxlength="10"
                                    class="w-full px-4 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-600 transition-all font-bold text-sm" placeholder="Eg.  9876543210">
                                <label class="absolute left-4 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">Contact Mobile</label>
                            </div>

                            <div class="flex items-center justify-center pt-4">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ $shop->is_active ? 'checked' : '' }} class="w-6 h-6 rounded-lg border-gray-100 text-blue-600 shadow-sm focus:ring-0 focus:ring-offset-0 transition-all">
                                    <span class="ms-4 text-xs font-black text-gray-500 uppercase tracking-[0.2em] group-hover:text-gray-900 transition-colors">Authorized for Operation</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-4">
                        <a href="{{ route('super-admin.shops.index') }}" class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Exit Without Saving</a>
                        <button type="submit" class="px-12 py-4 bg-blue-600 text-white font-black rounded-2xl shadow-xl shadow-blue-100 hover:bg-blue-700 transition-all uppercase tracking-widest text-xs flex items-center space-x-3">
                            <span class="material-icons text-sm">save</span>
                            <span>Commit Changes</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
