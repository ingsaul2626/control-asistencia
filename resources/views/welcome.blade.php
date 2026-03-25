<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingeniería UPTAG | Gestión de Proyectos</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,800,900" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-[#fcfdfe] dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased font-sans transition-colors duration-500">

    <header class="sticky top-0 z-50 w-full bg-white/70 dark:bg-slate-950/70 backdrop-blur-xl border-b border-slate-100 dark:border-slate-900">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3 group">
                <div class="w-11 h-11 bg-uptag-orange rounded-2xl flex items-center justify-center shadow-lg shadow-orange-200 dark:shadow-none transition-transform group-hover:rotate-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter uppercase italic text-slate-800 dark:text-white">
                    Ingeniería<span class="text-uptag-orange font-extrabold not-italic">UPTAG</span>
                </span>
            </div>

            <nav class="flex items-center gap-4">
                <button id="theme-toggle" class="mr-2 p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 text-slate-500 dark:text-orange-400 border border-slate-100 dark:border-slate-800 hover:scale-110 transition-all active:scale-95 shadow-sm">
                    <svg id="theme-toggle-light-icon" class="hidden size-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z"></path>
                    </svg>
                    <svg id="theme-toggle-dark-icon" class="hidden size-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 bg-slate-900 dark:bg-orange-600 text-white rounded-2xl transition-all hover:bg-uptag-orange dark:hover:bg-orange-500 hover:shadow-xl hover:shadow-orange-100 dark:hover:shadow-none active:scale-95">Inicio</a>
                    @else
                        <a href="{{ route('login') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 text-slate-600 dark:text-slate-400 hover:text-uptag-orange dark:hover:text-orange-500 transition-colors">Entrar</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-[11px] font-black uppercase tracking-widest px-6 py-3 bg-uptag-orange text-white rounded-2xl shadow-lg shadow-orange-100 dark:shadow-none hover:bg-orange-600 transition-all active:scale-95">Comenzar</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6">
        <section class="py-20 lg:py-32 relative">
            <div class="absolute top-0 -left-20 w-72 h-72 bg-orange-100 dark:bg-orange-600/10 rounded-full blur-[120px] opacity-50 -z-10"></div>
            <div class="max-w-4xl">
                <span class="inline-block px-4 py-1.5 bg-orange-50 dark:bg-orange-500/10 text-uptag-orange text-[10px] font-black uppercase tracking-[0.3em] rounded-full mb-6">
                    Módulo de Operaciones v2.0
                </span>
                <h1 class="text-6xl lg:text-8xl font-black text-slate-900 dark:text-white mb-8 tracking-tighter leading-[0.9]">
                    Control de Proyectos <span class="text-transparent bg-clip-text bg-gradient-to-r from-uptag-orange to-orange-400">&</span> Asistencia.
                </h1>
                <p class="text-lg lg:text-xl text-slate-500 dark:text-slate-400 max-w-2xl font-medium leading-relaxed">
                    Plataforma técnica para la supervisión centralizada de proyectos, despliegue de personal operativo y métricas de rendimiento en tiempo real.
                </p>
            </div>
        </section>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-20">
            @forelse($proyectos as $proyecto)
                <article class="group relative bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] p-3 transition-all duration-500 hover:shadow-[0_40px_80px_-20px_rgba(241,128,0,0.15)] dark:hover:shadow-none hover:-translate-y-2 dark:hover:border-slate-700">
                    <a href="{{ route('admin.proyectos.show', $proyecto->id) }}" class="block">
                        <div class="absolute top-6 right-6 z-10">
                            <div class="px-4 py-2 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md shadow-sm dark:shadow-none border border-transparent dark:border-slate-800 rounded-2xl text-center">
                                <span class="block text-xs font-black text-slate-800 dark:text-white leading-none">{{ \Carbon\Carbon::parse($proyecto->fecha)->format('d') }}</span>
                                <span class="block text-[8px] font-bold text-uptag-orange uppercase tracking-widest">{{ \Carbon\Carbon::parse($proyecto->fecha)->format('M') }}</span>
                            </div>
                        </div>

                        <div class="aspect-[16/11] w-full overflow-hidden rounded-[2rem] bg-slate-100 dark:bg-slate-800 relative mb-6">
                            @if($proyecto->imagen)
                                <img src="{{ asset('storage/' . $proyecto->imagen) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110 opacity-90 group-hover:opacity-100" alt="{{ $proyecto->titulo }}">
                            @else
                                <div class="flex items-center justify-center h-full bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900">
                                    <svg class="w-12 h-12 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="px-5 pb-2">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="h-1.5 w-1.5 rounded-full bg-uptag-orange animate-pulse"></div>
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 dark:text-slate-500">
                                    {{ $proyecto->lugar ?? 'Campo Tecnológico' }}
                                </span>
                            </div>
                            <h3 class="text-2xl font-extrabold text-slate-800 dark:text-white mb-6 tracking-tight group-hover:text-uptag-orange transition-colors line-clamp-2 uppercase italic">
                                {{ $proyecto->titulo }}
                            </h3>
                        </div>
                    </a>

                    <div class="px-5 pb-6">
                        <div class="flex items-center justify-between pt-5 border-t border-slate-50 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-500 text-[10px] font-black shadow-inner">
                                    {{ strtoupper(substr($proyecto->user->name ?? '?', 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-[8px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.2em] leading-none mb-1">Responsable</h4>
                                    <p class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $proyecto->user->name ?? 'Por asignar' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.proyectos.show', $proyecto->id) }}" class="w-8 h-8 rounded-full border border-slate-100 dark:border-slate-800 flex items-center justify-center text-slate-300 dark:text-slate-600 hover:scale-110 group-hover:border-orange-100 dark:group-hover:border-orange-500/30 group-hover:text-uptag-orange transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center bg-white dark:bg-slate-900 border border-dashed border-slate-200 dark:border-slate-800 rounded-[3rem]">
                    <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter">Agenda Vacía</h3>
                    <p class="text-slate-400 dark:text-slate-500 font-medium mt-2">No se han registrado proyectos activos en el sistema.</p>
                </div>
            @endforelse
        </div>
    </main>

    <footer class="bg-slate-900 dark:bg-black py-16 mt-20 border-t border-slate-800 dark:border-slate-900">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="flex flex-col items-center md:items-start">
                <span class="text-lg font-black text-white tracking-tighter uppercase italic mb-2">
                    Ingeniería<span class="text-uptag-orange">UPTAG</span>
                </span>
                <p class="text-slate-500 dark:text-slate-600 text-xs font-bold uppercase tracking-widest">© 2026 Core Operations System</p>
            </div>
            <div class="flex gap-10">
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Infraestructura</a>
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Seguridad</a>
                <a href="#" class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-500 hover:text-white transition-colors">Soporte IT</a>
            </div>
        </div>
    </footer>

    <script>
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Cambiar iconos según el estado actual
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
        document.documentElement.classList.add('dark');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
        document.documentElement.classList.remove('dark');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function() {
        // Intercambiar iconos
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // Si ya estaba en modo oscuro
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }
        } else {
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
