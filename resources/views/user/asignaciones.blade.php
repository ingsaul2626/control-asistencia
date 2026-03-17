<x-app-layout>
   @php
    \Carbon\Carbon::setLocale('es');
    $user = auth()->user();

    // Consultamos la asistencia de hoy una sola vez
    $asistencia = \App\Models\Asistencia::where('user_id', $user->id)
                        ->whereDate('fecha', now()->toDateString())
                        ->first();

    // Historial se mantiene igual
    $historialAsistencias = \App\Models\Asistencia::where('user_id', $user->id)
                                        ->where('id', '!=', $asistencia ? $asistencia->id : 0) // Opcional: no repetir hoy en el historial
                                        ->orderBy('fecha', 'desc')
                                        ->limit(5)
                                        ->get();
    @endphp

    <div class="py-10 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- COLUMNA IZQUIERDA: PROYECTOS (8/12) --}}
                {{-- COLUMNA IZQUIERDA: PROYECTOS --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Proyectos Asignados
                        </h3>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">{{ $misProyectos->count() }} Activos</span>
                    </div>

                    @foreach($misProyectos as $proyecto)
                        <article x-data="{ showModal: false }" class="group bg-white border border-slate-200 rounded-[2rem] p-5 hover:shadow-xl hover:shadow-indigo-500/5 hover:border-indigo-200 transition-all duration-300">
                            <div class="flex flex-col sm:flex-row gap-6">
                                {{-- Thumbnail --}}
                                <div class="relative w-full sm:w-32 h-32 flex-shrink-0">
                                    <img src="{{ $proyecto->imagen ? asset('storage/'.$proyecto->imagen) : 'https://ui-avatars.com/api/?name='.urlencode($proyecto->titulo).'&background=6366f1&color=fff' }}"
                                         alt="Proyecto" class="w-full h-full object-cover rounded-2xl shadow-inner">
                                    <div class="absolute inset-0 ring-1 ring-inset ring-black/5 rounded-2xl"></div>
                                </div>

                                <div class="flex-grow">
                                    <div class="flex flex-wrap items-start justify-between gap-2 mb-2">
                                        <h4 class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">
                                            {{ $proyecto->titulo }}
                                        </h4>

                                        {{-- ACCIONES --}}
                                        <div class="flex items-center gap-2">
                                            
                                            @if($proyecto->archivo)
                                                        <a href="{{ route('user.proyectos.descargar', $proyecto->id) }}"
                                                        class="flex items-center gap-2 px-3 py-2 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 border border-rose-100 transition-all shadow-sm"
                                                        title="Descargar archivo">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                            </svg>
                                                            <span class="text-[10px] font-black uppercase">Descargar PDF</span>
                                                        </a>
                                                    @else
                                                        <span class="px-3 py-2 bg-slate-100 text-slate-400 rounded-xl text-[10px] font-bold uppercase">Sin PDF</span>
                                                    @endif


                                            <button @click="showModal = true"
                                                    class="p-2 bg-slate-50 text-slate-400 rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all"
                                                    title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <p class="text-sm text-slate-500 leading-relaxed line-clamp-2 mb-4">
                                        {{ $proyecto->descripcion }}
                                    </p>

                                    {{-- Footer de la tarjeta --}}
                                    <div class="flex flex-wrap items-center justify-between gap-4 pt-4 border-t border-slate-50">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold {{ $proyecto->activo ? 'bg-indigo-50 text-indigo-700' : 'bg-emerald-50 text-emerald-700' }}">
                                                <span class="w-1.5 h-1.5 rounded-full {{ $proyecto->activo ? 'bg-indigo-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                                {{ $proyecto->activo ? 'En progreso' : 'Finalizado' }}
                                            </span>
                                            <span class="text-[11px] text-slate-400 font-medium">
                                                Vence: {{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <form action="{{ route('user.proyectos.updateReport', $proyecto->id) }}" method="POST" class="flex items-center gap-2 flex-grow max-w-md">
                                            @csrf @method('PUT')
                                            <input type="text" name="reporte_trabajador" value="{{ $proyecto->reporte_trabajador }}"
                                                   class="w-full bg-slate-50 border-transparent focus:border-indigo-300 focus:bg-white focus:ring-0 rounded-xl text-xs py-2 transition-all"
                                                   placeholder="Reporte rápido...">
                                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-all active:scale-95">
                                                Guardar
                                            </button>
                                            <a href="{{ route('user.proyectos.finalizar', $proyecto->id) }}"
                                               class="bg-emerald-500 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-600 shadow-md shadow-emerald-200 transition-all active:scale-95">
                                                Completar
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL FLOTANTE --}}
                            <div x-show="showModal"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">

                                <div @click.away="showModal = false" class="bg-white rounded-3xl p-8 max-w-lg w-full shadow-2xl space-y-6">
                                    <div class="flex justify-between items-start">
                                        <h2 class="text-xl font-black text-slate-900">{{ $proyecto->titulo }}</h2>
                                        <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">✕</button>
                                    </div>

                                    <div class="space-y-3">
                                        <p class="text-sm text-slate-600 leading-relaxed">{{ $proyecto->descripcion }}</p>
                                        <div class="grid grid-cols-2 gap-4 text-xs">
                                            <div class="bg-slate-50 p-3 rounded-xl">
                                                <span class="block text-[9px] uppercase font-bold text-slate-400">Inicio</span>
                                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d M, Y') }}</span>
                                            </div>
                                            <div class="bg-slate-50 p-3 rounded-xl">
                                                <span class="block text-[9px] uppercase font-bold text-slate-400">Entrega</span>
                                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button @click="showModal = false" class="w-full py-3 bg-slate-900 text-white font-bold uppercase text-[10px] tracking-widest rounded-xl hover:bg-slate-800 transition">
                                        Cerrar detalles
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach

            </div>

                {{-- COLUMNA DERECHA: GESTIÓN (4/12) --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                    {{-- Control de Asistencia --}}
                    <div class="bg-indigo-900 rounded-3xl p-6 text-white shadow-xl">
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-indigo-300 mb-6">Control de Asistencia</h3>
                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-indigo-800/50 p-4 rounded-2xl">
                                <p class="text-[9px] text-indigo-300 uppercase font-bold tracking-wider">Entrada</p>
                                <p class="text-lg font-mono font-bold">{{ ($asistencia && $asistencia->hora_entrada_real) ? \Carbon\Carbon::parse($asistencia->hora_entrada_real)->format('H:i') : '--:--' }}</p>
                            </div>
                            <div class="bg-indigo-800/50 p-4 rounded-2xl">
                                <p class="text-[9px] text-indigo-300 uppercase font-bold tracking-wider">Salida</p>
                                <p class="text-lg font-mono font-bold">{{ ($asistencia && $asistencia->hora_salida) ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '--:--'}}</p>
                            </div>
                        </div>

                        @if($asistencia)
                            @if($asistencia->status === 'pendiente')
                                <form action="{{ route('user.asistencia.aceptar', $asistencia->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-emerald-500 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-emerald-400 transition shadow-lg">Aceptar Asistencia</button>
                                </form>
                            @elseif($asistencia->status === 'aceptado')
                                <form action="{{ route('user.asistencia.marcarSalida', $asistencia->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-rose-500 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-rose-400 transition shadow-lg">Marcar Salida</button>
                                </form>
                            @else
                                <p class="text-emerald-400 font-bold text-center italic">Jornada {{ ucfirst($asistencia->status) }}</p>
                            @endif
                        @else
                            <p class="text-indigo-200 text-xs text-center italic">No hay jornada programada hoy</p>
                        @endif
                    </div>

                    {{-- Bitácora --}}
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                        <h3 class="font-black text-slate-800 mb-4">Bitácora</h3>
                        @foreach($historialAsistencias as $registro)
                            <div class="flex justify-between py-3 border-b border-slate-50 last:border-0 text-xs">
                                <span class="text-slate-500">{{ \Carbon\Carbon::parse($registro->fecha)->format('d M') }}</span>
                                <span class="font-bold text-slate-900">{{ ucfirst($registro->status) }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Bloc de Notas --}}
                    <div class="bg-yellow-50 rounded-3xl border border-yellow-100 p-6 shadow-sm">
                        <h3 class="font-black text-yellow-900 mb-3 italic">Bloc de Notas</h3>
                        <textarea class="w-full bg-transparent border-0 focus:ring-0 text-sm text-yellow-800 placeholder-yellow-600 p-0 resize-none" rows="6" placeholder="Escribe tus pendientes aquí..."></textarea>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        [x-cloak] { display: none !important; }
    }
</style>
