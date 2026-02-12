<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8fafc] relative overflow-hidden">

            <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
                <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-indigo-50/50 blur-[120px]"></div>
                <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] rounded-full bg-emerald-50/50 blur-[120px]"></div>
            </div>

            <div class="transition-transform duration-500 hover:scale-110 drop-shadow-2xl mb-4">
                <a href="/">
                    @if(file_exists(public_path('logo1.png')))
                        <img src="{{ asset('logo1.png') }}" alt="Logo" class="w-24 h-24 object-contain">
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-indigo-600" />
                    @endif
                </a>
            </div>

            <div class="mb-6 text-center">
                <h1 class="text-3xl font-black text-slate-800 tracking-tighter uppercase italic">
                    Registry<span class="text-indigo-600">Core</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.4em] mt-1">Sistemas de Gestión de Personal</p>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-8 py-10 bg-white/80 backdrop-blur-xl shadow-[0_20px_50px_rgba(0,0,0,0.05)] border border-white overflow-hidden sm:rounded-[3rem] relative">

                {{-- Brillo sutil superior --}}
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-indigo-500/20 to-transparent"></div>

                <div class="relative z-10">
                    {{ $slot }}
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                    &copy; {{ date('Y') }} — Acceso Restringido para Personal Autorizado
                </p>
            </div>
        </div>
    </body>
</html>
