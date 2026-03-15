<x-app-layout>
    @php
        \Carbon\Carbon::setLocale('es');
        $user = auth()->user();
        $userId = $user->id;

        // Asistencia de hoy
        $asistencia = \App\Models\Asistencia::where('user_id', $userId)
                        ->whereDate('fecha', now()->toDateString())
                        ->first();

        // Historial
        $historialAsistencias = \App\Models\Asistencia::where('user_id', $userId)
                                    ->orderBy('fecha', 'desc')
                                    ->limit(5)
                                    ->get();
    @endphp

    <div class="py-6 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- COLUMNA IZQUIERDA: PROYECTOS Y BLOC DE NOTAS --}}
                <div class="lg:col-span-8 space-y-6">

                    {{-- Proyectos --}}
                    <h2 class="text-2xl font-black text-slate-800 italic">Mis Proyectos Asignados</h2>
                    @forelse($misEventos ?? [] as $proyecto)
                        <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                            <h3 class="text-xl font-black text-slate-800">{{ $proyecto->titulo }}</h3>
                            <p class="text-sm text-slate-600 mt-2">{{ $proyecto->descripcion }}</p>
                        </div>
                    @empty
                        <p class="text-center text-slate-400">No hay proyectos.</p>
                    @endforelse

                    {{-- BLOC DE NOTAS --}}
                    <div class="bg-yellow-50 rounded-[2rem] border border-yellow-100 p-6 shadow-sm">
                        <h3 class="font-black text-yellow-800 mb-2 italic">Bloc de Notas</h3>
                        <textarea class="w-full bg-transparent border-none focus:ring-0 text-sm text-yellow-900 placeholder-yellow-600" rows="4" placeholder="Escribe tus pendientes aquí..."></textarea>
                    </div>
                </div>

                {{-- COLUMNA DERECHA: ASISTENCIA Y BITÁCORA --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- TARJETA DE HORARIO (Botones) --}}
                    <div class="bg-indigo-900 rounded-[2rem] p-6 text-white shadow-lg border border-indigo-800">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xs font-black uppercase tracking-widest text-indigo-300">Control de Asistencia</h3>
                            <span class="text-[10px] bg-indigo-800 px-2 py-1 rounded-md text-indigo-200 uppercase font-bold">
                                {{ ucfirst($asistencia->status ?? 'Pendiente') }}
                            </span>
                        </div>

                            {{-- Rejilla de Horas --}}
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-indigo-800/50 p-3 rounded-2xl">
                                    <p class="text-[9px] text-indigo-300 uppercase font-bold tracking-wider">Entrada</p>
                                    <p class="text-lg font-mono font-bold">
                                        {{ $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '--:--' }}
                                    </p>
                                </div>
                                <div class="bg-indigo-800/50 p-3 rounded-2xl">
                                    <p class="text-[9px] text-indigo-300 uppercase font-bold tracking-wider">Salida</p>
                                    <p class="text-lg font-mono font-bold">
                                        {{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '--:--' }}
                                    </p>
                                </div>
                            </div>


                             {{-- Si el estado es 'por_asignar', mostramos Aceptar --}}

                                @if($asistencia)
                                {{-- Muestra el estado actual para debug --}}
                                <p class="text-indigo-300 text-xs mb-2">Estado: {{ ucfirst($asistencia->status) }}</p>

                                @if($asistencia->status === 'pendiente')
                                    {{-- EL ADMIN CREÓ LA JORNADA, EL USUARIO DEBE ACEPTARLA --}}
                                    <form action="{{ route('user.asistencia.aceptar', $asistencia->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-emerald-500 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-400 transition shadow-lg">
                                            Aceptar Asistencia
                                        </button>
                                    </form>

                                @elseif($asistencia->status === 'aceptado')
                                    {{-- EL USUARIO YA ACEPTÓ, AHORA PUEDE MARCAR SALIDA --}}
                                    <form action="{{ route('user.asistencia.marcarSalida', $asistencia->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-rose-500 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-rose-400 transition shadow-lg">
                                            Marcar Salida
                                        </button>
                                    </form>

                                @else
                                    <p class="text-emerald-400 font-bold text-center italic">Jornada {{ ucfirst($asistencia->status) }}</p>
                                @endif
                            @else
                                <p class="text-indigo-200 text-sm">No hay jornada programada para hoy.</p>
                            @endif
                        </div>

                    {{-- BITÁCORA --}}
                    <div class="bg-white rounded-[2rem] border border-slate-100 p-6 shadow-sm">
                        <h3 class="font-black text-slate-800 mb-4">Bitácora</h3>
                        @foreach($historialAsistencias as $registro)
                            <div class="flex justify-between border-b border-slate-50 py-2 text-xs">
                                <span>{{ \Carbon\Carbon::parse($registro->fecha)->format('d M') }}</span>
                                <span class="font-bold">{{ ucfirst($registro->status) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
