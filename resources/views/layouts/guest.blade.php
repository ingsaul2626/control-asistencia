<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-slate-900 dark:text-slate-100 antialiased selection:bg-uptag-orange selection:text-white transition-colors duration-500">

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc] dark:bg-slate-950 relative overflow-hidden">

            <div class="absolute top-6 right-6 z-50">
                <button id="theme-toggle" type="button" class="group flex items-center justify-center w-10 h-10 rounded-xl bg-white/50 dark:bg-slate-900/50 backdrop-blur-md border border-slate-200 dark:border-slate-800 text-slate-500 dark:text-orange-400 hover:border-orange-500 dark:hover:border-orange-500 transition-all duration-300 shadow-sm">
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 group-hover:rotate-45 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 group-hover:-rotate-12 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
            </div>

            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-orange-50/50 dark:bg-orange-500/10 blur-[120px]"></div>
                <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-emerald-50/50 dark:bg-emerald-500/10 blur-[120px]"></div>
            </div>

            {{-- Logo --}}
            <div class="transition-transform duration-500 hover:scale-110 drop-shadow-2xl mb-4">
                <a href="/">
                    @if(file_exists(public_path('logo1.png')))
                        <img src="{{ asset('logo1.png') }}" alt="Logo" class="w-24 h-24 object-contain dark:brightness-125">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-orange-600" />
                    @endif
                </a>
            </div>

            {{-- Título --}}
            <div class="mb-6 text-center">
                <h1 class="text-3xl font-black text-slate-800 dark:text-slate-100 tracking-tighter uppercase italic">
                    Registry<span class="text-orange-600">Core</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.4em] mt-1">Sistemas de Gestión de Personal</p>
            </div>

            {{-- Card Principal --}}
            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] border border-white dark:border-slate-800 overflow-hidden sm:rounded-[3rem] relative transition-colors duration-500">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-orange-500/20 to-transparent"></div>
                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            {{-- Footer --}}
            <div class="mt-8 text-center">
                <p class="text-[9px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-widest">
                    &copy; {{ date('Y') }} — Acceso Restringido para Personal Autorizado
                </p>
            </div>
        </div>

        <script>
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            // Cambiar los iconos según el estado inicial
            if (document.documentElement.classList.contains('dark')) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }

            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {
                // Alternar iconos
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Si se estableció manualmente en localStorage
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    // Si no existe en localStorage, usar el estado actual del DOM
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        </script>
    </body>
</html>
