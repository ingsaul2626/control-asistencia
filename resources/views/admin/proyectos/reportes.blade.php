<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight transition-colors">
            {{ __('Reportes de Avance Técnico') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($reportes as $reporte)
                    {{-- Tarjeta con borde lateral UPTAG-orange --}}
                    <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/50 dark:shadow-none rounded-[2rem] border-l-[6px] border-uptag-orange p-8 transition-all hover:scale-[1.01] border-y border-r dark:border-y-slate-800 dark:border-r-slate-800">
                        <div class="flex justify-between items-start mb-6">
                            {{-- Título adaptativo --}}
                            <h3 class="font-black text-xl text-orange-950 dark:text-orange-500 tracking-tight leading-tight transition-colors">{{ $reporte->titulo }}</h3>
                            <span class="text-[10px] font-bold bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full text-slate-500 dark:text-slate-400 uppercase tracking-wider transition-colors">
                                {{ $reporte->updated_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 flex items-center gap-2 transition-colors">
                            <span class="opacity-60 text-[10px] font-black uppercase tracking-[0.15em]">Enviado por:</span>
                            <strong class="text-slate-700 dark:text-slate-200 font-black tracking-tight">{{ $reporte->user->name }}</strong>
                        </p>

                        {{-- Caja de reporte: fondo crema suave en claro / negro profundo en oscuro --}}
                        <div class="bg-orange-50/50 dark:bg-slate-950 p-6 rounded-2xl border border-orange-100/50 dark:border-slate-800 relative group/box transition-colors">
                            <svg class="absolute top-3 left-3 w-8 h-8 text-orange-200 dark:text-orange-900/30 opacity-50 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 17.2091 21.2261 19 19.017 19H17.017L14.017 21ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H6.017C8.22614 3 10.017 4.79086 10.017 7V15C10.017 17.2091 8.22614 19 6.017 19H4.017L1.017 21Z" />
                            </svg>
                            <p class="text-slate-700 dark:text-slate-400 italic relative z-10 pl-8 leading-relaxed transition-colors">
                                "{{ $reporte->reporte_trabajador }}"
                            </p>
                        </div>

                        <div class="mt-8 flex justify-end">
                            {{-- Enlace dinámico con respuesta naranja --}}
                            <a href="{{ route('admin.proyectos.show', $reporte->id) }}" class="group flex items-center gap-3 text-uptag-orange dark:text-uptag-orange text-[10px] font-black uppercase tracking-[0.2em] hover:text-orange-600 dark:hover:text-white transition-all">
                                Ver expediente completo
                                <span class="group-hover:translate-x-2 transition-transform duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-slate-900 p-20 text-center rounded-[3rem] shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800 transition-colors">
                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300 dark:text-slate-600 transition-colors">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-bold italic tracking-tight">No hay reportes técnicos registrados en la base de datos.</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-600 uppercase mt-2 tracking-widest font-medium">Departamento de Ingeniería e Infraestructura</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
