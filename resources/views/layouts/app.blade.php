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
                --brand-primary: #0F172A; /* Slate 900 */
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

            /* Buttons */
            .btn-primary {
                background: var(--brand-primary);
                color: white;
                transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .btn-primary:hover {
                background: #1e293b;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
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

        <!-- Success/Error Messages with Material Design -->
        @if(session('success'))
            <div id="flash-message" class="fixed bottom-6 right-6 z-50 animate-slide-up">
                <div class="md-card elevation-3 bg-green-50 border-l-4 border-green-500 p-4 flex items-center justify-between space-x-4 max-w-md">
                    <div class="flex items-center space-x-3">
                        <span class="material-icons text-green-600">check_circle</span>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                    <button onclick="dismissFlash()" class="p-1 hover:bg-green-100 rounded-full transition-colors flex items-center justify-center">
                        <span class="material-icons text-sm text-green-600">close</span>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-message" class="fixed bottom-6 right-6 z-50 animate-slide-up">
                <div class="md-card elevation-3 bg-red-50 border-l-4 border-red-500 p-4 flex items-center justify-between space-x-4 max-w-md">
                    <div class="flex items-center space-x-3">
                        <span class="material-icons text-red-600">error</span>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                    <button onclick="dismissFlash()" class="p-1 hover:bg-red-100 rounded-full transition-colors flex items-center justify-center">
                        <span class="material-icons text-sm text-red-600">close</span>
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
