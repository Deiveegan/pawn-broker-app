<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pawn Broker') }}</title>

        <!-- Google Fonts - Roboto (Material Design) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Roboto+Mono:wght@400;500&display=swap" rel="stylesheet">
        
        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * {
                font-family: 'Roboto', sans-serif;
            }
            
            /* Material Design 3 Color Palette */
            :root {
                --md-primary: #1976D2;
                --md-primary-dark: #1565C0;
                --md-primary-light: #42A5F5;
                --md-secondary: #26A69A;
                --md-secondary-dark: #00897B;
                --md-accent: #FF4081;
                --md-error: #F44336;
                --md-success: #4CAF50;
                --md-warning: #FF9800;
                --md-surface: #FFFFFF;
                --md-background: #F5F5F5;
                --md-on-primary: #FFFFFF;
                --md-on-surface: #212121;
                --md-outline: #E0E0E0;
            }

            /* Material Elevation Shadows */
            .elevation-1 {
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
            }
            .elevation-2 {
                box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
            }
            .elevation-3 {
                box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
            }
            .elevation-4 {
                box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
            }

            /* Material Ripple Effect */
            .ripple {
                position: relative;
                overflow: hidden;
            }
            .ripple:after {
                content: "";
                display: block;
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                pointer-events: none;
                background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
                background-repeat: no-repeat;
                background-position: 50%;
                transform: scale(10, 10);
                opacity: 0;
                transition: transform .5s, opacity 1s;
            }
            .ripple:active:after {
                transform: scale(0, 0);
                opacity: .3;
                transition: 0s;
            }

            /* Material Button Styles */
            .md-button {
                font-weight: 500;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Material Card */
            .md-card {
                background: white;
                border-radius: 12px;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .md-card:hover {
                transform: translateY(-2px);
            }

            /* Material Input */
            .md-input {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            .md-input:focus {
                outline: none;
                border-color: var(--md-primary);
            }
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
            <div class="fixed bottom-6 right-6 z-50 animate-slide-up">
                <div class="md-card elevation-3 bg-green-50 border-l-4 border-green-500 p-4 flex items-center space-x-3 max-w-md">
                    <span class="material-icons text-green-600">check_circle</span>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="fixed bottom-6 right-6 z-50 animate-slide-up">
                <div class="md-card elevation-3 bg-red-50 border-l-4 border-red-500 p-4 flex items-center space-x-3 max-w-md">
                    <span class="material-icons text-red-600">error</span>
                    <p class="text-red-800 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

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
