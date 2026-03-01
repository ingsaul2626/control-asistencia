<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $evento->titulo }} | Ingeniería UPTAG</title>
    <link rel="icon" type="image/png" href="{{ asset('logo1.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#fcfdfe] text-slate-900 antialiased font-sans">

    <header class="w-full bg-white/70 backdrop-blur-xl border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 transition-transform group-hover:rotate-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter uppercase italic text-slate-800">
                    Volver<span class="text-indigo-600 font-extrabold not-italic">Inicio</span>
                </span>
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-12 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Lado Izquierdo: Imagen del Proyecto --}}
            <div class="relative group">
                <div class="absolute -inset-4 bg-indigo-500/5 rounded-[3rem] blur-2xl opacity-0 group-hover:opacity-100 transition duration-500"></div>
                <div class="relative aspect-square overflow-hidden rounded-[2.5rem] bg-slate-100 border-4 border-white shadow-2xl">
                    @if($evento->imagen)
                        <img src="{{ asset('storage/' . $evento->imagen) }}" class="w-full h-full object-cover" alt="{{ $evento->titulo }}">
                    @else
                        <div class="flex items-center justify-center h-full text-slate-300">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Lado Derecho: Información --}}
            <div class="flex flex-col">
                <span class="inline-block w-fit px-4 py-1.5 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
                    Detalles del Evento
                </span>

                <h1 class="text-4xl lg:text-5xl font-black text-slate-900 mb-4 tracking-tighter leading-tight">
                    {{ $evento->titulo }}
                </h1>

                <div class="flex items-center gap-4 mb-8">
                    <div class="flex items-center gap-2 px-3 py-1 bg-slate-100 rounded-lg">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span class="text-xs font-bold text-slate-600">{{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 px-3 py-1 bg-slate-100 rounded-lg">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span class="text-xs font-bold text-slate-600">{{ $evento->lugar ?? 'Ubicación técnica' }}</span>
                    </div>
                </div>

                <div class="bg-white border border-slate-100 rounded-[2rem] p-6 mb-8 shadow-sm">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Descripción del Proyecto</h4>
                    <p class="text-slate-600 leading-relaxed font-medium">
                        {{ $evento->descripcion ?? 'No se ha proporcionado una descripción detallada para este proyecto.' }}
                    </p>
                </div>

                {{-- Card del Encargado --}}
                <div class="flex items-center gap-4 p-4 bg-slate-900 rounded-3xl text-white shadow-xl shadow-slate-200">
                    <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-xl font-black italic">
                        {{ strtoupper(substr($evento->user->name ?? '?', 0, 2)) }}
                    </div>
                    <div>
                        <span class="block text-[9px] font-bold text-indigo-400 uppercase tracking-[0.2em]">Responsable Asignado</span>
                        <h3 class="text-lg font-bold tracking-tight">{{ $evento->user->name ?? 'Usuario no encontrado' }}</h3>
                        <p class="text-[10px] text-slate-400 font-medium italic">{{ $evento->user->cargo ?? 'Ingeniero de Operaciones' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
