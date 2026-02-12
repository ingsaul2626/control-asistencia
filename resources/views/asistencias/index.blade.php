<x-app-layout>
    @if(session('success'))
        <div id="alert-success" class="fixed top-20 right-5 z-50 max-w-sm animate-fade-in-down">
            <div class="bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('alert-success')?.remove(), 4000);</script>
    @endif

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 p-6 bg-slate-900 rounded-3xl shadow-2xl border border-slate-800 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="flex flex-col">
                        <span class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Operador</span>
                        <span class="text-emerald-400 font-mono text-sm uppercase tracking-tighter">{{ auth()->user()->name }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Sincronización</span>
                        <span class="text-slate-300 font-mono text-sm tracking-tighter">{{ now()->format('d M, Y H:i:s') }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Filtro Activo</span>
                        <span class="text-indigo-400 font-mono text-sm tracking-tighter">{{ $fecha }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-slate-500 text-[10px] font-black uppercase tracking-widest">Tráfico de Hoy</span>
                        <span class="text-white font-mono text-sm">{{ $asistenciasHoy->count() }} Registros</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-slate-800 tracking-tighter italic uppercase">Registry<span class="text-indigo-600">Core</span></h2>
                    <p class="text-slate-500 text-sm font-medium">Gestión de tiempos y asistencias del personal.</p>
                </div>

                @php $miRegistroHoy = $asistenciasHoy->where('user_id', auth()->id())->first(); @endphp

                @if($miRegistroHoy && !$miRegistroHoy->hora_salida)
                    <form action="{{ route('admin.asistencias.marcar-salida-auto') }}" method="POST">
                        @csrf
                        <button type="submit" class="group relative bg-orange-500 text-white font-black py-4 px-8 rounded-2xl shadow-xl shadow-orange-200 transition-all hover:bg-orange-600 active:scale-95 flex items-center gap-3 uppercase text-xs tracking-widest">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                            </span>
                            Cerrar Mi Jornada
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-white shadow-2xl shadow-slate-200/50 rounded-[2.5rem] overflow-hidden border border-slate-100 p-4 sm:p-8">
                <table id="miTablaGenerica" class="w-full border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4 text-left">Colaborador</th>
                            <th class="px-6 py-4 text-center">Entrada</th>
                            <th class="px-6 py-4 text-center">Salida</th>
                            <th class="px-6 py-4 text-center">Notas de Campo</th>
                            <th class="px-6 py-4 text-right">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($empleados as $empleado)
                            @php
                                $res = $empleado->statusAsistenciaHoy();
                                $asistencia = $empleado->asistencias->where('fecha', now()->toDateString())->first();
                            @endphp
                            <tr class="bg-white border border-slate-50 shadow-sm rounded-2xl group transition-all hover:shadow-md hover:bg-slate-50/50">
                                {{-- Trabajador --}}
                                <td class="px-6 py-5 rounded-l-3xl">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-all shadow-inner">
                                                {{ substr($empleado->name, 0, 1) }}
                                            </div>
                                            <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white {{ $res->clase_punto }} {{ $res->label === 'ACTIVO' ? 'animate-pulse' : '' }}"></div>
                                        </div>
                                        <div class="ml-4">
                                            <span class="text-sm font-black text-slate-700 block tracking-tight">{{ $empleado->name }}</span>
                                            <span class="text-[9px] font-bold py-0.5 px-2 rounded-md bg-slate-100 text-slate-500 tracking-tighter uppercase">Status: {{ $res->label }}</span>
                                        </div>
                                    </div>
                                </td>

                                <form action="{{ route('admin.asistencias.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $empleado->id }}">

                                    {{-- Entrada --}}
                                    <td class="px-6 py-5 text-center">
                                        <input type="time" name="hora_entrada"
                                            value="{{ $asistencia && $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '' }}"
                                            class="text-sm font-black text-slate-600 bg-slate-100/50 border-transparent rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all p-2 w-28 text-center">
                                    </td>

                                    {{-- Salida --}}
                                    <td class="px-6 py-5 text-center">
                                        <input type="time" name="hora_salida"
                                            value="{{ $asistencia && $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '' }}"
                                            class="text-sm font-black text-indigo-600 bg-indigo-50/50 border-transparent rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all p-2 w-28 text-center">
                                    </td>

                                    {{-- Observaciones --}}
                                    <td class="px-6 py-5 text-center">
                                        <input type="text" name="observaciones"
                                            value="{{ $asistencia->observaciones ?? '' }}"
                                            placeholder="Añadir reporte..."
                                            class="text-xs font-medium text-slate-500 bg-slate-100/50 border-transparent rounded-xl focus:bg-white focus:ring-4 focus:ring-indigo-100 w-full p-2 min-w-[150px] transition-all">
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-6 py-5 text-right rounded-r-3xl">
                                        <div class="flex justify-end items-center gap-2">
                                            <button type="submit" class="{{ $res->clase_boton }} text-white text-[10px] font-black px-5 py-2.5 rounded-xl shadow-lg transition-all hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                                                {{ $res->boton }}
                                            </button>
                                </form>

                                            @if($res->label !== 'FALTA')
                                                <form action="{{ route('admin.asistencias.marcar-falta') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $empleado->id }}">
                                                    <button type="button" onclick="confirmarFaltaCustom(this)"
                                                            class="bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white p-2.5 rounded-xl transition-all shadow-sm">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#miTablaGenerica')) {
                $('#miTablaGenerica').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                        "search": "",
                        "searchPlaceholder": "Buscar colaborador..."
                    },
                    "responsive": true,
                    "pageLength": 10,
                    "ordering": false,
                    "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6"f>rt<"flex justify-between items-center mt-6"ip>',
                });

                // Estilizar buscador
                $('.dataTables_filter input').addClass('bg-white border-slate-200 rounded-2xl text-sm px-6 py-3 focus:ring-4 focus:ring-indigo-100 outline-none border transition-all w-full md:w-80 shadow-sm');
            }
        });

        function confirmarFaltaCustom(boton) {
            const form = boton.closest('form');
            Swal.fire({
                title: '¿Reportar Inasistencia?',
                text: "El registro se marcará como FALTA para la jornada de hoy.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#f43f5e',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'SÍ, MARCAR FALTA',
                cancelButtonText: 'CANCELAR',
                customClass: {
                    popup: 'rounded-[2.5rem] border-none shadow-2xl',
                    confirmButton: 'rounded-xl font-black uppercase text-xs tracking-widest px-6 py-3',
                    cancelButton: 'rounded-xl font-black uppercase text-xs tracking-widest px-6 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>

    <style>
        .animate-fade-in-down { animation: fadeInDown 0.5s ease-out; }
        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .dataTables_paginate .paginate_button { @apply !rounded-xl !border-none !font-bold !text-xs !tracking-widest !px-4 !py-2; }
        .dataTables_paginate .paginate_button.current { @apply !bg-indigo-600 !text-white !shadow-lg !shadow-indigo-200; }
    </style>
</x-app-layout>
