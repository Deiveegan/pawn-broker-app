<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-center text-sm font-bold text-green-600" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Admin Identity</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600 text-gray-400">
                    <span class="material-icons text-lg">alternate_email</span>
                </div>
                <input id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    class="block w-full pl-12 pr-4 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-50/50 rounded-2xl text-sm font-bold text-gray-900 transition-all placeholder:text-gray-300"
                    placeholder="Enter your email"
                >
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2 ml-1">
                <label for="password" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none">Access Key</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-800 transition-colors">Forgot?</a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600 text-gray-400">
                    <span class="material-icons text-lg">lock</span>
                </div>
                <input id="password" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    class="block w-full pl-12 pr-4 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-blue-600 focus:ring-4 focus:ring-blue-50/50 rounded-2xl text-sm font-bold text-gray-900 transition-all placeholder:text-gray-300"
                    placeholder="••••••••"
                >
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-lg border-gray-200 text-blue-600 shadow-sm focus:ring-0 focus:ring-offset-0 transition-all cursor-pointer" name="remember">
                <span class="ms-3 text-[11px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-gray-700 transition-colors">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black text-xs uppercase tracking-[0.2em] py-5 rounded-2xl shadow-xl shadow-blue-200 transform active:scale-95 transition-all flex items-center justify-center space-x-2">
                <span>Authorize Login</span>
                <span class="material-icons text-sm">login</span>
            </button>
        </div>

        <div class="flex items-center space-x-4 pt-4">
            <div class="h-px flex-1 bg-gray-100"></div>
            <span class="text-[9px] font-black text-gray-300 uppercase tracking-widest">End-to-End Encrypted</span>
            <div class="h-px flex-1 bg-gray-100"></div>
        </div>
    </form>
</x-guest-layout>
