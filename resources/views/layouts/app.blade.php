<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RegistryCore') }} | Admin Panel</title>

        <script>
            // Script optimizado para detectar y aplicar tema sin parpadeos
            if (localStorage.getItem('theme') === 'dark' ||
                (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }

            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                }
            }
        </script>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <style>
            /* Custom Scrollbar Adaptativa */
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #f1f5f9; }
            .dark ::-webkit-scrollbar-track { background: #0f172a; }
            ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            .dark ::-webkit-scrollbar-thumb { background: #334155; }
            ::-webkit-scrollbar-thumb:hover { background: #FF8000; }

            /* DataTables Custom - Orange Core */
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #FF8000 !important;
                color: white !important;
                border: none !important;
                border-radius: 12px !important;
                box-shadow: 0 4px 12px rgba(255, 128, 0, 0.3);
                font-weight: 800;
            }

            /* Fixes para DataTables en Modo Oscuro */
            .dark .dataTables_wrapper { color: #94a3b8; }
            .dark .dataTables_length select,
            .dark .dataTables_filter input {
                background-color: #1e293b;
                color: white;
                border: 1px solid #334155;
                border-radius: 10px;
                padding: 4px 10px;
            }
            .dark table.dataTable tbody tr { background-color: transparent; color: #e2e8f0; }
            .dark table.dataTable border-bottom { border-bottom: 1px solid #334155 !important; }
            .dark .dataTables_info { color: #64748b; font-size: 12px; }
        </style>
    </head>
    <body class="font-sans antialiased text-slate-900 dark:text-slate-100 bg-[#f8fafc] dark:bg-slate-950 transition-colors duration-500">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl sticky top-0 z-30 border-b border-slate-100 dark:border-slate-800 shadow-sm transition-colors duration-500">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-4">

                {{-- Error Alert --}}
                @if ($errors->any())
                    <div class="bg-rose-50 dark:bg-rose-950/20 border-l-4 border-rose-500 p-4 rounded-2xl shadow-xl shadow-rose-100 dark:shadow-none flex items-start animate-fade-in transition-colors">
                        <div class="bg-rose-500 p-2 rounded-xl mr-4 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-black text-rose-800 dark:text-rose-400 uppercase text-[10px] tracking-widest mb-1">Error de Validación</h3>
                            <ul class="text-xs text-rose-600 dark:text-rose-300/70 font-bold">
                                @foreach ($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Success Alert - Adaptado para Dark --}}
                @if (session('success'))
                    <div id="alert-success" class="bg-emerald-500 dark:bg-emerald-600 border-b-4 border-emerald-700 dark:border-emerald-800 p-5 rounded-[2rem] shadow-2xl shadow-emerald-200 dark:shadow-none flex items-center justify-between text-white transition-all transform hover:scale-[1.01]">
                        <div class="flex items-center">
                            <div class="bg-white/20 p-3 rounded-2xl mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-black uppercase tracking-tighter text-lg leading-none">Confirmado</p>
                                <p class="text-sm text-emerald-50 dark:text-emerald-100 font-medium opacity-90">{{ session('success') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="hover:bg-white/10 p-2 rounded-xl transition-colors font-bold text-2xl px-4">&times;</button>
                    </div>
                @endif

                {{-- Delete Alert - Adaptado para Dark --}}
                @if (session('delete'))
                    <div id="alert-delete" class="bg-slate-900 dark:bg-slate-900 border-l-4 border-rose-500 p-5 rounded-2xl shadow-2xl shadow-slate-200 dark:shadow-none flex items-center justify-between text-white border border-slate-800">
                        <div class="flex items-center">
                            <div class="bg-rose-500/20 p-3 rounded-2xl mr-4">
                                <span class="text-2xl">🗑️</span>
                            </div>
                            <div>
                                <p class="font-black uppercase tracking-widest text-[10px] text-rose-400 mb-1">Sistema de Purga</p>
                                <p class="text-sm font-bold text-slate-300">{{ session('delete') }}</p>
                            </div>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-slate-500 hover:text-white transition-colors text-2xl px-2">&times;</button>
                    </div>
                @endif
            </div>

            <main class="relative">
                {{ $slot }}
            </main>
        </div>

        <footer class="py-10 text-center">
            <p class="text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} {{ config('app.name') }} — Core System for Personnel Management
            </p>
        </footer>

        <script>
            // Auto-hide alerts con fade suave
            $(document).ready(function() {
                setTimeout(() => {
                    $('#alert-success, #alert-delete').fadeOut(800);
                }, 5000);
            });
        </script>
    </body>
</html>
