<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingeniería UPTAG | Gestión de Proyectos</title>
    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fcfdfe] text-slate-900 antialiased font-sans">

    <header class="sticky top-0 z-50 w-full bg-white/70 backdrop-blur-xl border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 transition-transform group-hover:rotate-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter uppercase italic text-slate-800">
                    Ingeniería<span class="text-indigo-600 font-extrabold not-italic">UPTAG</span>
                </span>
            </div>

            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 bg-slate-900 text-white rounded-2xl transition-all hover:bg-indigo-600 hover:shadow-xl hover:shadow-indigo-100 active:scale-95">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 text-slate-600 hover:text-indigo-600 transition-colors">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 bg-indigo-600 text-white rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">Comenzar</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6">

        <section class="py-20 lg:py-32 relative">
            <div class="absolute top-0 -left-20 w-72 h-72 bg-indigo-100 rounded-full blur-[120px] opacity-50 -z-10"></div>
            <div class="max-w-4xl">
                <span class="inline-block px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
                    Módulo de Operaciones v2.0
                </span>
                <h1 class="text-6xl lg:text-8xl font-black text-slate-900 mb-8 tracking-tighter leading-[0.9]">
                    Control de Proyectos <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-400">&</span> Asistencia.
                </h1>
                <p class="text-lg lg:text-xl text-slate-500 max-w-2xl font-medium leading-relaxed">
                    Plataforma técnica para la supervisión centralizada de eventos, despliegue de personal operativo y métricas de rendimiento en tiempo real.
                </p>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-20">
            @forelse($eventos as $evento)
                <article class="group relative bg-white border border-slate-100 rounded-[2.5rem] p-3 transition-all duration-500 hover:shadow-[0_40px_80px_-20px_rgba(79,70,229,0.15)] hover:-translate-y-2">

                    {{-- Badge de Fecha Superior --}}
                    <div class="absolute top-6 right-6 z-10">
                        <div class="px-4 py-2 bg-white/90 backdrop-blur-md shadow-sm rounded-2xl text-center">
                            <span class="block text-xs font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($evento->fecha)->format('d') }}</span>
                            <span class="block text-[8px] font-bold text-indigo-500 uppercase tracking-widest">{{ \Carbon\Carbon::parse($evento->fecha)->format('M') }}</span>
                        </div>
                    </div>

                    {{-- Contenedor de Imagen --}}
                    <div class="aspect-[16/11] w-full overflow-hidden rounded-[2rem] bg-slate-100 relative mb-6">
                        @if($evento->imagen)
                            <img src="{{ asset('storage/' . $evento->imagen) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $evento->titulo }}">
                        @else
                            <div class="flex items-center justify-center h-full bg-gradient-to-br from-slate-50 to-slate-100">
                                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </div>

                    {{-- Contenido --}}
                    <div class="px-5 pb-6">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="h-1.5 w-1.5 rounded-full bg-indigo-500 animate-pulse"></div>
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400">
                                {{ $evento->lugar ?? 'Campo Tecnológico' }}
                            </span>
                        </div>

                        <h3 class="text-2xl font-extrabold text-slate-800 mb-6 tracking-tight group-hover:text-indigo-600 transition-colors line-clamp-2">
                            {{ $evento->titulo }}
                        </h3>

                        {{-- Footer de la Tarjeta --}}
                        <div class="flex items-center justify-between pt-5 border-t border-slate-50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-[10px] font-black shadow-inner">
                                    {{ strtoupper(substr($evento->user->name ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-[8px] font-black text-slate-400 uppercase tracking-[0.2em] leading-none mb-1">Responsable</h4>
                                    <p class="text-xs font-bold text-slate-700">{{ $evento->user->name ?? 'Por asignar' }}</p>
                                </div>
                            </div>

                            <div class="w-8 h-8 rounded-full border border-slate-100 flex items-center justify-center text-slate-300 group-hover:border-indigo-100 group-hover:text-indigo-500 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center bg-white border border-dashed border-slate-200 rounded-[3rem]">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Agenda Vacía</h3>
                    <p class="text-slate-400 font-medium mt-2">No se han registrado proyectos activos en el sistema.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-slate-900 py-16 mt-20">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex flex-col items-center md:items-start">
                <span class="text-lg font-black text-white tracking-tighter uppercase italic mb-2">
                    Ingeniería<span class="text-indigo-400">UPTAG</span>
                </span>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">© 2026 Core Operations System</p>
            </div>

            <div class="flex gap-10">
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Infraestructura</a>
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Seguridad</a>
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Soporte IT</a>
            </div>
        </div>
    </footer>

</body>
</html>
