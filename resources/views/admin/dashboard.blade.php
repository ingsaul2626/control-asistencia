<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
            {{ __('Gestión de Proyectos - Administrador') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERTAS DE SESIÓN --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 shadow-sm animate-bounce rounded-r-xl font-bold text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl">
                    <p class="font-black uppercase text-xs tracking-widest mb-2">Error en el Registro:</p>
                    <ul class="list-disc ml-5 text-xs font-bold">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SECCIÓN 1: Formulario de Asignación --}}
            <div class="bg-white overflow-hidden shadow-2xl shadow-slate-200/60 sm:rounded-[2.5rem] p-8 mb-8 border border-white">
                <h3 class="text-sm font-black mb-6 text-uptag-orange flex items-center gap-2 uppercase tracking-[0.2em]">
                    <span class="text-xl">🚀</span> Vincular Proyecto y Trabajador
                </h3>
                <form action="{{ route('admin.proyectos.asignar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-uptag-orange transition-colors">Seleccionar Proyecto</label>
                            <select name="evento_id" required class="mt-1 block w-full rounded-2xl border-slate-100 shadow-sm focus:border-uptag-orange focus:ring-uptag-orange font-bold text-slate-600 text-sm h-[45px]">
                                <option value="">-- Elige un proyecto --</option>
                                @foreach($todosLosEventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-uptag-orange transition-colors">Asignar a Trabajador</label>
                            <select name="user_id" id="user_id" required class="mt-1 block w-full rounded-2xl border-slate-100 shadow-sm focus:border-uptag-orange focus:ring-uptag-orange font-bold text-slate-600 text-sm h-[45px]">
                                <option value="">Seleccione un trabajador</option>
                                @foreach($todosLosusuarios as $usuarios)
                                    <option value="{{ $usuarios->id }}">{{ $usuarios->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 group-hover:text-uptag-orange transition-colors">Subir Plano/PDF (Opcional)</label>
                            <input type="file" name="archivo" accept=".pdf" class="mt-1 block w-full text-xs text-slate-400 font-bold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-orange-50 file:text-uptag-orange hover:file:bg-orange-100 transition-all">
                        </div>
                    </div>
                    <div class="mt-8 text-right">
                        <button type="submit" class="bg-uptag-orange text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-orange-200 hover:shadow-slate-200">
                            Vincular y Guardar
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECCIÓN 2: Proyectos Activos --}}
            <div class="bg-white/50 overflow-hidden sm:rounded-[2.5rem] p-4 border border-slate-100">
                <h3 class="text-[11px] font-black mb-8 px-4 flex items-center gap-3 uppercase tracking-[0.3em] text-slate-400">
                    <span class="p-2 bg-white rounded-xl shadow-sm">📋</span> Proyectos Activos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($todosLosEventos as $evento)
                        <div class="group bg-white rounded-[2rem] p-6 shadow-sm hover:shadow-2xl transition-all duration-500 border border-slate-50 border-l-4 {{ $evento->archivo ? 'border-l-emerald-400' : 'border-l-uptag-orange' }}">
                            <div class="flex justify-between items-start mb-5">
                                <h4 class="font-black text-slate-800 text-sm uppercase tracking-tighter leading-tight group-hover:text-uptag-orange transition-colors">{{ $evento->titulo }}</h4>
                                <form action="{{ route('admin.proyectos.destroy', $evento->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este proyecto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-200 hover:text-red-500 transition-colors p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-2xl bg-orange-50 flex items-center justify-center text-uptag-orange font-black text-xs shadow-inner">
                                        {{ substr($evento->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="leading-tight">
                                        <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Encargado</p>
                                        <p class="font-bold text-slate-700 text-sm italic">{{ $evento->user->name ?? 'No asignado' }}</p>
                                    </div>
                                </div>
                                <div class="bg-slate-50/80 p-3 rounded-2xl flex items-center justify-between">
                                    <span class="text-[9px] text-slate-400 font-black uppercase tracking-widest">Fecha:</span>
                                    <span class="font-bold text-slate-600 text-xs">{{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}</span>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between items-center pt-4 border-t border-slate-50">
                                <a href="{{ route('admin.proyectos.edit', $evento->id) }}" class="text-slate-400 font-black hover:text-uptag-orange text-[10px] uppercase tracking-widest flex items-center gap-2 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Editar
                                </a>
                                @if($evento->archivo)
                                    <a href="{{ asset('storage/' . $evento->archivo) }}" target="_blank" class="bg-emerald-50 text-emerald-600 text-[9px] px-4 py-1.5 rounded-full font-black uppercase tracking-widest hover:bg-emerald-100 transition-all shadow-sm">Ver Plano</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20 bg-white/40 rounded-[3rem] border-4 border-dashed border-white shadow-inner">
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">No hay proyectos activos en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- GLOVITO DE NOTIFICACIONES (NARANJA) --}}
    <div class="fixed bottom-8 left-8 z-[100]">
        <button onclick="toggleAvances()" class="p-5 bg-slate-900 hover:bg-uptag-orange text-white rounded-2xl shadow-2xl transition-all duration-300 flex items-center gap-3 font-black uppercase text-[10px] tracking-widest border-4 border-white group">
            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
            Reportes de Hoy

            @if(isset($reportesRecientes) && $reportesRecientes->count() > 0)
                <span class="bg-uptag-orange group-hover:bg-white group-hover:text-uptag-orange text-white px-2.5 py-1 rounded-lg text-[10px] font-black animate-pulse transition-colors">
                    {{ $reportesRecientes->count() }}
                </span>
            @endif
        </button>

        <div id="popAvances" class="hidden absolute bottom-20 left-0 w-80 md:w-96 bg-white border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.1)] rounded-[2.5rem] overflow-hidden animate-fade-in-up transition-all backdrop-blur-xl">
            <div class="bg-slate-900 p-5 flex justify-between items-center text-white">
                <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-orange-400">Actividad Reciente</h3>
                <button onclick="toggleAvances()" class="text-white/50 hover:text-white transition-colors text-2xl">&times;</button>
            </div>

            <div class="max-h-96 overflow-y-auto p-5 space-y-4 bg-slate-50/30">
                @forelse($reportesRecientes as $r)
                    <div class="bg-white p-5 rounded-3xl border border-slate-50 shadow-sm group hover:border-orange-200 transition-all">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[9px] font-black text-uptag-orange uppercase tracking-widest">{{ $r->user->name ?? 'usuarios' }}</span>
                            <span class="text-[9px] font-bold text-slate-300">{{ $r->updated_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-medium italic leading-relaxed">"{{ $r->reporte_trabajador }}"</p>
                    </div>
                @empty
                    <div class="text-center py-10 text-slate-400 font-black uppercase text-[9px] tracking-widest">No hay reportes nuevos hoy.</div>
                @endforelse
            </div>
        </div>
    </div>

@push('scripts')
<script>
    function toggleAvances() {
        const popup = document.getElementById('popAvances');
        if (popup) {
            popup.classList.toggle('hidden');
        }
    }

    window.onclick = function(event) {
        const popup = document.getElementById('popAvances');
        if (popup && !popup.contains(event.target) && !event.target.closest('button')) {
            popup.classList.add('hidden');
        }
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === "Escape") document.getElementById('popAvances')?.classList.add('hidden');
    });
</script>
@endpush
</x-app-layout>
