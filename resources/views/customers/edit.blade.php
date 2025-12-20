<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <a href="{{ route('customers.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-all">
                <span class="material-icons text-gray-600">arrow_back</span>
            </a>
            <span class="material-icons text-blue-600 text-3xl">edit</span>
            <h2 class="font-semibold text-2xl text-gray-800">
                {{ __('Edit Customer') }}: {{ $customer->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="md-card elevation-2">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                    <h3 class="text-xl font-semibold text-white">Modify Information</h3>
                    <p class="text-blue-100 text-sm mt-1">Update customer details below</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('customers.update', $customer) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- Section 1 -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">1</span>
                                Personal Information
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative">
                                    <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Full Name">
                                    <label for="name" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    @error('name')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <input type="text" name="mobile" id="mobile" value="{{ old('mobile', $customer->mobile) }}" required maxlength="10"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Mobile Number">
                                    <label for="mobile" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Mobile Number <span class="text-red-500">*</span>
                                    </label>
                                    @error('mobile')
                                        <p class="mt-1.5 text-sm text-red-600 flex items-center"><span class="material-icons text-xs mr-1">error</span>{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative md:col-span-2">
                                    <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}"
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="Email Address">
                                    <label for="email" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Email Address (Optional)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2 -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">2</span>
                                Identity Verification
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="relative">
                                    <select name="id_proof_type" id="id_proof_type" required
                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors appearance-none bg-white">
                                        <option value="">Select ID Type</option>
                                        <option value="Aadhaar" {{ old('id_proof_type', $customer->id_proof_type) == 'Aadhaar' ? 'selected' : '' }}>Aadhaar Card</option>
                                        <option value="PAN" {{ old('id_proof_type', $customer->id_proof_type) == 'PAN' ? 'selected' : '' }}>PAN Card</option>
                                        <option value="Driving License" {{ old('id_proof_type', $customer->id_proof_type) == 'Driving License' ? 'selected' : '' }}>Driving License</option>
                                        <option value="Voter ID" {{ old('id_proof_type', $customer->id_proof_type) == 'Voter ID' ? 'selected' : '' }}>Voter ID</option>
                                    </select>
                                    <label for="id_proof_type" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-blue-600">
                                        ID Proof Type <span class="text-red-500">*</span>
                                    </label>
                                    <span class="material-icons absolute right-3 top-4 text-gray-400 pointer-events-none">expand_more</span>
                                </div>

                                <div class="relative">
                                    <input type="text" name="id_proof_number" id="id_proof_number" value="{{ old('id_proof_number', $customer->id_proof_number) }}" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                        placeholder="ID Number">
                                    <label for="id_proof_number" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        ID Number <span class="text-red-500">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3 -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">3</span>
                                Address Details
                            </h4>
                            <div class="space-y-6">
                                <div class="relative">
                                    <textarea name="address" id="address" rows="3" required
                                        class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent resize-none"
                                        placeholder="Address">{{ old('address', $customer->address) }}</textarea>
                                    <label for="address" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                        Full Address <span class="text-red-500">*</span>
                                    </label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="relative">
                                        <input type="text" name="city" id="city" value="{{ old('city', $customer->city) }}" required
                                            class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                            placeholder="City">
                                        <label for="city" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                            City <span class="text-red-500">*</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="text" name="state" id="state" value="{{ old('state', $customer->state) }}" required
                                            class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                            placeholder="State">
                                        <label for="state" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                            State <span class="text-red-500">*</span>
                                        </label>
                                    </div>
                                    <div class="relative">
                                        <input type="text" name="pincode" id="pincode" value="{{ old('pincode', $customer->pincode) }}" required maxlength="6"
                                            class="peer md-input w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:outline-none transition-colors placeholder-transparent"
                                            placeholder="Pincode">
                                        <label for="pincode" class="absolute left-3 -top-2.5 bg-white px-2 text-sm font-medium text-gray-600 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-2.5 peer-focus:text-sm peer-focus:text-blue-600">
                                            Pincode <span class="text-red-500">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4 -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-6 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-8 h-8 flex items-center justify-center mr-3 text-sm font-bold">4</span>
                                Profile Photo
                            </h4>
                            <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6">
                                @if($customer->photo)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($customer->photo) }}" alt="Customer Photo" class="w-24 h-24 rounded-full object-cover elevation-1 border-2 border-blue-100">
                                        <div class="absolute inset-0 bg-black/40 rounded-full opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                            <span class="material-icons text-white text-sm">visibility</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="w-24 h-24 rounded-full bg-blue-50 flex items-center justify-center border-2 border-dashed border-blue-200">
                                        <span class="material-icons text-blue-200 text-4xl">person</span>
                                    </div>
                                @endif
                                <div class="flex-1 w-full">
                                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-blue-50/50 hover:border-blue-400 transition-all group">
                                        <div class="flex flex-col items-center justify-center pt-2 pb-2">
                                            <span class="material-icons text-gray-400 group-hover:text-blue-500 text-2xl mb-1 transition-colors">cloud_upload</span>
                                            <p class="text-sm text-gray-600">Update photo (MAX. 2MB)</p>
                                        </div>
                                        <input type="file" name="photo" id="photo" accept="image/*" class="hidden" onchange="showFileName(this)">
                                    </label>
                                    <p id="file-name" class="mt-2 text-sm text-blue-600 font-medium hidden flex items-center">
                                        <span class="material-icons text-sm mr-1">attach_file</span>
                                        <span id="file-name-text"></span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end space-x-4 pt-8 border-t border-gray-100">
                            <a href="{{ route('customers.index') }}" 
                                class="px-6 py-3 text-gray-700 font-medium rounded-lg hover:bg-gray-100 transition-all">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-10 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg elevation-2 hover:elevation-3 transition-all ripple">
                                <div class="flex items-center">
                                    <span class="material-icons mr-2">save</span>
                                    Update Customer
                                </div>
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
</x-app-layout>
