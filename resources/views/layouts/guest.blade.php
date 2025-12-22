<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PonNidhi') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .glass-panel {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .bg-pattern {
                background-color: #f8fafc;
                background-image: 
                    radial-gradient(at 0% 0%, hsla(210,100%,96%,1) 0, transparent 50%), 
                    radial-gradient(at 50% 0%, hsla(220,100%,92%,1) 0, transparent 50%), 
                    radial-gradient(at 100% 0%, hsla(230,100%,96%,1) 0, transparent 50%);
            }
        </style>
    </head>
    <body class="text-gray-900 antialiased bg-pattern">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-0">
            <div class="w-full sm:max-w-md">
                <div class="text-center mb-6">
                    <a href="/" class="inline-block transform hover:scale-105 transition-transform duration-300">
                        <img src="{{ asset('img/logo.png') }}" class="w-48 h-55 mx-auto" style="mix-blend-mode: multiply;" alt="PonNidhi Logo">
                    </a>
                    <!-- <h1 class="text-3xl font-black text-gray-900 -mt-4 tracking-tighter uppercase">{{ config('app.name') }}</h1> -->
                    <p class="text-blue-600 font-bold text-xs uppercase tracking-[0.2em] mt-1">Digital Pawn Ledger</p>
                </div>

                <div class="glass-panel w-full px-8 py-10 shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
                    {{ $slot }}
                </div>

                <div class="mt-8 text-center text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                    &copy; {{ date('Y') }} {{ config('app.name') }} | Secure Money Lending System
                </div>
            </div>
        </div>
    </body>
</html>
