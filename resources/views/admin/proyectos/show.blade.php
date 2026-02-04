<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalles del Proyecto: ') }} {{ $evento->titulo }}
            </h2>
            <a href="{{ route('admin.admin.panelControl') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition">
                Volver al Panel
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-indigo-500">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Información del Proyecto</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase">Ubicación / Lugar</p>
                                <p class="text-gray-800 font-medium">{{ $evento->lugar }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-500 uppercase">Tipo de Proyecto</p>
                                <p class="text-gray-800 font-medium">{{ $evento->tipo }}</p>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 uppercase">Fecha de Registro</p>
                                <p class="text-gray-800 font-medium">{{ $evento->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="mt-4">
                                <p class="text-xs font-bold text-gray-500 uppercase">Estado Actual</p>
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $evento->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $evento->activo ? 'Activo' : 'Pausado' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border-t-4 border-amber-400">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Avance Técnico (Reporte del Trabajador)</h3>
                        @if($evento->reporte_trabajador)
                            <div class="bg-amber-50 p-4 rounded-lg border border-amber-200">
                                <p class="text-gray-700 italic leading-relaxed">
                                    "{{ $evento->reporte_trabajador }}"
                                </p>
                            </div>
                        @else
                            <div class="text-center py-6 text-gray-400 italic">
                                <p>No hay reportes técnicos cargados para este proyecto todavía.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white p-6 rounded-xl shadow-sm text-center">
                        <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase mb-1">Responsable Asignado</h3>
                        <p class="text-lg font-bold text-indigo-900">{{ $evento->user->name ?? 'Sin Asignar' }}</p>
                        <p class="text-xs text-gray-400">{{ $evento->user->email ?? '' }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm">
                        <h3 class="text-sm font-bold text-gray-800 mb-4 border-b pb-2">Documentos Adjuntos</h3>
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border hover:bg-gray-100 transition cursor-pointer">
                            <svg class="w-8 h-8 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                            <div>
                                <p class="text-xs font-bold text-gray-700">Plano_Tecnico.pdf</p>
                                <p class="text-[10px] text-gray-400 uppercase">Ver Documento</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
