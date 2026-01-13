<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pawn Broker') }}</title>

        <!-- Google Fonts - Inter & Playfair Display -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        <style>
            :root {
                /* Premium Professional Palette */
                --brand-primary: #4338ca; /* Indigo 700 */
                --brand-accent: #2563EB;  /* Blue 600 */
                --brand-success: #059669; /* Emerald 600 */
                --brand-error: #DC2626;   /* Red 600 */
                --brand-warning: #D97706; /* Amber 600 */
                --bg-main: #F8FAFC;       /* Slate 50 */
                --border-dim: #E2E8F0;    /* Slate 200 */
                --text-main: #1E293B;     /* Slate 800 */
                --text-muted: #64748B;    /* Slate 500 */
            }

            * {
                font-family: 'Inter', sans-serif;
                -webkit-font-smoothing: antialiased;
            }

            h1, h2, h3, h4, h5, h6, .font-heading {
                font-family: 'Outfit', sans-serif;
            }
            
            body {
                background-color: var(--bg-main);
                color: var(--text-main);
            }

            .bg-indigo-700 { background-color: #4338ca !important; color-adjust: exact; }

            .font-black { font-weight: 900; }
            .letter-spacing-tightest { letter-spacing: -0.05em; }

            /* Custom Utilities */
            .glass {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.3);
            }

            .premium-shadow {
                box-shadow: 0 20px 50px -12px rgba(15, 23, 42, 0.08);
            }

            .elevation-1 { box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
            .elevation-2 { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
            .elevation-3 { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.08); }

            /* Premium Action Buttons */
            .btn-premium {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.75rem 1.75rem;
                font-family: 'Outfit', sans-serif;
                font-size: 11px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                border-radius: 1rem;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                overflow: hidden;
                cursor: pointer;
                border: none;
                text-decoration: none;
            }

            .btn-premium:active {
                transform: scale(0.96);
            }

            .btn-premium-primary {
                background: #4338ca;
                color: #ffffff;
                box-shadow: 0 10px 20px -5px rgba(67, 56, 202, 0.2);
                border: 1px solid #4f46e5;
            }

            .btn-premium-primary:hover {
                background: #3730a3;
                transform: translateY(-2px);
                box-shadow: 0 15px 25px -5px rgba(67, 56, 202, 0.3);
            }

            .btn-premium-secondary {
                background: #ffffff;
                color: #0f172a;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            }

            .btn-premium-secondary:hover {
                background: #f8fafc;
                border-color: #cbd5e1;
                transform: translateY(-2px);
            }

            .btn-premium-danger {
                background: #e11d48;
                color: #ffffff;
                box-shadow: 0 10px 20px -5px rgba(225, 29, 72, 0.2);
            }

            .btn-premium-danger:hover {
                background: #be123c;
                transform: translateY(-2px);
                box-shadow: 0 15px 25px -5px rgba(225, 29, 72, 0.3);
            }

            .btn-premium-success {
                background: #059669;
                color: #ffffff;
                box-shadow: 0 10px 20px -5px rgba(5, 150, 105, 0.2);
            }

            .btn-premium-success:hover {
                background: #047857;
                transform: translateY(-2px);
                box-shadow: 0 15px 25px -5px rgba(5, 150, 105, 0.3);
            }

            .btn-premium::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                    120deg,
                    transparent,
                    rgba(255, 255, 255, 0.2),
                    transparent
                );
                transition: all 0.6s;
            }

            .btn-premium:hover::before {
                left: 100%;
            }

            /* Inputs */
            .form-input {
                border: 1px solid var(--border-dim);
                border-radius: 12px;
                transition: all 0.2s;
            }
            .form-input:focus {
                border-color: var(--brand-accent);
                ring: 2px solid rgba(37, 99, 235, 0.1);
            }

            /* Layout navigation customize */
            nav {
                border-bottom: 1px solid var(--border-dim);
                background: white;
            }

            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white elevation-1">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-12">
                {{ $slot }}
            </main>
        </div>

        <!-- Success/Error Messages with Premium Design -->
        @if(session('success'))
            <div id="flash-message" class="fixed bottom-10 right-10 z-50 animate-slide-up">
                <div class="bg-white premium-shadow border border-emerald-100 rounded-[2rem] p-6 flex items-center justify-between space-x-6 max-w-md relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-50 rounded-full blur-xl group-hover:bg-emerald-100 transition-colors"></div>
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-rounded text-2xl">verified</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 font-heading">Success</p>
                            <p class="text-slate-900 font-bold text-sm font-heading">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button onclick="dismissFlash()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-700 hover:text-white transition-all flex items-center justify-center relative z-10">
                        <span class="material-symbols-rounded text-sm">close</span>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-message" class="fixed bottom-10 right-10 z-50 animate-slide-up">
                <div class="bg-white premium-shadow border border-rose-100 rounded-[2rem] p-6 flex items-center justify-between space-x-6 max-w-md relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-50 rounded-full blur-xl group-hover:bg-rose-100 transition-colors"></div>
                    <div class="flex items-center space-x-4 relative z-10">
                        <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-rounded text-2xl">report</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1 font-heading">Error</p>
                            <p class="text-slate-900 font-bold text-sm font-heading">{{ session('error') }}</p>
                        </div>
                    </div>
                    <button onclick="dismissFlash()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:bg-indigo-700 hover:text-white transition-all flex items-center justify-center relative z-10">
                        <span class="material-symbols-rounded text-sm">close</span>
                    </button>
                </div>
            </div>
        @endif

        <script>
            function dismissFlash() {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    flash.style.opacity = '0';
                    flash.style.transform = 'translateY(20px)';
                    flash.style.transition = 'all 0.5s ease';
                    setTimeout(() => flash.remove(), 500);
                }
            }

            // Auto-dismiss after 5 seconds
            document.addEventListener('DOMContentLoaded', () => {
                if (document.getElementById('flash-message')) {
                    setTimeout(dismissFlash, 5000);
                }
            });
        </script>

        <style>
            @keyframes slide-up {
                from {
                    transform: translateY(100px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
            .animate-slide-up {
                animation: slide-up 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
        </style>
    </body>
</html>
