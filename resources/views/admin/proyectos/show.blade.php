<x-app-layout>
    <x-slot name="header">
        <div class="max-w-5xl mx-auto px-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight transition-colors">{{ $proyecto->titulo }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Detalles técnicos y gestión de infraestructura</p>
            </div>
            <a href="{{ route('admin.panelControl') }}"
                class="bg-slate-800 dark:bg-slate-700 hover:bg-uptag-orange dark:hover:bg-uptag-orange text-white dark:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-lg shadow-slate-900/10 active:scale-95">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-5xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Columna Principal (2/3) --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- SECCIÓN: Visualización del Proyecto --}}
                <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden transition-all">
                    <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 flex items-center gap-2">
                            <svg class="w-4 h-4 text-uptag-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Visualización del Proyecto
                        </h3>
                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest italic">Render / Foto</span>
                    </div>

                    <div class="p-3 bg-slate-50 dark:bg-slate-800/50">
                        @if($proyecto->imagen)
                            <div class="relative group overflow-hidden rounded-2xl aspect-[16/9] shadow-inner border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
                                <img src="{{ asset('storage/' . $proyecto->imagen) }}"
                                     alt="Imagen de {{ $proyecto->titulo }}"
                                     class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-105">

                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                    <p class="text-white text-xs font-medium tracking-wide">Ampliación visual de la unidad de ingeniería</p>
                                </div>
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center rounded-2xl aspect-[16/9] border-2 border-dashed border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-400 dark:text-slate-600">
                                <svg class="w-20 h-20 mb-4 stroke-[0.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-bold">Sin material visual</p>
                                <p class="text-[10px] mt-1 uppercase tracking-tighter opacity-60">Actualice la galería en el panel de control</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Grid de Info y Reporte --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Info General --}}
                    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 transition-all">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Ficha Técnica</h3>
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $proyecto->activo ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400' }}">
                                {{ $proyecto->activo ? '● En Curso' : '○ Finalizado' }}
                            </span>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/10 flex items-center justify-center text-uptag-orange">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div><p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Categoría de Obra</p><p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $proyecto->tipo }}</p></div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                                <div><p class="text-[9px] text-slate-400 font-bold uppercase tracking-tighter">Fecha de Registro</p><p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $proyecto->created_at->format('d M, Y') }}</p></div>
                            </div>
                        </div>
                    </div>

                    {{-- Reporte --}}
                    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800 p-8 transition-all">
                        <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-6">Bitácora Técnica</h3>
                        <div class="bg-slate-50 dark:bg-slate-800/30 p-5 rounded-2xl border border-slate-100 dark:border-slate-800 text-sm text-slate-600 dark:text-slate-400 leading-relaxed italic relative">
                            <span class="absolute -top-3 left-4 bg-white dark:bg-slate-900 px-2 text-[10px] font-bold text-uptag-orange">Nota del sistema</span>
                            "{{ $proyecto->reporte_trabajador ?? 'El responsable no ha emitido observaciones técnicas para este registro todavía.' }}"
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Lateral (1/3) --}}
            <div class="space-y-8">
                {{-- Card Responsable --}}
                <div class="bg-slate-900 dark:bg-slate-900 rounded-[2rem] p-6 text-white relative overflow-hidden shadow-2xl shadow-orange-950/20 border border-slate-800">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-uptag-orange/20 rounded-full blur-[60px]"></div>

                    <p class="text-[9px] text-slate-500 font-black uppercase mb-5 tracking-[0.3em]">Coordinador Asignado</p>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-uptag-orange to-orange-600 rounded-2xl flex items-center justify-center shrink-0 text-lg font-black shadow-lg shadow-orange-600/30 transform hover:rotate-6 transition-transform cursor-pointer">
                            {{ substr($proyecto->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-base font-bold truncate tracking-tight">{{ $proyecto->user->name ?? 'Sin asignar' }}</p>
                            <p class="text-[10px] text-uptag-orange font-bold truncate opacity-90 uppercase tracking-tighter">{{ $proyecto->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Card Documentación --}}
                <div class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] shadow-sm border border-slate-100 dark:border-slate-800 transition-all">
                    <h3 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-8 flex items-center gap-3">
                        <svg class="w-4 h-4 text-uptag-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Expediente
                    </h3>

                    @if($proyecto->archivo)
                        <div class="group relative bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6 border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-uptag-orange dark:hover:border-uptag-orange transition-all text-center">
                            <div class="w-16 h-16 bg-rose-50 dark:bg-rose-900/20 text-rose-500 dark:text-rose-400 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm group-hover:scale-110 group-hover:-rotate-3 transition-all">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V9l-3-3V3a2 2 0 00-2-2z" />
                                </svg>
                            </div>

                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300 truncate w-full mb-1">
                                {{ basename($proyecto->archivo) }}
                            </p>
                            <p class="text-[9px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest mb-6 transition-colors group-hover:text-uptag-orange">Documento PDF</p>

                            <a href="{{ route('user.proyectos.descargar', $proyecto->id) }}"
                                class="inline-flex w-full items-center justify-center gap-3 px-6 py-3 bg-slate-900 dark:bg-uptag-orange text-white dark:text-slate-950 text-[10px] font-black rounded-xl hover:bg-uptag-orange dark:hover:bg-white transition-all shadow-xl shadow-slate-900/10 dark:shadow-orange-900/20 active:scale-95 uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Descargar Archivo
                            </a>
                        </div>
                    @else
                        <div class="text-center py-12 bg-slate-50 dark:bg-slate-800/30 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800 transition-all">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-700 mx-auto mb-3 stroke-[1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-[10px] text-slate-400 dark:text-slate-600 font-bold uppercase tracking-widest">Sin documentos técnicos</p>
                        </div>
                    @endif
                </div>

                <p class="text-[9px] text-center text-slate-400 dark:text-slate-600 font-bold uppercase tracking-[0.3em] py-4">
                    Ingeniería e Infraestructura • 2026
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
