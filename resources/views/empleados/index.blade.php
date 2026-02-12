<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
            {{ __('Staff') }}<span class="text-indigo-600">Directory</span>
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row justify-between items-end mb-8 gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="h-8 w-1 bg-indigo-600 rounded-full"></span>
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Listado Maestro</h3>
                    </div>
                    <p class="text-sm font-medium text-slate-500 max-w-md">
                        Base de datos central de colaboradores. Gestione perfiles, cargos y supervise el estado de conexión en tiempo real.
                    </p>
                </div>

                <div class="flex items-center gap-4 w-full lg:w-auto">
                    <a href="{{ route('admin.empleados.create') }}"
                        class="flex-1 lg:flex-none inline-flex items-center justify-center px-6 py-3 bg-slate-900 border border-transparent rounded-2xl font-black text-xs text-white uppercase tracking-widest hover:bg-indigo-600 shadow-xl shadow-slate-200 transition-all hover:-translate-y-1 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Añadir Colaborador
                    </a>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 sm:rounded-[2.5rem] border border-white p-4 md:p-8">
                <table id="miTablaGenerica" class="w-full border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4 text-left">Ficha de Empleado</th>
                            <th class="px-6 py-4 text-left">ID Documento</th>
                            <th class="px-6 py-4 text-left">Posición y Área</th>
                            <th class="px-6 py-4 text-center">Registro de Hoy</th>
                            <th class="px-6 py-4 text-right">Gestión</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-0">
                        @foreach($empleados as $empleado)
                            @php $res = $empleado->statusAsistenciaHoy(); @endphp
                            <tr class="bg-white border border-slate-50 shadow-sm rounded-2xl group transition-all hover:shadow-md hover:bg-slate-50/50">

                                {{-- Empleado + Estatus --}}
                                <td class="px-6 py-5 rounded-l-3xl">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-600 font-black text-lg shadow-inner group-hover:from-indigo-500 group-hover:to-indigo-600 group-hover:text-white transition-all duration-300">
                                                {{ substr($empleado->name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white {{ $res->clase_punto }} {{ $res->label === 'ACTIVO' ? 'animate-pulse' : '' }}"></div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-black text-slate-800 uppercase tracking-tight leading-none group-hover:text-indigo-600 transition-colors">{{ $empleado->name }}</div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-[9px] {{ $res->texto }} font-black uppercase tracking-widest px-2 py-0.5 rounded-md {{ str_replace('text-', 'bg-', $res->texto) }}/10">
                                                    {{ $res->label }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Identificación --}}
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Cédula / ID</span>
                                        <span class="text-sm font-mono font-bold text-slate-600">{{ $empleado->cedula ?? '---' }}</span>
                                    </div>
                                </td>

                                {{-- Cargo / Sección --}}
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-700 leading-tight">{{ $empleado->cargo ?? 'Operativo' }}</span>
                                        <span class="text-[10px] font-black text-indigo-500/70 uppercase tracking-widest">{{ $empleado->seccion ?? 'Área General' }}</span>
                                    </div>
                                </td>

                                {{-- Asistencia Hoy --}}
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $asistencia = $empleado->asistencias->where('fecha', now()->toDateString())->first();
                                    @endphp
                                    @if($asistencia && $res->label !== 'FALTA')
                                        <div class="inline-flex flex-col items-center bg-slate-50 px-4 py-2 rounded-2xl border border-slate-100 group-hover:bg-white transition-colors">
                                            <div class="flex items-center gap-2">
                                                <span class="text-[11px] font-black text-slate-700">
                                                    {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('g:i A') : '--' }}
                                                </span>
                                                <svg class="w-3 h-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                                <span class="text-[11px] font-black {{ $asistencia->hora_salida ? 'text-indigo-600' : 'text-amber-500 animate-pulse' }}">
                                                    {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('g:i A') : 'ACTIVO' }}
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest bg-slate-100 px-3 py-1 rounded-lg italic">Sin Marcaje</span>
                                    @endif
                                </td>

                                {{-- Operaciones --}}
                                <td class="px-6 py-5 text-right rounded-r-3xl">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.empleados.show', $empleado->id) }}"
                                           class="p-2.5 bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white rounded-xl transition-all shadow-sm"
                                           title="Ver Perfil">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        </a>

                                        <a href="{{ route('admin.empleados.edit', $empleado->id) }}"
                                           class="p-2.5 bg-slate-50 text-slate-400 hover:bg-amber-500 hover:text-white rounded-xl transition-all shadow-sm"
                                           title="Editar">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>

                                        <form action="{{ route('admin.empleados.destroy', $empleado->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar registro de forma permanente?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2.5 bg-slate-50 text-slate-400 hover:bg-rose-500 hover:text-white rounded-xl transition-all shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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
        if (!$.fn.DataTable.isDataTable('#miTablaGenerica')) {
            $('#miTablaGenerica').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                    "search": "",
                    "searchPlaceholder": "BUSCAR POR NOMBRE O CÉDULA..."
                },
                "responsive": true,
                "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6 gap-4"f>rt<"flex justify-between items-center mt-6"ip>',
                "pageLength": 10
            });

            // Estilizar el input de búsqueda globalmente
            $('.dataTables_filter input').addClass('bg-white border-slate-200 rounded-2xl text-[11px] font-black px-6 py-4 focus:ring-4 focus:ring-indigo-100 outline-none border transition-all w-full md:w-96 shadow-sm uppercase tracking-widest');
        }
    });
    </script>

    <style>
        /* Ajustes para DataTables */
        .dataTables_info { @apply text-[10px] font-black text-slate-400 uppercase tracking-widest; }
        .dataTables_paginate .paginate_button { @apply !rounded-xl !border-none !font-black !text-[10px] !tracking-widest !px-4 !py-2 !uppercase; }
        .dataTables_paginate .paginate_button.current { @apply !bg-indigo-600 !text-white !shadow-lg !shadow-indigo-100; }

        /* Efecto de separación de filas */
        table.dataTable.border-separate { border-spacing: 0 12px !important; }
    </style>
</x-app-layout>
