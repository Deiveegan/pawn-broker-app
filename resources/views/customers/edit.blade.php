<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('customers.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">edit</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Modify Profile') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Updating authenticated donor #{{ $customer->id }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <!-- Header Area -->
                <div class="bg-slate-900 px-10 py-10 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">{{ $customer->name }}</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-80 italic">Precision data refinement protocol</p>
                    </div>
                </div>

                <div class="p-0">
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section 1: Demographics -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">01</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Identifying Characteristics</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="relative group">
                                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-bold text-slate-900 text-sm premium-shadow"
                                        placeholder="Enter Legal Name">
                                    <label for="name" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Full Name <span class="text-rose-600">*</span>
                                    </label>
                                    @error('name')
                                        <p class="mt-2 ml-4 text-[10px] text-rose-600 font-bold uppercase tracking-widest flex items-center">
                                            <span class="material-symbols-rounded text-xs mr-1">warning</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="relative group">
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $customer->mobile) }}" required maxlength="10"
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-black text-slate-900 text-sm premium-shadow"
                                        placeholder="Primary Handset #">
                                    <label for="mobile" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Mobile Terminal <span class="text-rose-600">*</span>
                                    </label>
                                    @error('mobile')
                                        <p class="mt-2 ml-4 text-[10px] text-rose-600 font-bold uppercase tracking-widest flex items-center">
                                            <span class="material-symbols-rounded text-xs mr-1">warning</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="relative group md:col-span-2">
                                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-medium text-slate-900 text-sm premium-shadow"
                                        placeholder="Electronic mail address (Optional)">
                                    <label for="email" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        Email Domain
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Authentication -->
                        <div class="p-10 border-b border-slate-100">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">02</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Verification Credentials</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="relative group">
                                    <select name="id_proof_type" id="id_proof_type" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-[11px] premium-shadow">
                                        <option value="">Select Protocol</option>
                                        <option value="Aadhaar" {{ old('id_proof_type', $customer->id_proof_type) == 'Aadhaar' ? 'selected' : '' }}>Aadhaar (UIDAI)</option>
                                        <option value="PAN" {{ old('id_proof_type', $customer->id_proof_type) == 'PAN' ? 'selected' : '' }}>PAN (Income Tax)</option>
                                        <option value="Driving License" {{ old('id_proof_type', $customer->id_proof_type) == 'Driving License' ? 'selected' : '' }}>Driving License (RTO)</option>
                                        <option value="Voter ID" {{ old('id_proof_type', $customer->id_proof_type) == 'Voter ID' ? 'selected' : '' }}>Voter ID (Election Comm)</option>
                                    </select>
                                    <label for="id_proof_type" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Document Class <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">verified_user</span>
                                </div>

                                <div class="relative group">
                                    <input type="text" name="id_proof_number" id="id_proof_number" value="{{ old('id_proof_number', $customer->id_proof_number) }}" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-black text-slate-900 text-sm tracking-widest premium-shadow"
                                        placeholder="Instrument ID #">
                                    <label for="id_proof_number" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Unique Identifier <span class="text-rose-600">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Geolocation -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">03</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Geographical Residence</h4>
                            </div>

                            <div class="space-y-10">
                                <div class="relative group">
                                    <textarea name="address" id="address" rows="3" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-medium text-slate-900 text-sm premium-shadow resize-none italic"
                                        placeholder="Detailed street address, building, and landmarks...">{{ old('address', $customer->address) }}</textarea>
                                    <label for="address" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Primary Domicile <span class="text-rose-600">*</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="relative group">
                                        <input type="text" name="city" id="city" value="{{ old('city', $customer->city) }}" required
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-bold text-slate-900 text-sm premium-shadow">
                                        <label for="city" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Municipality</label>
                                    </div>
                                    <div class="relative group">
                                        <input type="text" name="state" id="state" value="{{ old('state', $customer->state) }}" required
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-bold text-slate-900 text-sm premium-shadow">
                                        <label for="state" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Region</label>
                                    </div>
                                    <div class="relative group">
                                        <input type="text" name="pincode" id="pincode" value="{{ old('pincode', $customer->pincode) }}" required maxlength="6"
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-black text-slate-900 text-sm tracking-[0.2em] premium-shadow">
                                        <label for="pincode" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Postal Index</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Visual Manifest (Edit Mode) -->
                        <div class="p-10">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white text-xs font-black">04</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Biometric Imaging</h4>
                            </div>

                            <div class="flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-10">
                                @if($customer->photo)
                                    <div class="relative group">
                                        <div class="w-32 h-32 rounded-[2.5rem] border-4 border-white premium-shadow overflow-hidden">
                                            <img src="{{ Storage::url($customer->photo) }}" alt="Customer Photo" class="w-full h-full object-cover">
                                        </div>
                                        <div class="absolute -bottom-2 -right-2 bg-blue-600 text-white p-2 rounded-xl shadow-lg">
                                            <span class="material-symbols-rounded text-sm">visibility</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-32 h-32 rounded-[2.5rem] bg-slate-100 flex items-center justify-center border-2 border-dashed border-slate-200 text-slate-400">
                                        <span class="material-symbols-rounded text-4xl">person</span>
                                    </div>
                                @endif

                                <div class="flex-1 w-full relative">
                                    <label class="flex flex-col items-center justify-center w-full h-[8rem] border-2 border-slate-200 border-dashed rounded-[2.5rem] cursor-pointer bg-slate-50 hover:bg-white hover:border-blue-400 transition-all group overflow-hidden premium-shadow">
                                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                            <span class="material-symbols-rounded text-slate-300 group-hover:text-blue-500 text-3xl mb-2 transition-all group-hover:scale-110">update</span>
                                            <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest">Modify Visual Asset</p>
                                        </div>
                                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="showFileName(this)">
                                    </label>
                                    <div id="file-name" class="mt-4 px-6 py-2 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] hidden inline-flex items-center">
                                        <span class="material-symbols-rounded text-sm mr-2 leading-none">attachment</span>
                                        <span id="file-name-text"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Logic -->
                        <div class="p-10 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('customers.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] hover:text-rose-600 transition-colors flex items-center group">
                                <span class="material-symbols-rounded text-base mr-2 group-hover:shake">cancel</span>
                                <span>Discard Changes</span>
                            </a>
                            <button type="submit" 
                                class="w-full sm:w-auto px-16 py-6 bg-slate-900 text-white font-black rounded-[2.5rem] shadow-2xl shadow-slate-900/20 hover:bg-slate-800 transition-all uppercase tracking-[0.2em] text-[11px] flex items-center justify-center space-x-3 hover:scale-[1.02]">
                                <span class="material-symbols-rounded text-xl">save_as</span>
                                <span>Commit Protocol Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showFileName(input) {
            const fileName = input.files[0]?.name;
            const container = document.getElementById('file-name');
            const text = document.getElementById('file-name-text');
            if (fileName) {
                text.textContent = fileName;
                container.classList.remove('hidden');
            }
        }
    </script>
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px); }
            75% { transform: translateX(2px); }
        }
        .group:hover .group-hover\:shake {
            animation: shake 0.2s ease-in-out infinite;
        }
    </style>
</x-app-layout>
