<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Perfil de usuarios: {{ $usuarios->name }}
            </h2>
            <a href="{{ route('admin.usuarios.index') }}" class="text-xs font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-lg hover:bg-indigo-100 transition">
                ← VOLVER AL LISTADO
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 p-8">

                {{-- Cabecera --}}
                <div class="flex items-center gap-6 mb-8 border-b border-gray-50 pb-8">
                    <div class="h-24 w-24 rounded-full bg-indigo-600 flex items-center justify-center text-white text-4xl font-black shadow-lg shadow-indigo-200">
                        {{ substr($usuarios->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 uppercase">{{ $usuarios->name }}</h3>
                        <p class="text-indigo-500 font-bold tracking-widest text-xs uppercase">{{ $usuarios->role ?? 'usuarios SIN ROL' }}</p>
                    </div>
                </div>

                {{-- Detalles principales --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Correo Electrónico</p>
                        <p class="text-sm font-bold text-gray-700">{{ $usuarios->email }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Cédula de Identidad</p>
                        <p class="text-sm font-bold text-gray-700">{{ $usuarios->cedula ?? 'No registrado' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Área Asignada</p>
                        <p class="text-sm font-bold text-gray-700">{{ $usuarios->area ?? 'Sin asignar' }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-2xl">
                        <p class="text-[10px] font-black text-gray-400 uppercase mb-1">Estado de Aprobación</p>
                        @if($usuarios->is_approved)
                            <span class="text-xs font-black text-emerald-600 uppercase">● APROBADO</span>
                        @else
                            <span class="text-xs font-black text-amber-500 uppercase">○ PENDIENTE</span>
                        @endif
                    </div>
                </div>

                {{-- Registro de Asistencia --}}
                <div class="mt-8 border-t border-gray-50 pt-8">
                    <h4 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Último Registro de Asistencia</h4>
                    <div class="flex justify-between items-center bg-indigo-50/50 p-6 rounded-3xl border border-indigo-100">
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase mb-1">Entrada</p>
                            <p class="text-xl font-black text-indigo-700">
                                {{ $usuarios->ultimaAsistencia->hora_entrada ?? '--:--' }}
                            </p>
                        </div>
                        <div class="h-10 w-[2px] bg-indigo-200"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-bold text-indigo-400 uppercase mb-1">Salida</p>
                            <p class="text-xl font-black text-indigo-700">
                                {{ $usuarios->ultimaAsistencia->hora_salida ?? '--:--' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Información de Registro --}}
                <div class="mt-8 border-t border-gray-50 pt-8">
                    <h4 class="text-xs font-black text-gray-400 uppercase mb-4 tracking-widest">Información de Registro</h4>
                    <div class="bg-gray-50 p-6 rounded-3xl border border-gray-100">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Fecha de Registro</p>
                                <p class="text-sm font-black text-gray-700">{{ $usuarios->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Última Actualización</p>
                                <p class="text-sm font-black text-gray-700">{{ $usuarios->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
