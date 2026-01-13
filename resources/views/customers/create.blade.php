<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('customers.index') }}" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-xl transition-all premium-shadow">
                    <span class="material-symbols-rounded">arrow_back</span>
                </a>
                <div class="bg-blue-600/10 p-2 rounded-2xl">
                    <span class="material-symbols-rounded text-blue-600 text-3xl">person_add</span>
                </div>
                <div>
                    <h2 class="font-extrabold text-2xl text-slate-900 tracking-tight">
                        {{ __('Register New Client') }}
                    </h2>
                    <p class="text-xs font-medium text-slate-500 uppercase tracking-widest leading-none mt-1">Acquiring primary borrower data</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white premium-shadow rounded-[2.5rem] border border-slate-200 overflow-hidden">
                <!-- Header Area -->
                <div class="bg-indigo-700 px-10 py-10 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px]"></div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-widest">Client Onboarding</h3>
                        <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-2 opacity-80 italic">Formal protocol for authenticated borrower registration</p>
                    </div>
                </div>

                <div class="p-0">
                    <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Section 1: Demographics -->
                        <div class="p-10 border-b border-slate-100 bg-slate-50/30">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">01</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Identifying Characteristics</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="relative group">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
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
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" required maxlength="10"
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
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
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
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">02</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Verification Credentials</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="relative group">
                                    <select name="id_proof_type" id="id_proof_type" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[1.5rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all appearance-none bg-white font-black text-slate-900 uppercase tracking-widest text-[11px] premium-shadow">
                                        <option value="">Select Protocol</option>
                                        <option value="Aadhaar" {{ old('id_proof_type') == 'Aadhaar' ? 'selected' : '' }}>Aadhaar (UIDAI)</option>
                                        <option value="PAN" {{ old('id_proof_type') == 'PAN' ? 'selected' : '' }}>PAN (Income Tax)</option>
                                        <option value="Driving License" {{ old('id_proof_type') == 'Driving License' ? 'selected' : '' }}>Driving License (RTO)</option>
                                        <option value="Voter ID" {{ old('id_proof_type') == 'Voter ID' ? 'selected' : '' }}>Voter ID (Election Comm)</option>
                                    </select>
                                    <label for="id_proof_type" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Document Class <span class="text-rose-600">*</span>
                                    </label>
                                    <span class="material-symbols-rounded absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">verified_user</span>
                                </div>

                                <div class="relative group">
                                    <input type="text" name="id_proof_number" id="id_proof_number" value="{{ old('id_proof_number') }}" required
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
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">03</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Geographical Residence</h4>
                            </div>

                            <div class="space-y-10">
                                <div class="relative group">
                                    <textarea name="address" id="address" rows="3" required
                                        class="w-full px-6 py-5 border border-slate-200 rounded-[2rem] focus:ring-4 focus:ring-blue-600/5 focus:border-blue-600 transition-all bg-white font-medium text-slate-900 text-sm premium-shadow resize-none italic"
                                        placeholder="Detailed street address, building, and landmarks...">{{ old('address') }}</textarea>
                                    <label for="address" class="absolute left-6 -top-2.5 bg-white px-2 text-[10px] font-black text-blue-600 uppercase tracking-widest">
                                        Primary Domicile <span class="text-rose-600">*</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                    <div class="relative group">
                                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-bold text-slate-900 text-sm premium-shadow">
                                        <label for="city" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Municipality</label>
                                    </div>
                                    <div class="relative group">
                                        <input type="text" name="state" id="state" value="{{ old('state', 'Tamil Nadu') }}" required
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-bold text-slate-900 text-sm premium-shadow">
                                        <label for="state" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Region</label>
                                    </div>
                                    <div class="relative group">
                                        <input type="text" name="pincode" id="pincode" value="{{ old('pincode') }}" required maxlength="6"
                                            class="w-full px-4 py-4 border border-slate-200 rounded-2xl bg-white font-black text-slate-900 text-sm tracking-[0.2em] premium-shadow">
                                        <label for="pincode" class="absolute left-4 -top-2.5 bg-white px-2 text-[9px] font-black text-slate-400 uppercase tracking-widest">Postal Index</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: Visual Manifest -->
                        <div class="p-10">
                            <div class="flex items-center space-x-3 mb-10">
                                <div class="w-8 h-8 rounded-full bg-indigo-700 flex items-center justify-center text-white text-xs font-black">04</div>
                                <h4 class="text-sm font-black text-slate-900 uppercase tracking-widest">Biometric Imaging</h4>
                            </div>

                            <div class="relative group">
                                <label class="flex flex-col items-center justify-center w-full h-[12rem] border-2 border-slate-200 border-dashed rounded-[3rem] cursor-pointer bg-slate-50 hover:bg-white hover:border-blue-400 transition-all group overflow-hidden premium-shadow">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span class="material-symbols-rounded text-slate-300 group-hover:text-blue-500 text-5xl mb-4 transition-all group-hover:scale-110">add_a_photo</span>
                                        <p class="mb-1 text-sm text-slate-500 font-bold uppercase tracking-widest">Initiate Image Acquisition</p>
                                        <p class="text-[10px] text-slate-400 font-medium tracking-tighter italic">Standards: JPG/PNG, Maximum Payload 2MB</p>
                                    </div>
                                    <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="showFileName(this)">
                                </label>
                                <div id="file-name" class="mt-4 px-6 py-2 bg-blue-50 text-blue-600 rounded-full text-[10px] font-black uppercase tracking-[0.2em] hidden inline-flex items-center">
                                    <span class="material-symbols-rounded text-sm mr-2 leading-none">attachment</span>
                                    <span id="file-name-text"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Logic -->
                        <div class="p-10 bg-slate-50/80 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-6">
                            <a href="{{ route('customers.index') }}" class="btn-premium btn-premium-secondary">
                                <span class="material-symbols-rounded text-base mr-2">cancel</span>
                                <span>Terminate Protocol</span>
                            </a>
                            <button type="submit" class="btn-premium btn-premium-primary px-16">
                                <span class="material-symbols-rounded text-xl mr-2">perm_identity</span>
                                <span>Authorize & Store Profile</span>
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
