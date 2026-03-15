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
                        <div class="w-10 h-10 bg-indigo-800 rounded-full flex items-center justify-center shrink-0 text-xs font-bold">
                            {{ substr($proyecto->user->name ?? 'U', 0, 1) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold truncate">{{ $proyecto->user->name ?? 'Sin asignar' }}</p>
                            <p class="text-[10px] text-indigo-300 truncate">{{ $proyecto->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Documentación --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5" x-data="{ open: false }">
                    <h3 class="text-sm font-bold text-slate-800 mb-4">Documentación</h3>
                    @if($proyecto->archivo)
                        @php
                            $extension = pathinfo($proyecto->archivo, PATHINFO_EXTENSION);
                            $esImagen = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'webp']);
                            $urlArchivo = asset('storage/' . $proyecto->archivo);
                        @endphp

                        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 cursor-pointer" 
                             @click="$esImagen ? open = true : window.open('{{ $urlArchivo }}', '_blank')">
                            <div class="h-40 bg-slate-100 flex items-center justify-center">
                                @if($esImagen)
                                    <img src="{{ $urlArchivo }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" alt="Archivo">
                                @else
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-indigo-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <p class="text-[10px] font-bold text-slate-500 mt-2 uppercase">{{ $extension }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Modal de Imagen (Solo para imágenes) --}}
                        @if($esImagen)
                            <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4" x-cloak @click="open = false">
                                <img src="{{ $urlArchivo }}" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
                            </div>
                        @endif

                    @else
                        <p class="text-xs text-slate-400 italic">Sin archivos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>