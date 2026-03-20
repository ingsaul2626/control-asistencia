<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Reportes de Avance Técnico') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($reportes as $reporte)
                    {{-- Cambio: Borde lateral uptag-orange y sombra sutil --}}
                    <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/50 rounded-[2rem] border-l-[6px] border-uptag-orange p-8 transition-transform hover:scale-[1.01]">
                        <div class="flex justify-between items-start mb-4">
                            {{-- Cambio: Título en naranja oscuro --}}
                            <h3 class="font-black text-xl text-orange-950 tracking-tight leading-tight">{{ $reporte->titulo }}</h3>
                            <span class="text-[10px] font-bold bg-slate-100 px-3 py-1 rounded-full text-slate-500 uppercase tracking-wider">
                                {{ $reporte->updated_at->diffForHumans() }}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mb-6 flex items-center gap-2">
                            <span class="opacity-60 text-xs font-bold uppercase tracking-widest">Enviado por:</span>
                            <strong class="text-slate-700 font-black tracking-tight">{{ $reporte->user->name }}</strong>
                        </p>

                        {{-- Cambio: Caja de reporte con fondo crema/naranja muy suave --}}
                        <div class="bg-orange-50/50 p-5 rounded-2xl border border-orange-100/50 relative">
                            <svg class="absolute top-2 left-2 w-6 h-6 text-orange-200 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C14.9124 8 14.017 7.10457 14.017 6V5C14.017 3.89543 14.9124 3 16.017 3H19.017C21.2261 3 23.017 4.79086 23.017 7V15C23.017 17.2091 21.2261 19 19.017 19H17.017L14.017 21ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H3.017C1.91243 8 1.017 7.10457 1.017 6V5C1.017 3.89543 1.91243 3 3.017 3H6.017C8.22614 3 10.017 4.79086 10.017 7V15C10.017 17.2091 8.22614 19 6.017 19H4.017L1.017 21Z" /></svg>
                            <p class="text-slate-700 italic relative z-10 pl-6 leading-relaxed">"{{ $reporte->reporte_trabajador }}"</p>
                        </div>

                        <div class="mt-6 flex justify-end">
                            {{-- Cambio: Enlace en uptag-orange con efecto hover --}}
                            <a href="{{ route('admin.proyectos.show', $reporte->id) }}" class="group flex items-center gap-2 text-uptag-orange text-xs font-black uppercase tracking-widest hover:text-orange-700 transition-colors">
                                Ver detalles del proyecto
                                <span class="group-hover:translate-x-1 transition-transform">&rarr;</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-16 text-center rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <p class="text-slate-500 font-medium italic">No hay reportes técnicos enviados todavía.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
