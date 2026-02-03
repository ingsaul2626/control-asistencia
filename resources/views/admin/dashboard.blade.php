<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Proyectos - Administrador
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERTAS DE SESIÓN --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm animate-bounce">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                    <p class="font-bold">Error en el Registro:</p>
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SECCIÓN 1: Formulario de Asignación --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-8 border border-gray-100">
                <h3 class="text-lg font-bold mb-4 text-indigo-700 flex items-center gap-2">
                    <span>🚀</span> Vincular Proyecto y Trabajador
                </h3>
                <form action="{{ route('admin.proyectos.asignar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Seleccionar Proyecto</label>
                            <select name="evento_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Elige un proyecto --</option>
                                @foreach($todosLosEventos as $evento)
                                    <option value="{{ $evento->id }}">{{ $evento->titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Asignar a Trabajador</label>
                            <select name="user_id" id="user_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Seleccione un trabajador</option>
                                @foreach($todosLosUsuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Subir Plano/PDF (Opcional)</label>
                            <input type="file" name="archivo" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg">
                            Vincular y Guardar
                        </button>
                    </div>
                </form>
            </div>

            {{-- SECCIÓN 2: Proyectos Activos --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-100">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <span class="p-2 bg-gray-100 rounded-lg">📋</span> Proyectos Activos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($todosLosEventos as $evento)
                        <div class="group border rounded-xl p-5 bg-white shadow-sm hover:shadow-xl transition-all duration-300 border-l-4 {{ $evento->archivo ? 'border-l-green-500' : 'border-l-indigo-400' }}">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-black text-gray-800 text-md uppercase tracking-tighter">{{ $evento->titulo }}</h4>
                                <form action="{{ route('admin.proyectos.destroy', $evento->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este proyecto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                        {{ substr($evento->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <p class="text-sm leading-tight">
                                        <span class="text-xs text-gray-400 font-bold uppercase">Encargado</span><br>
                                        <span class="font-semibold text-gray-700">{{ $evento->user->name ?? 'No asignado' }}</span>
                                    </p>
                                </div>
                                <p class="text-sm bg-gray-50 p-2 rounded-lg">
                                    <span class="text-[10px] text-gray-400 font-bold uppercase">Fecha:</span>
                                    <span class="font-medium text-gray-600">{{ \Carbon\Carbon::parse($evento->fecha)->format('d M, Y') }}</span>
                                </p>
                            </div>
                            <div class="mt-4 flex justify-between items-center pt-4 border-t border-gray-50">
                                <a href="{{ route('admin.proyectos.edit', $evento->id) }}" class="text-indigo-600 font-bold hover:text-indigo-800 text-xs flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Editar
                                </a>
                                @if($evento->archivo)
                                    <a href="{{ asset('storage/' . $evento->archivo) }}" target="_blank" class="bg-green-100 text-green-700 text-[10px] px-3 py-1 rounded-full font-bold hover:bg-green-200 transition-colors">Ver Plano</a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 italic">No hay proyectos activos en este momento.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

   {{-- GLOVITO DE NOTIFICACIONES --}}
<div class="fixed bottom-6 left-6 z-[100]">
    <button onclick="toggleAvances()" class="p-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg shadow-2xl transition-all flex items-center gap-2 font-bold uppercase text-[10px] tracking-widest border-2 border-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
        </svg>
        Reportes de Hoy

        @if(isset($reportesRecientes) && $reportesRecientes->count() > 0)
            <span class="bg-red-500 text-white px-2 py-0.5 rounded-full text-[9px] animate-pulse">
                {{ $reportesRecientes->count() }}
            </span>
        @endif
    </button>

    <div id="popAvances" class="hidden absolute bottom-16 left-0 w-80 md:w-96 bg-white border border-gray-200 shadow-2xl rounded-2xl overflow-hidden animate-fade-in-up transition-all">
        <div class="bg-indigo-600 p-4 flex justify-between items-center text-white">
            <h3 class="text-[10px] font-bold uppercase tracking-widest">Actividad Reciente</h3>
            <button onclick="toggleAvances()" class="text-white text-2xl">&times;</button>
        </div>

        <div class="max-h-96 overflow-y-auto p-4 space-y-3 bg-gray-50">
            @forelse($reportesRecientes as $r)
                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                    <div class="flex justify-between mb-1">
                        <span class="text-[10px] font-black text-indigo-600 uppercase">{{ $r->user->name ?? 'Usuario' }}</span>
                        <span class="text-[9px] text-gray-400">{{ $r->updated_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs text-gray-700 italic">"{{ $r->reporte_trabajador }}"</p>
                </div>
            @empty
                <div class="text-center py-6 text-gray-400 text-xs">No hay reportes nuevos.</div>
            @endforelse
        </div>
    </div>
</div>
@push('scripts')
<script>
    /**
     * Abre dos URLs al mismo tiempo (Multi-ventana)
     */
    function abrirMultiplesPestanas(url1, url2) {
        window.open(url1, '_blank');
        window.open(url2, '_blank');
    }

    /**
     * Controla el despliegue del panel de reportes
     */
    function toggleAvances() {
        const popup = document.getElementById('popAvances');
        if (popup) {
            popup.classList.toggle('hidden');
            // Guardamos en consola para depuración
            console.log("Panel de reportes alternado");
        }
    }

    /**
     * Cerrar el panel automáticamente si se hace clic fuera o se pulsa Escape
     */
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
