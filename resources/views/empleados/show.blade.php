<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Expediente: {{ $empleado->nombre_apellido }}
            </h2>
            <a href="{{ route('admin.empleados.index') }}" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg hover:bg-indigo-100 transition">
                ← VOLVER AL LISTADO
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 p-8">
                <div class="flex items-center gap-6 mb-8 border-b border-gray-50 pb-8">
                    <div class="h-24 w-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-4xl font-black shadow-lg shadow-indigo-200">
                        {{ substr($empleado->nombre_apellido, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 uppercase">{{ $empleado->nombre_apellido }}</h3>
                        <p class="text-indigo-500 font-bold tracking-widest text-xs uppercase">{{ $empleado->tipo_trabajador }} — {{ $empleado->seccion }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Documento de Identidad</p>
                        <p class="text-sm font-bold text-gray-700">{{ $empleado->cedula }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Estado de Hoy</p>
                        @if($empleado->ultimaAsistencia)
                            <span class="text-xs font-black text-emerald-600 uppercase">● Presente</span>
                        @else
                            <span class="text-xs font-black text-red-400 uppercase">○ Ausente</span>
                        @endif
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-50 pt-8">
                    <h4 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Último Registro de Asistencia</h4>
                    <div class="flex justify-between items-center bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase mb-1">Entrada</p>
                            <p class="text-xl font-black text-indigo-700">{{ $empleado->ultimaAsistencia->hora_entrada ?? '--:--' }}</p>
                        </div>
                        <div class="h-10 w-[2px] bg-indigo-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase mb-1">Salida</p>
                            <p class="text-xl font-black text-indigo-700">{{ $empleado->ultimaAsistencia->hora_salida ?? '--:--' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
