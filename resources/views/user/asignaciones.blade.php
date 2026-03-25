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
                                          ->where('id', '!=', $asistencia ? $asistencia->id : 0)
                                          ->orderBy('fecha', 'desc')
                                          ->limit(5)
                                          ->get();
    @endphp

    <div class="py-10 bg-[#fdfdfd] dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                {{-- COLUMNA IZQUIERDA: PROYECTOS --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-black text-slate-800 dark:text-white flex items-center gap-3 uppercase tracking-tighter italic">
                            <div class="p-2 bg-orange-600 rounded-lg text-white shadow-lg shadow-orange-100 dark:shadow-none">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            Proyectos Asignados
                        </h3>
                        <span class="bg-orange-50 dark:bg-orange-500/10 text-orange-700 dark:text-orange-400 text-[10px] font-black px-4 py-1.5 rounded-full border border-orange-100 dark:border-orange-500/20 uppercase tracking-widest">{{ $misProyectos->count() }} Activos</span>
                    </div>

                    @foreach($misProyectos as $proyecto)
                        <article x-data="{ showModal: false }" class="group bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] p-6 hover:shadow-2xl hover:shadow-orange-500/5 hover:border-orange-200 dark:hover:border-orange-500/30 transition-all duration-500">
                            <div class="flex flex-col md:flex-row gap-8">
                                {{-- Thumbnail --}}
                                <div class="relative w-full md:w-40 h-40 flex-shrink-0">
                                    <img src="{{ $proyecto->imagen ? asset('storage/'.$proyecto->imagen) : 'https://ui-avatars.com/api/?name='.urlencode($proyecto->titulo).'&background=f97316&color=fff' }}"
                                         alt="Proyecto" class="w-full h-full object-cover rounded-3xl shadow-inner opacity-90 group-hover:opacity-100 transition-opacity">
                                    <div class="absolute inset-0 ring-1 ring-inset ring-black/5 dark:ring-white/5 rounded-3xl"></div>
                                </div>

                                <div class="flex-grow">
                                    <div class="flex flex-wrap items-start justify-between gap-4 mb-3">
                                        <h4 class="text-xl font-black text-slate-900 dark:text-white group-hover:text-orange-600 transition-colors tracking-tight uppercase italic">
                                            {{ $proyecto->titulo }}
                                        </h4>

                                        {{-- ACCIONES --}}
                                        <div class="flex items-center gap-2">
                                            @if($proyecto->archivo)
                                                <a href="{{ route('user.proyectos.descargar', $proyecto->id) }}"
                                                class="flex items-center gap-2 px-4 py-2 bg-orange-50 dark:bg-orange-500/10 text-orange-600 dark:text-orange-500 rounded-xl hover:bg-orange-600 hover:text-white dark:hover:bg-orange-600 dark:hover:text-white border border-orange-100 dark:border-orange-500/20 transition-all shadow-sm group/btn"
                                                title="Descargar archivo">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    <span class="text-[10px] font-black uppercase tracking-widest">PDF</span>
                                                </a>
                                            @endif

                                            <button @click="showModal = true"
                                                    class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 rounded-xl hover:bg-orange-50 dark:hover:bg-orange-500/20 hover:text-orange-600 transition-all"
                                                    title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <p class="text-[13px] text-slate-500 dark:text-slate-400 leading-relaxed line-clamp-2 mb-6 font-medium">
                                        {{ $proyecto->descripcion }}
                                    </p>

                                    {{-- Footer de la tarjeta --}}
                                    <div class="flex flex-wrap items-center justify-between gap-6 pt-5 border-t border-slate-50 dark:border-slate-800">
                                        <div class="flex items-center gap-4">
                                            <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full text-[10px] font-black uppercase tracking-widest {{ $proyecto->activo ? 'bg-orange-50 dark:bg-orange-500/10 text-orange-700 dark:text-orange-400 border border-orange-100 dark:border-orange-500/20' : 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20' }}">
                                                <span class="w-2 h-2 rounded-full {{ $proyecto->activo ? 'bg-orange-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                                {{ $proyecto->activo ? 'En progreso' : 'Finalizado' }}
                                            </span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-black uppercase tracking-widest">
                                                Entrega: {{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('d/m/Y') }}
                                            </span>
                                        </div>

                                        <form action="{{ route('user.proyectos.updateReport', $proyecto->id) }}" method="POST" class="flex items-center gap-3 flex-grow max-w-md">
                                            @csrf @method('PUT')
                                            <input type="text" name="reporte_trabajador" value="{{ $proyecto->reporte_trabajador }}"
                                                   class="w-full bg-slate-50 dark:bg-slate-800 border-transparent dark:text-white focus:border-orange-300 dark:focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 focus:ring-4 focus:ring-orange-500/5 rounded-2xl text-xs py-2.5 transition-all font-medium placeholder:dark:text-slate-600"
                                                   placeholder="Reporte de avance...">
                                            <button type="submit" class="bg-slate-900 dark:bg-orange-600 text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-600 dark:hover:bg-orange-500 shadow-xl shadow-slate-200 dark:shadow-none transition-all active:scale-95">
                                                Guardar
                                            </button>
                                            <a href="{{ route('user.proyectos.finalizar', $proyecto->id) }}"
                                               class="bg-emerald-500 text-white px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 shadow-xl shadow-emerald-100 dark:shadow-none transition-all active:scale-95">
                                                Finalizar
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- MODAL FLOTANTE OSCURO --}}
                            <div x-show="showModal"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 dark:bg-black/80 backdrop-blur-md"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100">

                                <div @click.away="showModal = false" class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-10 max-w-xl w-full shadow-2xl space-y-8 relative overflow-hidden border border-transparent dark:border-slate-800">
                                    <div class="absolute top-0 right-0 p-8 opacity-5 text-orange-600">
                                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14h-2V9h2v5zm0 4h-2v-2h2v2zM1 21h22L12 2 1 21z"/></svg>
                                    </div>

                                    <div class="flex justify-between items-start relative">
                                        <h2 class="text-2xl font-black text-slate-900 dark:text-white uppercase italic tracking-tighter">{{ $proyecto->titulo }}</h2>
                                        <button @click="showModal = false" class="p-2 bg-slate-50 dark:bg-slate-800 rounded-xl text-slate-400 hover:text-orange-600 transition-colors">✕</button>
                                    </div>

                                    <div class="space-y-6 relative">
                                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium leading-relaxed">{{ $proyecto->descripcion }}</p>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-orange-50/50 dark:bg-orange-500/5 p-4 rounded-2xl border border-orange-100 dark:border-orange-500/20">
                                                <span class="block text-[9px] uppercase font-black text-orange-400 tracking-widest mb-1">Inicio de Fase</span>
                                                <span class="font-black text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('d M, Y') }}</span>
                                            </div>
                                            <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                                                <span class="block text-[9px] uppercase font-black text-slate-400 dark:text-slate-500 tracking-widest mb-1">Cierre Previsto</span>
                                                <span class="font-black text-slate-700 dark:text-slate-200">{{ \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button @click="showModal = false" class="w-full py-4 bg-slate-900 dark:bg-orange-600 text-white font-black uppercase text-[10px] tracking-[0.2em] rounded-2xl hover:bg-orange-600 dark:hover:bg-orange-500 transition shadow-xl shadow-slate-200 dark:shadow-none">
                                        Cerrar Expediente
                                    </button>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- COLUMNA DERECHA: GESTIÓN --}}
                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-8">

                    {{-- Control de Asistencia --}}
                    <div class="bg-slate-900 dark:bg-slate-900 border border-transparent dark:border-slate-800 rounded-[2.5rem] p-8 text-white shadow-2xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-orange-600/10 rounded-full blur-3xl group-hover:bg-orange-600/20 transition-all duration-700"></div>

                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-500 mb-8 flex items-center gap-2">
                            <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                            Control de Asistencia
                        </h3>

                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-white/5 backdrop-blur-md p-5 rounded-[1.5rem] border border-white/5">
                                <p class="text-[9px] text-slate-500 dark:text-slate-500 uppercase font-black tracking-widest mb-1">Entrada</p>
                                <p class="text-2xl font-black font-mono text-orange-50">{{ ($asistencia && $asistencia->hora_entrada_real) ? \Carbon\Carbon::parse($asistencia->hora_entrada_real)->format('H:i') : '--:--' }}</p>
                            </div>
                            <div class="bg-white/5 backdrop-blur-md p-5 rounded-[1.5rem] border border-white/5">
                                <p class="text-[9px] text-slate-500 dark:text-slate-500 uppercase font-black tracking-widest mb-1">Salida</p>
                                <p class="text-2xl font-black font-mono text-orange-50">{{ ($asistencia && $asistencia->hora_salida) ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '--:--'}}</p>
                            </div>
                        </div>

                        @if($asistencia)
                            @if($asistencia->status === 'pendiente')
                                <form action="{{ route('user.asistencia.aceptar', $asistencia->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-orange-600 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-orange-500 transition shadow-xl shadow-orange-900/20 active:scale-95 italic">Aceptar Jornada</button>
                                </form>
                            @elseif($asistencia->status === 'aceptado')
                                <form action="{{ route('user.asistencia.marcarSalida', $asistencia->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-orange-600 hover:text-white transition shadow-xl active:scale-95 italic border-none">Finalizar Jornada</button>
                                </form>
                            @else
                                <div class="bg-emerald-500/10 border border-emerald-500/20 py-4 rounded-2xl">
                                    <p class="text-emerald-400 font-black text-center text-[10px] uppercase tracking-widest">Jornada {{ ucfirst($asistencia->status) }}</p>
                                </div>
                            @endif
                        @else
                            <p class="text-slate-500 text-[10px] text-center font-black uppercase tracking-widest italic py-4">No hay jornada programada</p>
                        @endif
                    </div>

                       <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
                            <h3 class="font-black text-slate-800 dark:text-white mb-6 uppercase tracking-tighter italic flex items-center gap-2">
                                <div class="w-1.5 h-6 bg-orange-600 rounded-full shadow-[0_0_10px_rgba(234,88,12,0.4)]"></div>
                                Mi Historial Reciente
                            </h3>

                            <div class="space-y-4">
                                {{-- Usamos @forelse para manejar el caso de que no haya datos --}}
                                @forelse($historialAsistencias as $registro)
                                    <div class="flex justify-between items-center py-4 border-b border-slate-50 dark:border-slate-800/50 last:border-0 group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 px-2 rounded-2xl transition-all duration-300">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                                {{ \Carbon\Carbon::parse($registro->fecha)->translatedFormat('d M, Y') }}
                                            </span>
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 capitalize">
                                                {{ \Carbon\Carbon::parse($registro->fecha)->translatedFormat('l') }}
                                            </span>
                                        </div>

                                        {{-- Badge de Status con estilo UPTAG --}}
                                        <span class="px-3 py-1 bg-slate-50 dark:bg-slate-800 rounded-lg text-[9px] font-black text-orange-600 dark:text-orange-500 uppercase border border-slate-100 dark:border-slate-700 group-hover:border-orange-500/30 transition-colors">
                                            {{ $registro->status }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="py-10 text-center">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No hay registros de asistencia aún</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    {{-- Bloc de Notas --}}
                    <div class="bg-orange-50 dark:bg-orange-500/5 rounded-[2.5rem] border border-orange-100 dark:border-orange-500/20 p-8 shadow-inner group">
                        <h3 class="font-black text-orange-900 dark:text-orange-400 mb-4 italic uppercase tracking-widest text-[10px] flex justify-between items-center">
                            Bloc de Notas
                            <svg class="w-4 h-4 text-orange-400 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2.5"/></svg>
                        </h3>
                        <textarea class="w-full bg-transparent border-0 focus:ring-0 text-[13px] text-orange-900 dark:text-orange-200/80 placeholder-orange-300 dark:placeholder-orange-800 p-0 resize-none font-medium leading-relaxed" rows="5" placeholder="Prioridades del día..."></textarea>
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
    }
    [x-cloak] { display: none !important; }
</style>
