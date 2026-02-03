<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Empleados y Asistencia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Encabezado de la Sección --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-700">Listado Maestro</h3>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Supervisión de ingresos y salidas del personal.
                    </p>
                </div>
                <a href="{{ route('admin.empleados.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Trabajador
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100 p-2 md:p-6">
                <table id="miTablaGenerica" class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Empleado</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Identificación</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-gray-400 uppercase tracking-widest">Cargo / Sección</th>
                            <th class="px-6 py-4 text-center text-[10px] font-black text-gray-400 uppercase tracking-widest">Asistencia Hoy</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black text-gray-400 uppercase tracking-widest">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                       @foreach($empleados as $empleado)
    @php $res = $empleado->statusAsistenciaHoy(); @endphp

    <tr class="hover:bg-indigo-50/30 transition-all duration-200">
        {{-- 1. Columna Empleado + Estatus --}}
        <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
                <div class="h-10 w-10 flex-shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm border-2 border-white shadow-sm">
                    {{ substr($empleado->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <div class="text-sm font-bold text-gray-900 uppercase leading-none">{{ $empleado->name }}</div>
                    <div class="mt-1.5 flex items-center">
                        <span class="relative flex h-2 w-2 mr-2">
                            @if($res->label === 'ACTIVO')
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $res->clase_punto }} opacity-75"></span>
                            @endif
                            <span class="relative inline-flex rounded-full h-2 w-2 {{ $res->clase_punto }}"></span>
                        </span>
                        <span class="text-[9px] {{ $res->texto }} font-black uppercase tracking-tighter">
                            {{ $res->label }}
                        </span>
                    </div>
                </div>
            </div>
        </td>

        {{-- 2. Identificación --}}
        <td class="px-6 py-4 whitespace-nowrap">
            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-lg text-xs font-bold">
                {{ $empleado->cedula ?? 'N/A' }}
            </span>
        </td>

        {{-- 3. Cargo / Sección --}}
        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600 font-medium italic">
            {{ $empleado->cargo ?? 'Personal' }} / {{ $empleado->seccion ?? 'General' }}
        </td>

        {{-- 4. Asistencia Hoy (Horas) --}}
        <td class="px-6 py-4 whitespace-nowrap text-center">
            @php
                $asistencia = $empleado->asistencias->where('fecha', now()->toDateString())->first();
            @endphp
            @if($asistencia && $res->label !== 'FALTA')
                <div class="inline-flex items-center gap-2 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    <span class="text-[10px] font-bold text-indigo-700">
                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('g:i A') : '--' }}
                    </span>
                    <span class="text-gray-300">|</span>
                    <span class="text-[10px] font-bold text-indigo-400">
                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('g:i A') : 'En curso' }}
                    </span>
                </div>
            @else
                <span class="text-[10px] text-gray-400 font-medium italic">Sin marcaje</span>
            @endif
        </td>

        {{-- 5. Operaciones --}}
        <td class="px-6 py-4 whitespace-nowrap text-right">
            <div class="flex justify-end items-center gap-1">
                {{-- Botón de Acción Rápida (Sincronizado) --}}
                <a href="{{ route('admin.asistencias.index') }}"
                   class="p-2 {{ $res->texto }} hover:bg-gray-100 rounded-xl transition-all"
                   title="{{ $res->boton }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </a>

                {{-- Botones Originales --}}
                <a href="{{ route('admin.empleados.show', $empleado->id) }}" class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all" title="Ver Detalles">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </a>

                <a href="{{ route('admin.empleados.edit', $empleado->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" title="Editar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                </a>

                <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar empleado?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#miTablaGenerica').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                "search": "FILTRAR TRABAJADOR:",
            },
            "responsive": true,
            "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6 gap-4"f>rt<"flex flex-col md:flex-row justify-between items-center mt-6 gap-4"ip>',
            "pageLength": 10
        });

        $('.dataTables_filter input').addClass('ml-0 px-5 py-3 border-2 border-gray-100 rounded-2xl outline-none focus:border-indigo-500 w-full md:w-80 text-sm shadow-sm transition-all font-bold');
        $('.dataTables_filter label').addClass('text-[10px] font-black text-gray-400 uppercase tracking-widest flex flex-col');
    });
    </script>
</x-app-layout>
