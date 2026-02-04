<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Proyectos - Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-8 rounded-xl shadow-sm mb-8">
                <h3 class="text-indigo-600 font-bold flex items-center mb-6">
                    <span class="mr-2">🚀</span> Crear Nuevo Proyecto y Asignar
                </h3>

                <form action="{{ route('admin.proyectos.asignar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Seleccionar Proyecto</label>
                            <select name="evento_id" class="w-full border-gray-200 rounded-lg text-sm" required>
                                <option value="">-- Elige un proyecto --</option>
                                @foreach($eventos as $e)
                                    <option value="{{ $e->id }}">{{ $e->titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Asignar a Trabajador</label>
                            <select name="user_id" class="w-full border-gray-200 rounded-lg text-sm" required>
                                <option value="">Seleccione un trabajador</option>
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg">
                            Vincular y Guardar
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Proyectos Activos</h3>
                <div class="overflow-x-auto">
                    <table id="miTablaGenerica" class="display w-full">
                        <thead>
                            <tr class="text-gray-700 border-b bg-gray-50 text-left">
                                <th class="py-3 px-4">Proyecto</th>
                                <th class="py-3 px-4">Responsable</th>
                                <th class="py-3 px-4 text-center">Avance Técnico</th>
                                <th class="py-3 px-4 text-center">Estado</th>
                                <th class="py-3 px-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                            <tr class="border-b hover:bg-indigo-50/30 transition">
                                <td class="py-4 px-4">
                                    <div class="font-bold text-indigo-900">{{ $evento->titulo }}</div>
                                    <div class="text-[10px] text-gray-400 uppercase">{{ $evento->tipo }} | {{ $evento->lugar }}</div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">
                                    {{ $evento->user->name ?? 'Sin asignar' }}
                                </td>
                                <td class="py-4 px-4 text-center">
    @if($evento->reporte_trabajador)
        <div class="group relative inline-block cursor-help">
            <span class="inline-flex items-center px-2 py-1 bg-amber-100 text-amber-700 text-[10px] font-bold rounded border border-amber-200 uppercase tracking-tighter hover:bg-amber-200 transition">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ver Reporte
            </span>

            <div class="hidden group-hover:block absolute z-50 w-64 p-4 bg-gray-900 text-white text-xs rounded-xl shadow-2xl -mt-2 left-1/2 transform -translate-x-1/2 -translate-y-full border border-gray-700">
                <div class="font-bold text-amber-400 mb-1">Avance Técnico:</div>
                <p class="leading-relaxed italic text-gray-200">"{{ $evento->reporte_trabajador }}"</p>
                <div class="absolute w-3 h-3 bg-gray-900 rotate-45 left-1/2 -bottom-1.5 -translate-x-1/2 border-r border-b border-gray-700"></div>
            </div>
        </div>
    @else
        <span class="text-[10px] text-gray-400 italic">Sin reportes aún</span>
    @endif
</td>
                                <td class="py-4 px-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $evento->activo ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">
                                        {{ $evento->activo ? 'Activo' : 'Pausado' }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex justify-center gap-2">


                                        <a href="{{ route('admin.proyectos.edit', $evento->id) }}" class="p-1 bg-blue-50 text-blue-600 rounded-md">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

            </div>
        </div>
    </div>

</x-app-layout>
