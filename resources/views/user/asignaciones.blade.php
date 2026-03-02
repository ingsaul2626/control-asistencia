<x-app-layout>
    @php
        // Configuración de idioma y datos iniciales
        \Carbon\Carbon::setLocale('es');
        $user = auth()->user();
        $userId = $user->id;
        $mesActual = now()->month;

        // 1. Buscamos la asistencia de hoy
        $asistencia = \App\Models\Asistencia::where('user_id', $userId)
                        ->whereDate('fecha', now()->toDateString())
                        ->first();
        $status = $asistencia ? $asistencia->status : 'por_asignar';

        // 2. Historial del mes (Bitácora)
        $historialAsistencias = \App\Models\Asistencia::where('user_id', $userId)
                                ->whereMonth('fecha', $mesActual)
                                ->orderBy('fecha', 'desc')
                                ->get();

        // 3. El registro más reciente para el "Horario Asignado"
        $ultimoRegistro = $historialAsistencias->first();

        // 4. Cálculos de métricas
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

    <div class="py-6 bg-[#f8fafc] min-h-screen" x-data="{ openProject: null }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- CABECERA --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter">
                        Hola, {{ explode(' ', $user->name)[0] }} 👋
                    </h1>
                    <p class="text-slate-500 text-sm font-medium italic">Gestión de proyectos y notas personales.</p>
                </div>
                <div class="flex gap-3">
                    <div class="bg-white px-5 py-2 rounded-xl border border-slate-100 shadow-sm">
                        <span class="text-[9px] font-black text-indigo-500 uppercase tracking-widest block">Periodo</span>
                        <span class="text-slate-800 text-sm font-bold italic">
                            {{ now()->translatedFormat('F, Y') }} {{-- Ejemplo: Marzo, 2024 --}}
                        </span>
                    </div>
                </div>
            </div>

            {{-- MÉTRICAS --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @php
                    $metrics = [
                        ['label' => 'Horas del Mes', 'val' => $totalHorasMes . 'h', 'icon' => 'fa-stopwatch', 'col' => 'indigo'],
                        ['label' => 'Días Laborados', 'val' => $diasAsistidos, 'icon' => 'fa-calendar-check', 'col' => 'emerald'],
                        ['label' => 'Proyectos', 'val' => count($misEventos ?? []), 'icon' => 'fa-tasks', 'col' => 'orange'],
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

                {{-- COLUMNA IZQUIERDA: PROYECTOS --}}
                <div class="lg:col-span-8 space-y-6">
                    {{-- BLOC DE NOTAS RÁPIDO --}}
                    <div class="bg-amber-50/50 border border-amber-100 rounded-[2rem] p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-3">
                            <i class="fas fa-sticky-note text-amber-500"></i>
                            <h3 class="text-sm font-black text-amber-800 uppercase tracking-widest italic">Bloc de Notas Personal</h3>
                        </div>
                        <textarea
                            id="userNotes"
                            class="w-full bg-transparent border-none focus:ring-0 text-amber-900/80 placeholder-amber-300 text-sm italic leading-relaxed resize-none custom-scrollbar"
                            rows="3"
                            placeholder="Escribe recordatorios o pendientes aquí..."
                            oninput="localStorage.setItem('user_notes_' + {{ $userId }}, this.value)"
                        ></textarea>
                        <script>
                            document.getElementById('userNotes').value = localStorage.getItem('user_notes_' + {{ $userId }}) || '';
                        </script>
                    </div>

                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight italic">Mis Proyectos</h2>
                    </div>

                    @forelse($misEventos ?? [] as $proyecto)
                        <div class="group bg-white rounded-[2.5rem] border border-slate-100 hover:border-indigo-100 transition-all shadow-sm overflow-hidden">
                            <div class="flex flex-col md:flex-row">
                                <div class="md:w-56 flex-shrink-0 relative overflow-hidden bg-slate-50 p-4">
                                    @if($proyecto->imagen)
                                        <img src="{{ asset('storage/' . $proyecto->imagen) }}" class="w-full h-48 md:h-full object-cover rounded-3xl shadow-sm">
                                    @else
                                        <div class="w-full h-48 md:h-full flex items-center justify-center bg-white rounded-3xl border border-dashed border-slate-200">
                                            <i class="fas fa-project-diagram text-slate-200 text-3xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 p-6 md:p-8">
                                    <h3 class="text-2xl font-black text-slate-800 italic mb-4 leading-tight">{{ $proyecto->titulo }}</h3>
                                    <div class="mb-6">
                                        <div :class="openProject === {{ $proyecto->id }} ? '' : 'line-clamp-3'" class="text-sm text-slate-600 italic leading-relaxed transition-all duration-300">
                                            {!! nl2br(e($proyecto->descripcion ?? 'Sin especificaciones detalladas.')) !!}
                                        </div>
                                        <button @click="openProject = (openProject === {{ $proyecto->id }} ? null : {{ $proyecto->id }})" class="mt-2 text-[10px] font-black text-indigo-500 uppercase tracking-widest hover:text-indigo-700 flex items-center gap-1">
                                            <span x-text="openProject === {{ $proyecto->id }} ? 'Mostrar menos' : 'Leer descripción completa'"></span>
                                            <i class="fas" :class="openProject === {{ $proyecto->id }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                                        </button>
                                    </div>

                                    @if($proyecto->archivo)
                                    <div class="mb-6">
                                        <a href="{{ asset('storage/' . $proyecto->archivo) }}" download class="inline-flex items-center gap-3 p-2 pr-5 bg-rose-50 border border-rose-100 rounded-xl hover:bg-rose-500 group/pdf transition-all shadow-sm">
                                            <div class="h-9 w-9 bg-white text-rose-500 rounded-lg flex items-center justify-center shadow-sm">
                                                <i class="fas fa-file-pdf text-sm"></i>
                                            </div>
                                            <span class="text-xs font-black text-rose-800 group-hover/pdf:text-white uppercase tracking-tighter">Guía Técnica PDF</span>
                                        </a>
                                    </div>
                                    @endif

                                    <form action="{{ route('user.reportar', $proyecto->id) }}" method="POST">
                                        @csrf
                                        <div class="relative">
                                            <textarea name="reporte_trabajador" rows="1" class="w-full rounded-xl border-slate-100 bg-slate-50 text-xs focus:ring-indigo-500 focus:border-indigo-500 pr-28 transition-all py-3 px-4 shadow-inner italic" placeholder="Resumen de tu avance...">{{ $proyecto->reporte_trabajador }}</textarea>
                                            <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 bg-slate-900 text-white text-[9px] font-black px-4 rounded-lg uppercase tracking-widest hover:bg-indigo-600 transition-all">Reportar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center bg-white rounded-[2rem] border border-dashed border-slate-200">
                             <p class="text-slate-400 font-black uppercase text-[10px] tracking-widest italic">No tienes proyectos asignados</p>
                        </div>
                    @endforelse
                </div>

                {{-- COLUMNA DERECHA: HORARIO Y BITÁCORA --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- TARJETA DE HORARIO ASIGNADO (DINÁMICA DE LA BITÁCORA) --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight italic">Mi Horario</h2>
                        </div>

                        <div class="bg-indigo-900 rounded-[2.5rem] p-6 text-white shadow-lg shadow-indigo-200 relative overflow-hidden">
                            <i class="fas fa-calendar-day absolute -right-4 -bottom-4 text-indigo-800 text-8xl opacity-30 rotate-12"></i>

                            <div class="relative z-10">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-300 mb-1">
                                    @if($ultimoRegistro && $ultimoRegistro->fecha == now()->toDateString())
                                        Jornada de Hoy ({{ \Carbon\Carbon::parse($ultimoRegistro->fecha)->translatedFormat('d M') }})
                                    @else
                                        Última Jornada Asignada
                                    @endif
                                </p>

                                <div class="flex items-baseline gap-2">
                                    <h3 class="text-3xl font-black italic tracking-tighter">
                                        @if($ultimoRegistro && $ultimoRegistro->hora_entrada && $ultimoRegistro->hora_salida)
                                            {{ \Carbon\Carbon::parse($ultimoRegistro->hora_entrada)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($ultimoRegistro->hora_salida)->format('H:i') }}
                                        @else
                                            <span class="text-xl">Sin horario registrado</span>
                                        @endif
                                    </h3>
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    @if($ultimoRegistro)
                                        <span class="text-[9px] font-black px-3 py-1 rounded-full border border-white/20 uppercase tracking-widest {{ $ultimoRegistro->status == 'finalizado' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }}">
                                            Estado: {{ $ultimoRegistro->status == 'finalizado' ? 'Completado' : 'En curso' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BITÁCORA (Actividad Reciente) --}}
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-1.5 h-6 bg-slate-800 rounded-full"></div>
                            <h2 class="text-2xl font-black text-slate-800 tracking-tight italic">Bitácora</h2>
                        </div>
                        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden h-[550px] flex flex-col">
                            <div class="p-5 bg-slate-50/50 border-b border-slate-100">
                                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Actividad Reciente</h3>
                            </div>
                            <div class="overflow-y-auto flex-1 p-4 space-y-3 custom-scrollbar">
                                @foreach($historialAsistencias as $registro)
                                    <div class="p-4 rounded-2xl border border-slate-50 hover:bg-slate-50 transition-all group/item">
                                        <div class="flex justify-between items-center mb-2">
                                            {{-- FECHA FORMATO LATINO --}}
                                            <span class="text-[10px] font-black text-slate-800 italic">
                                                {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}
                                            </span>
                                            <span class="text-[8px] font-black px-2 py-0.5 {{ $registro->status == 'finalizado' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }} rounded-md uppercase">
                                                {{ $registro->status == 'finalizado' ? 'Completado' : $registro->status }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-3 text-slate-500 text-[10px] font-bold">
                                            <div class="flex items-center gap-1">
                                                <i class="far fa-clock text-indigo-400"></i>
                                                {{ $registro->hora_entrada ? \Carbon\Carbon::parse($registro->hora_entrada)->format('H:i') : '--:--' }}
                                            </div>
                                            <i class="fas fa-arrow-right text-[8px] opacity-20 group-hover/item:opacity-100 transition-opacity"></i>
                                            <div>{{ $registro->hora_salida ? \Carbon\Carbon::parse($registro->hora_salida)->format('H:i') : '--:--' }}</div>

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
    </div>

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
</x-app-layout>
