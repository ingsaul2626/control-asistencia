<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión de Eventos - Asistencia</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-zinc-900 antialiased font-sans">

    <header class="sticky top-0 z-50 w-full border-b shadow-xl border border-gray-100  border-zinc-100 bg-white/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-orange-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 27" stroke-width="1.5" stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                        </svg>

                </div>
                <span class="text-xl font-bold tracking-tight text-zinc-900">Ingenieria<span class="text-blue-600">UPTAG</span></span>
            </div>

            <nav class="flex items-center gap-6">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-semibold px-5 py-2.5 bg-zinc-900 text-white rounded-xl transition hover:bg-zinc-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold px-5 py-2.5 border border-zinc-200 rounded-xl hover:bg-zinc-50 transition text-zinc-900">Entrar</a>

               @if (Route::has('register'))
                            <a href="{{ route('register') }}" >Crear cuenta</a>
                        @endif


                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-16">
        <div class="max-w-3xl mb-16">
            <h1 class="text-5xl font-black text-zinc-900 mb-6 tracking-tighter">Panel de Proyectos</h1>
            <p class="text-xl text-zinc-500 leading-relaxed">Gestión centralizada de eventos y asignación de personal operativo en tiempo real.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($eventos as $evento)
                <article class="group bg-white border border-zinc-100 rounded-3xl overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-2xl hover:shadow-indigo-500/5">

                    <div class="aspect-[16/10] w-full overflow-hidden bg-zinc-50 relative">
                        @if($evento->imagen)
                            <img src="{{ asset('storage/' . $evento->imagen) }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition duration-700 group-hover:scale-105" alt="{{ $evento->titulo }}">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="w-16 h-16 text-zinc-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <div class="absolute bottom-4 left-4">
                            <span class="px-4 py-1.5 bg-white shadow-xl text-[12px] font-bold uppercase tracking-widest rounded-full text-zinc-900">
                                {{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-500 bg-indigo-50 px-2 py-0.5 rounded">
                                {{ $evento->lugar ?? 'Local' }}
                            </span>
                        </div>

                        <h3 class="text-2xl font-bold text-zinc-900 mb-3 tracking-tight group-hover:text-indigo-600 transition-colors">
                            {{ $evento->titulo }}
                        </h3>



                        <div class="flex items-center gap-4 pt-6 border-t border-zinc-50">
                            <div class="w-12 h-12 rounded-2xl bg-zinc-900 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-zinc-200">
                                {{ strtoupper(substr($evento->user->name ?? '?', 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">Responsable</h4>
                                <p class="text-base font-bold text-zinc-900">{{ $evento->user->name ?? 'Pendiente' }}</p>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center border-2 border-dashed border-zinc-100 rounded-[40px]">
                    <div class="w-20 h-20 bg-zinc-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900">Sin eventos próximos</h3>
                    <p class="text-zinc-400 mt-2">La agenda está limpia por ahora.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="mt-20 py-12 border-t border-zinc-100">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-sm font-medium text-zinc-400">© 2026 Sistema de Asistencia Técnica</p>
            <div class="flex gap-8">
                <span class="text-xs font-bold uppercase tracking-widest text-zinc-300">Privacidad</span>
                <span class="text-xs font-bold uppercase tracking-widest text-zinc-300">Soporte</span>
            </div>
        </div>
    </footer>
</body>
</html>
