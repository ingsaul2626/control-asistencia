<x-app-layout>
@if(session('success'))
    <div class="max-w-7xl mx-auto mb-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-xl shadow-sm italic text-sm">
            {{ session('success') }}
        </div>
    </div>
@endif
    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6 p-4 bg-slate-900 text-emerald-400 font-mono text-[11px] rounded-2xl shadow-2xl border border-slate-700">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                    <p>👤 <span class="text-slate-500">ADMIN:</span> {{ auth()->user()->name }} (ID: {{ auth()->id() }})</p>
                    <p>⏰ <span class="text-slate-500">SERVIDOR:</span> {{ now()->toDateTimeString() }}</p>
                    <p>📅 <span class="text-slate-500">FECHA FILTRO:</span> {{ $fecha }}</p>
                    <p>📊 <span class="text-slate-500">REGISTROS HOY:</span> {{ $asistenciasHoy->count() }}</p>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-2xl font-bold text-slate-800">Panel de Control de Asistencias</h2>

                @php
                    // Buscamos el registro del administrador logueado por si necesita marcar su propia salida
                    $miRegistroHoy = $asistenciasHoy->where('user_id', auth()->id())->first();
                @endphp

                @if($miRegistroHoy && !$miRegistroHoy->hora_salida)
                    <form action="{{ route('admin.asistencias.marcar-salida-auto') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-2xl shadow-lg transition-all transform hover:scale-105 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V7" />
                            </svg>
                            MARCAR MI SALIDA AHORA
                        </button>
                    </form>
                @endif
            </div>

            <div class="bg-white shadow-xl sm:rounded-[2rem] overflow-hidden border border-gray-100">
    <div class="p-6">
        <table id="miTablaGenerica" class="display w-full" style="width:100%">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Trabajador</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Entrada</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Salida</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Observaciones</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($empleados as $empleado)
    @php
        $res = $empleado->statusAsistenciaHoy();
        $asistencia = $empleado->asistencias->where('fecha', now()->toDateString())->first();
        // Generamos un ID único para los campos de esta fila para poder leerlos con JS si fuera necesario
        $rowId = "emp_" . $empleado->id;
    @endphp
    <tr class="hover:bg-gray-50 transition-colors" id="{{ $rowId }}">
        {{-- 1. Trabajador --}}
        <td class="px-6 py-4">
            <div class="flex items-center">
                <div class="h-2.5 w-2.5 rounded-full {{ $res->clase_punto }} mr-3 {{ $res->label === 'ACTIVO' ? 'animate-pulse' : '' }}"></div>
                <div>
                    <span class="text-sm font-bold text-slate-700 block">{{ $empleado->name }}</span>
                    <span class="text-[10px] {{ $res->texto }} font-black uppercase italic tracking-tighter">STATUS: {{ $res->label }}</span>
                </div>
            </div>
        </td>

        {{-- Formulario unificado para capturar los inputs de tiempo y texto --}}
        {{-- Nota: Usamos el mismo formulario para que el botón "Asignar/Actualizar" envíe todo --}}
        <form action="{{ route('admin.asistencias.store') }}" method="POST" id="form-update-{{ $empleado->id }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $empleado->id }}">

            {{-- 2. Selección de Hora de Entrada --}}
            <td class="px-6 py-4 text-center">
                <input type="time" name="hora_entrada"
                    value="{{ $asistencia && $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '' }}"
                    class="text-xs font-bold text-slate-600 bg-slate-50 border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-1 w-28 text-center">
            </td>

            {{-- 3. Selección de Hora de Salida --}}
            <td class="px-6 py-4 text-center">
                <input type="time" name="hora_salida"
                    value="{{ $asistencia && $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '' }}"
                    class="text-xs font-bold text-indigo-600 bg-indigo-50 border-indigo-100 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 p-1 w-28 text-center">
            </td>

            {{-- 4. Texto de Observaciones --}}
            <td class="px-6 py-4 text-center">
                <input type="text" name="observaciones"
                    value="{{ $asistencia->observaciones ?? '' }}"
                    placeholder="Agregar nota..."
                    class="text-[10px] text-slate-500 border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 w-full p-1 min-w-[120px]">
            </td>

            {{-- 5. Botón Independiente: ASIGNAR / ACTUALIZAR --}}
            <td class="px-6 py-4 text-right">
                <div class="flex justify-end items-center gap-2">
                    <button type="submit" class="{{ $res->clase_boton }} text-white text-[10px] font-black px-4 py-2 rounded-xl shadow-sm transition-all hover:scale-105 active:scale-95 uppercase">
                        {{ $res->boton }}
                    </button>
        </form> {{-- Cerramos el formulario de actualización aquí --}}

                    {{-- 6. Botón Independiente: FALTA (Formulario aparte) --}}
                    @if($res->label !== 'FALTA')
                        <form action="{{ route('admin.asistencias.marcar-falta') }}" method="POST" class="inline">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $empleado->id }}">
                            <button type="submit" onclick="return confirm('¿Marcar inasistencia para {{ $empleado->name }}?')"
                                    class="bg-red-100 text-red-600 hover:bg-red-600 hover:text-white px-3 py-2 rounded-xl text-[10px] font-black transition-all uppercase">
                                FALTA
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#miTablaGenerica')) {
                $('#miTablaGenerica').DataTable({
                    "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                    "responsive": true,
                    "pageLength": 10,
                    "ordering": false // Desactivamos orden para no romper los formularios
                });
            }
        });

        function confirmarFalta(boton) {
            Swal.fire({
                title: '¿Confirmar Inasistencia?',
                text: "Se registrará al empleado como AUSENTE.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Sí, es falta',
                cancelButtonText: 'Cancelar',
                customClass: { popup: 'rounded-[2rem]' }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = boton.closest('form');
                    form.querySelector('input[name="es_falta"]').value = "1";
                    form.querySelector('input[name="observaciones"]').value = "FALTA";
                    form.submit();
                }
            });
        }
    </script>
</x-app-layout>

