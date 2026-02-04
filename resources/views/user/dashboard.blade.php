<x-app-layout>
    @php
        $asistencia = \App\Models\Asistencia::where('user_id', auth()->id())
                        ->whereDate('fecha', now()->toDateString())
                        ->first();
        $status = $asistencia ? $asistencia->status : 'por_asignar';
    @endphp

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SECCIÓN SUPERIOR: CONTROL DE ASISTENCIA --}}
            <div class="mb-12">
                <div class="relative overflow-hidden bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.04)] rounded-[2.5rem] p-1">
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

                    <div class="relative p-8">
                        <header class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Mi Jornada</h2>
                                <p class="text-slate-400 text-sm font-medium">{{ now()->translatedFormat('l, d \d\e F') }}</p>
                            </div>
                            <div class="h-12 w-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                <i class="fas fa-user-clock text-xl"></i>
                            </div>
                        </header>

                        <div class="grid grid-cols-1 md:grid-cols-1 items-center">
                            {{-- CASO 1: POR ASIGNAR --}}
                            @if($status === 'por_asignar')
                                <div class="text-center py-10 animate-pulse">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <i class="fas fa-clock text-slate-300 text-3xl"></i>
                                    </div>
                                    <h3 class="text-slate-500 font-bold uppercase tracking-widest text-xs">Estado: Pendiente</h3>
                                    <p class="text-slate-400 text-sm mt-2 italic">El administrador está preparando tu horario...</p>
                                </div>

                            {{-- CASO 2: ASIGNADO (Admin ya asignó) --}}
                            @elseif(($status === 'finalizado' || $status === 'presente') && !$asistencia->hora_salida)
                                <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-[2rem] p-8 text-white shadow-xl shadow-indigo-100 flex flex-col md:flex-row items-center justify-between">
                                    <div class="mb-6 md:mb-0 text-center md:text-left">
                                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-200">Entrada Programada</span>
                                        <h3 class="text-5xl font-black mt-2">{{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('g:i A') }}</h3>
                                    </div>
                                    <form action="{{ route('usuario.asistencias.aceptar') }}" method="POST" class="w-full md:w-auto">
                                        @csrf
                                        <button type="submit" class="w-full bg-white text-indigo-700 font-black py-4 px-10 rounded-2xl shadow-lg hover:bg-indigo-50 transition-all transform active:scale-95">
                                            ACEPTAR E INICIAR TURNO
                                        </button>
                                    </form>
                                </div>

                            {{-- CASO 3: EN PROGRESO --}}
                            @elseif($status === 'en_progreso')
                                <div class="bg-emerald-500 rounded-[2rem] p-8 text-white shadow-xl shadow-emerald-100 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                                    <div class="relative z-10 text-center md:text-left mb-6 md:mb-0">
                                        <div class="flex items-center gap-2 mb-2 justify-center md:justify-start">
                                            <span class="relative flex h-3 w-3">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
                                            </span>
                                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Trabajando ahora</span>
                                        </div>
                                        <h3 class="text-4xl font-black">Desde las {{ \Carbon\Carbon::parse($asistencia->hora_entrada)->format('g:i A') }}</h3>
                                    </div>
                                    <form action="{{ route('usuario.asistencias.salida') }}" method="POST" class="w-full md:w-auto relative z-10">
                                        @csrf
                                        <button type="submit" class="w-full bg-emerald-900/20 backdrop-blur-md border border-white/40 text-white font-black py-4 px-10 rounded-2xl hover:bg-emerald-900/40 transition-all">
                                            REGISTRAR SALIDA
                                        </button>
                                    </form>
                                    <i class="fas fa-briefcase absolute -bottom-10 -right-5 text-white/10 text-[12rem]"></i>
                                </div>

                            {{-- CASO 4: FALTA --}}
                            @elseif($status === 'ausente')
                                <div class="bg-red-50 border border-red-100 rounded-[2rem] p-8 text-center">
                                    <i class="fas fa-user-times text-red-500 text-4xl mb-3"></i>
                                    <h3 class="text-red-800 font-black text-xl uppercase">Inasistencia Registrada</h3>
                                    <p class="text-red-500 text-sm">Tu asistencia no fue marcada el día de hoy.</p>
                                </div>

                            {{-- CASO 5: FINALIZADO --}}
                            @else
                                <div class="bg-slate-900 rounded-[2rem] p-8 text-white shadow-2xl flex flex-col md:flex-row items-center justify-between">
                                    <div class="flex items-center gap-5">
                                        <div class="h-16 w-16 bg-emerald-500 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30">
                                            <i class="fas fa-check text-2xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-black italic">¡Comienza la jornada!</h3>
                                            <p class="text-slate-400 text-sm">Tu jornada de hoy finalizara.</p>
                                        </div>
                                    </div>
                                    <div class="mt-6 md:mt-0 text-center md:text-right border-l border-slate-700 pl-6">
                                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Salida registrada</p>
                                        <p class="text-2xl font-black text-emerald-400">{{ \Carbon\Carbon::parse($asistencia->hora_salida)->format('g:i A') }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECCIÓN INFERIOR: TAREAS ASIGNADAS --}}
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-black text-slate-800 tracking-tight flex items-center gap-3">
                    <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                    Mis Tareas Asignadas
                </h2>
                @if(session('success'))
                    <div class="animate-bounce bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full text-xs font-bold border border-emerald-200">
                        ✓ {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                @forelse($misEventos as $proyecto)
                    <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-sm border border-slate-100 hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500 flex flex-col h-full">

                        {{-- Imagen del Proyecto con Overlay --}}
                        <div class="relative h-56 overflow-hidden">
                            @if($proyecto->imagen)
                                <img src="{{ asset('storage/' . $proyecto->imagen) }}" alt="{{ $proyecto->titulo }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-300 uppercase font-black tracking-tighter text-4xl">
                                    {{ substr($proyecto->titulo, 0, 2) }}
                                </div>
                            @endif
                            <div class="absolute top-4 right-4">
                                <span class="bg-white/90 backdrop-blur text-slate-800 text-[10px] font-black px-4 py-2 rounded-xl shadow-sm uppercase tracking-wider">
                                    ID: #{{ $proyecto->id }}
                                </span>
                            </div>
                        </div>

                        <div class="p-8 flex flex-col flex-grow">
                            <h3 class="font-black text-2xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $proyecto->titulo }}</h3>
                            <p class="text-slate-400 text-xs font-bold mb-6 flex items-center gap-2 uppercase tracking-widest">
                                <i class="far fa-clock"></i> Actualizado: {{ $proyecto->updated_at->diffForHumans() }}
                            </p>

                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 mb-8 flex-grow">
                                <label class="text-[10px] font-black text-indigo-500 uppercase tracking-widest block mb-2">Instrucciones</label>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    {{ $proyecto->descripcion ?? 'Sin instrucciones adicionales asignadas.' }}
                                </p>
                            </div>

                            {{-- Documentación --}}
                            <div class="mb-8">
                                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Documentación Técnica</h4>
                                @if($proyecto->archivo)
                                    <div class="flex items-center p-4 bg-white border border-slate-100 rounded-2xl group/file hover:border-indigo-200 transition-colors">
                                        <div class="h-10 w-10 bg-red-50 text-red-500 rounded-xl flex items-center justify-center mr-4 group-hover/file:bg-red-500 group-hover/file:text-white transition-all">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-sm font-bold text-slate-700">Plano Técnico</p>
                                            <p class="text-[10px] text-slate-400 italic uppercase">Documento PDF</p>
                                        </div>
                                        <a href="{{ asset('storage/' . $proyecto->archivo) }}" download class="bg-slate-900 text-white text-[10px] font-black px-4 py-2 rounded-xl hover:bg-indigo-600 transition-colors">
                                            DESCARGAR
                                        </a>
                                    </div>
                                @else
                                    <p class="text-xs text-slate-300 italic">No hay archivos adjuntos para esta tarea.</p>
                                @endif
                            </div>

                            {{-- Reporte --}}
                            <form action="{{ route('user.reportar', $proyecto->id) }}" method="POST" class="mt-auto">
                                @csrf
                                <label class="text-[10px] font-black text-slate-800 uppercase tracking-widest block mb-3">Tu Reporte de Avance</label>
                                <textarea name="reporte_trabajador" rows="3" class="w-full rounded-2xl border-slate-200 bg-slate-50 text-sm focus:ring-indigo-500 focus:border-indigo-500 mb-4 transition-all" placeholder="Detalla los avances realizados...">{{ $proyecto->reporte_trabajador }}</textarea>
                                <button type="submit" class="w-full bg-indigo-600 text-white text-xs font-black py-4 rounded-2xl uppercase tracking-[0.2em] shadow-lg shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95">
                                    Actualizar Avance
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="bg-white rounded-[3rem] p-12 border border-dashed border-slate-300 inline-block mx-auto">
                            <i class="fas fa-tasks text-slate-200 text-6xl mb-4"></i>
                            <h3 class="text-slate-400 font-bold uppercase tracking-widest">Sin tareas activas</h3>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const confirmarAccion = (formId, titulo, texto, icono, colorBtn) => {
                const formulario = document.querySelector(`form[action*="${formId}"]`);
                if (formulario) {
                    formulario.addEventListener('submit', function(e) {
                        e.preventDefault();
                        Swal.fire({
                            title: titulo,
                            text: texto,
                            icon: icono,
                            showCancelButton: true,
                            confirmButtonColor: colorBtn,
                            confirmButtonText: 'Confirmar',
                            cancelButtonText: 'Cancelar',
                            customClass: {
                                popup: 'rounded-[2.5rem]',
                                confirmButton: 'rounded-xl font-bold px-6 py-3',
                                cancelButton: 'rounded-xl font-bold px-6 py-3'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                }
            };

            confirmarAccion('aceptar', '¿Iniciar Turno?', 'Se confirmará tu entrada a las {{ now()->format("g:i A") }}', 'question', '#4f46e5');
            confirmarAccion('salida', '¿Finalizar Jornada?', 'Se cerrará tu turno de hoy.', 'warning', '#10b981');
        });
    </script>
</x-app-layout>
