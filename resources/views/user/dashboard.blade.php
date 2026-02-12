<x-app-layout>
    @php
        $userId = auth()->id();
        $mesActual = now()->month;

        $asistencia = \App\Models\Asistencia::where('user_id', $userId)
                        ->whereDate('fecha', now()->toDateString())
                        ->first();
        $status = $asistencia ? $asistencia->status : 'por_asignar';

        $historialAsistencias = \App\Models\Asistencia::where('user_id', $userId)
                                ->whereMonth('fecha', $mesActual)
                                ->orderBy('fecha', 'desc')
                                ->get();

        $totalHorasMes = $historialAsistencias->sum(function($a) {
             if($a->hora_entrada && $a->hora_salida) {
                $e = \Carbon\Carbon::parse($a->hora_entrada);
                $s = \Carbon\Carbon::parse($a->hora_salida);
                return round($e->diffInMinutes($s) / 60, 1);
             }
             return 0;
        });
        $diasAsistidos = $historialAsistencias->where('status', 'finalizado')->count();
    @endphp

    <div class="py-6 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- CABECERA COMPACTA --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter">
                        Hola, {{ explode(' ', auth()->user()->name)[0] }} 👋
                    </h1>
                    <p class="text-slate-500 text-sm font-medium italic">Gestión de proyectos y actividades.</p>
                </div>
                <div class="bg-white px-5 py-2 rounded-xl border border-slate-100 shadow-sm">
                    <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest block">Periodo</span>
                    <span class="text-slate-800 text-sm font-bold italic">{{ now()->translatedFormat('F, Y') }}</span>
                </div>
            </div>

            {{-- MÉTRICAS (MÁS PEQUEÑAS) --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $metrics = [
                        ['label' => 'Horas Mes', 'val' => $totalHorasMes . 'h', 'icon' => 'fa-stopwatch', 'col' => 'indigo'],
                        ['label' => 'Días', 'val' => $diasAsistidos, 'icon' => 'fa-calendar-check', 'col' => 'emerald'],
                        ['label' => 'Proyectos', 'val' => $misEventos->count(), 'icon' => 'fa-tasks', 'col' => 'orange'],
                        ['label' => 'Puntualidad', 'val' => '100%', 'icon' => 'fa-chart-line', 'col' => 'blue'],
                    ];
                @endphp
                @foreach($metrics as $m)
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-{{$m['col']}}-50 rounded-lg flex items-center justify-center text-{{$m['col']}}-600 group-hover:bg-{{$m['col']}}-600 group-hover:text-white transition-all">
                            <i class="fas {{$m['icon']}} text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-tighter leading-none">{{$m['label']}}</p>
                            <h4 class="text-lg font-black text-slate-800 leading-tight">{{$m['val']}}</h4>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- COLUMNA PROYECTOS (PUNTO MEDIO) --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight italic">Proyectos</h2>
                    </div>

                    @forelse($misEventos as $proyecto)
                        <div class="group bg-white rounded-[2.5rem] border border-slate-100 hover:border-indigo-100 transition-all shadow-sm overflow-hidden">
                            <div class="flex flex-col md:flex-row">

                                {{-- Imagen ajustada --}}
                                <div class="md:w-56 flex-shrink-0 relative overflow-hidden bg-slate-50 p-4">
                                    @if($proyecto->imagen)
                                        <img src="{{ asset('storage/' . $proyecto->imagen) }}" class="w-full h-48 md:h-full object-cover rounded-3xl shadow-sm">
                                    @else
                                        <div class="w-full h-48 md:h-full flex items-center justify-center bg-white rounded-3xl border border-dashed border-slate-200">
                                            <i class="fas fa-project-diagram text-slate-200 text-3xl"></i>
                                        </div>
                                    @endif
                                </div>

                                {{-- Contenido equilibrado --}}
                                <div class="flex-1 p-6 md:p-8">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        <p class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Activo</p>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-800 italic mb-4 leading-tight">{{ $proyecto->titulo }}</h3>

                                    <div class="bg-slate-50/50 rounded-2xl p-4 border border-slate-100 mb-6 text-sm text-slate-600 italic">
                                        {{ Str::limit($proyecto->descripcion ?? 'Sin especificaciones.', 120) }}
                                    </div>

                                    {{-- PDF estilo botón moderno pero discreto --}}
                                    @if($proyecto->archivo)
                                    <div class="mb-6">
                                        <a href="{{ asset('storage/' . $proyecto->archivo) }}" download
                                           class="inline-flex items-center gap-3 p-2 pr-5 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-500 group/pdf transition-all shadow-sm">
                                            <div class="h-9 w-9 bg-white text-rose-500 rounded-lg flex items-center justify-center shadow-sm">
                                                <i class="fas fa-file-pdf text-sm"></i>
                                            </div>
                                            <span class="text-xs font-black text-rose-800 group-hover/pdf:text-white uppercase tracking-tighter">Descargar PDF</span>
                                        </a>
                                    </div>
                                    @endif

                                    {{-- Reporte compacto --}}
                                    <form action="{{ route('user.reportar', $proyecto->id) }}" method="POST">
                                        @csrf
                                        <div class="relative">
                                            <textarea name="reporte_trabajador" rows="1"
                                                class="w-full rounded-xl border-slate-100 bg-slate-50 text-xs focus:ring-indigo-500 focus:border-indigo-500 pr-28 transition-all py-3 px-4 shadow-inner italic"
                                                placeholder="Resumen del avance...">{{ $proyecto->reporte_trabajador }}</textarea>
                                            <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 bg-slate-900 text-white text-[9px] font-black px-4 rounded-lg uppercase tracking-widest hover:bg-indigo-600 transition-all">
                                                Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center bg-white rounded-[2rem] border border-dashed border-slate-200">
                             <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest italic">No hay proyectos activos</p>
                        </div>
                    @endforelse
                </div>

                {{-- BITÁCORA (LATERAL COMPACTO) --}}
                <div class="lg:col-span-4">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1.5 h-6 bg-slate-800 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight italic">Bitácora</h2>
                    </div>

                    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden h-[600px] flex flex-col">
                        <div class="p-5 bg-slate-50/50 border-b border-slate-100">
                            <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Historial</h3>
                        </div>
                        <div class="overflow-y-auto flex-1 p-4 space-y-3 custom-scrollbar">
                            @foreach($historialAsistencias as $registro)
                                <div class="p-4 rounded-2xl border border-slate-50 hover:bg-slate-50 transition-all">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-[10px] font-black text-slate-800 italic">{{ \Carbon\Carbon::parse($registro->fecha)->translatedFormat('d M, Y') }}</span>
                                        <span class="text-[8px] font-black px-2 py-0.5 {{ $registro->status == 'finalizado' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} rounded-md uppercase">
                                            {{ $registro->status }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3 text-slate-500 text-[10px] font-bold">
                                        <div class="flex items-center gap-1">
                                            <i class="far fa-clock text-indigo-400"></i>
                                            {{ $registro->hora_entrada ? \Carbon\Carbon::parse($registro->hora_entrada)->format('H:i') : '--:--' }}
                                        </div>
                                        <i class="fas fa-arrow-right text-[8px] opacity-20"></i>
                                        <div>
                                            {{ $registro->hora_salida ? \Carbon\Carbon::parse($registro->hora_salida)->format('H:i') : '--:--' }}
                                        </div>
                                        <div class="ml-auto font-black text-slate-900 bg-white px-2 py-0.5 rounded border border-slate-100 shadow-sm">
                                            @if($registro->hora_entrada && $registro->hora_salida)
                                                {{ round(\Carbon\Carbon::parse($registro->hora_entrada)->diffInMinutes(\Carbon\Carbon::parse($registro->hora_salida)) / 60, 1) }}h
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</x-app-layout>
