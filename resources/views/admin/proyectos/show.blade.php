<x-app-layout>
    <x-slot name="header">
        <div class="max-w-5xl mx-auto px-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $proyecto->titulo }}</h2>
                <p class="text-slate-500 text-xs mt-1">Detalles técnicos y gestión</p>
            </div>
            <a href="{{ route('admin.panelControl') }}"
                class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-xs font-bold transition-all">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Columna Principal (2/3) --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- NUEVO SECCIÓN: Imagen Principal del Proyecto --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    {{-- Cabecera sutil de la sección --}}
                    <div class="px-6 py-4 border-b border-slate-100">
                        <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Visualización del Proyecto
                        </h3>
                    </div>

                    {{-- Contenedor de la imagen --}}
                    <div class="p-2 bg-slate-50">
                        @if($proyecto->imagen)
                            {{-- Imagen existente con efecto hover para zoom --}}
                            <div class="relative group overflow-hidden rounded-xl aspect-[16/10] shadow-inner border border-slate-200 bg-white">
                                <img src="{{ asset('storage/' . $proyecto->imagen) }}"
                                     alt="Imagen de {{ $proyecto->titulo }}"
                                     class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">

                                {{-- Overlay sutil al hacer hover --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <p class="text-white text-xs font-medium">Vista previa de la obra</p>
                                </div>
                            </div>
                        @else
                            {{-- Estado sin imagen (Placeholder) --}}
                            <div class="flex flex-col items-center justify-center rounded-xl aspect-[16/10] border-2 border-dashed border-slate-200 bg-white text-slate-400">
                                <svg class="w-16 h-16 mb-4 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium">No hay imagen disponible para este proyecto</p>
                                <p class="text-xs mt-1">Sube una imagen en el panel de edición</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Info General --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-base font-bold text-slate-800">Información</h3>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $proyecto->activo ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }}">
                            {{ $proyecto->activo ? 'En Curso' : 'Finalizado' }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-4">
                        <div><p class="text-[9px] text-slate-400 font-bold uppercase">Categoría</p><p class="text-sm font-semibold text-slate-800">{{ $proyecto->tipo }}</p></div>
                        <div><p class="text-[9px] text-slate-400 font-bold uppercase">Inicio</p><p class="text-sm font-semibold text-slate-800">{{ $proyecto->created_at->format('d M, Y') }}</p></div>
                    </div>
                </div>

                {{-- Reporte --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Reporte Técnico</h3>
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 text-sm text-slate-600 leading-relaxed italic">
                        {{ $proyecto->reporte_trabajador ?? 'Sin observaciones registradas.' }}
                    </div>
                </div>
            </div>

            {{-- Sidebar Lateral (1/3) --}}
            <div class="space-y-6">
                {{-- Responsable --}}
                <div class="bg-indigo-900 rounded-2xl p-5 text-white">
                    <p class="text-[9px] text-indigo-300 font-bold uppercase mb-3">Responsable</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-800 rounded-full flex items-center justify-center shrink-0 text-xs font-bold hover:scale-110 transition-transform cursor-default" title="{{ $proyecto->user->name ?? 'Usuario' }}">
                            {{ substr($proyecto->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate">{{ $proyecto->user->name ?? 'Sin asignar' }}</p>
                            <p class="text-[10px] text-indigo-300 truncate">{{ $proyecto->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Documentación --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documentación
                    </h3>

                    @if($proyecto->archivo)
                        <div class="group relative bg-slate-50 rounded-xl p-4 border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-colors">
                            <div class="flex flex-col items-center text-center">
                                {{-- Miniatura Visual --}}
                                <div class="w-16 h-16 bg-rose-100 text-rose-600 rounded-lg flex items-center justify-center mb-3 shadow-sm group-hover:scale-110 transition-transform">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V9l-3-3V3a2 2 0 00-2-2z" />
                                    </svg>
                                </div>

                                {{-- Nombre del archivo (Limpiando la ruta) --}}
                                <p class="text-xs font-medium text-slate-700 truncate w-full px-2" title="{{ basename($proyecto->archivo) }}">
                                    {{ basename($proyecto->archivo) }}
                                </p>

                                <p class="text-[10px] text-slate-400 uppercase mt-1">Documento PDF</p>

                                {{-- Botón de descarga --}}
                                <a href="{{ route('user.proyectos.descargar', $proyecto->id) }}"
                                class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition-all shadow-md active:scale-95">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Descargar
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <svg class="w-10 h-10 text-slate-300 mx-auto mb-2 stroke-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-xs text-slate-400">No hay archivos adjuntos</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>s
