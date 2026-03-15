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
                <div class="lg:col-span-8 space-y-8">
                    <h2 class="text-3xl font-black text-slate-950 tracking-tighter italic border-l-4 border-indigo-600 pl-4">
                        Mis Proyectos Asignados
                    </h2>

                    @foreach($misProyectos as $proyecto)
                        <article x-data="{ showModal: false }" class="bg-white border border-slate-200 rounded-3xl p-6 hover:border-indigo-300 transition-all duration-300 flex gap-6 shadow-sm hover:shadow-md">
                            
                            
                            @if($proyecto->imagen)
                                <div class="w-24 h-24 flex-shrink-0">
                                    <a href="{{ asset('storage/'.$proyecto->imagen) }}" target="_blank" class="block w-full h-full rounded-2xl overflow-hidden border border-slate-100 shadow-inner">
                                        <img src="{{ asset('storage/'.$proyecto->imagen) }}" alt="Proyecto" class="w-full h-full object-cover">
                                    </a>
                                </div>
                            @endif
                            

                            <div class="grid grid-cols-[1fr_auto] items-center gap-4 mb-3">
                                <div>
                                    <div class="flex justify-between items-start mb-3 gap-4">
                                        <h3 class="text-base font-bold text-slate-900 truncate min-w-0"> {{ $proyecto->titulo }}</h3>

                                        <div class="flex items-center gap-4"> 
                                            @if($proyecto->archivo_pdf)
                                                <a href="{{ route('user.user.proyectos.descargar', $proyecto->id) }}" 
                                                class="text-xs font-bold uppercase tracking-widest text-rose-500 hover:text-rose-700 whitespace-nowrap">
                                                    📄 PDF
                                                </a>
                                            @endif
                                            
                                            <button @click="showModal = true" 
                                                    class="text-[9px] font-bold uppercase tracking-widest text-indigo-500 hover:text-indigo-700 whitespace-nowrap">
                                                Ver detalles
                                            </button>
                                            
                                            <span class="text-[9px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full whitespace-nowrap {{ $proyecto->activo ? 'bg-indigo-50 text-indigo-600' : 'bg-emerald-50 text-emerald-600' }}">
                                                {{ $proyecto->activo ? 'En progreso' : 'Finalizado' }}
                                            </span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2">{{ $proyecto->descripcion }}</p>
                                </div>
                                
                                <form action="{{ route('user.proyectos.updateReport', $proyecto->id) }}" method="POST" class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between gap-4">
                                    @csrf @method('PUT')
                                    
                                    <input type="text" name="reporte_trabajador" value="{{ $proyecto->reporte_trabajador }}" 
                                        class="flex-grow bg-slate-50 border-0 rounded-lg text-[11px] px-3 py-2 focus:ring-1 focus:ring-indigo-200 transition" 
                                        placeholder="Añadir reporte...">
                                    
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        <button type="submit" class="px-3 py-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all">
                                            Guardar
                                        </button>
                                        <a href="{{ route('user.proyectos.finalizar', $proyecto->id) }}" 
                                            class="px-3 py-2 text-[10px] font-bold uppercase tracking-widest bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition shadow-sm hover:shadow-emerald-200">
                                            Finalizar
                                        </a>
                                    </div>
                                </form>
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