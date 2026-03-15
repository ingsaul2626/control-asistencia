<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight">Gestión de Proyectos</h2>
                        <p class="text-sm text-slate-500 font-medium">Reasigna y actualiza el estado operativo.</p>
                    </div>
                </div>
                <div class="bg-indigo-600 p-6 rounded-2xl shadow-sm text-white">
                    <p class="text-[10px] uppercase font-black opacity-70">Total Proyectos</p>
                    <h4 class="text-3xl font-black">{{ $proyectos->count() }}</h4>
                </div>
                <div class="bg-emerald-500 p-6 rounded-2xl shadow-sm text-white">
                    <p class="text-[10px] uppercase font-black opacity-70">Activos</p>
                    <h4 class="text-3xl font-black">{{ $proyectos->where('activo', true)->count() }}</h4>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="text-lg font-bold text-slate-800">Proyectos</h3>
                        <div id="filter-container" class="flex gap-2"></div>
                    </div>

                    <table id="miTablaProyectos" class="w-full border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                <th class="px-6 pb-2 text-left">Proyecto</th>
                                <th class="px-4 pb-2 text-left">Categoría</th>
                                <th class="px-4 pb-2 text-left">Estado</th>
                                <th class="px-4 pb-2 text-center">Progreso</th>
                                <th class="px-6 pb-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyectos as $proyecto)
                    <tr class="group hover:bg-slate-50 transition-all duration-200 border-b border-slate-100">
                        {{-- Título --}}
                        <td class="p-4 text-sm font-semibold text-slate-800">{{ $proyecto->titulo }}</td>
                        
                        {{-- Categoría --}}
                        <td class="p-4 text-sm text-slate-500 font-medium">{{ $proyecto->tipo }}</td>

                        {{-- Visibilidad (Toggle) --}}
                        <td class="p-4">
                            <form action="{{ route('admin.proyectos.toggle', $proyecto->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="visible" value="1">
                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full transition-all 
                                    {{ $proyecto->visible ? 'bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100' : 'bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100' }}">
                                    <span>●</span> {{ $proyecto->visible ? 'Visible' : 'Oculto' }}
                                </button>
                            </form>
                        </td>

                        {{-- Estado (Toggle) --}}
                        <td class="p-4">
                            <form action="{{ route('admin.proyectos.toggle', $proyecto->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="activo" value="1">
                                <button type="submit" class="flex items-center gap-1.5 px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full transition-all 
                                    {{ $proyecto->activo ? 'bg-indigo-50 text-indigo-600 border border-indigo-200 hover:bg-indigo-100' : 'bg-slate-100 text-slate-600 border border-slate-200 hover:bg-slate-200' }}">
                                    <span>●</span> {{ $proyecto->activo ? 'En Proceso' : 'Finalizado' }}
                                </button>
                            </form>
                        </td>

                        {{-- Acciones --}}
                        <td class="p-4">
                            <div class="flex items-center gap-4">
                                {{-- Ver --}}
                                <a href="{{ route('admin.proyectos.show', $proyecto->id) }}" 
                                class="text-slate-400 hover:text-indigo-600 transition-colors" title="Ver detalle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                
                                {{-- Editar --}}
                                <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}" 
                                class="text-slate-400 hover:text-sky-600 transition-colors" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('admin.proyectos.destroy', $proyecto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-rose-600 transition-colors" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>

    <script>
        $(document).ready(function() {
            var table = $('#miTablaProyectos').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                "responsive": true,
                "pageLength": 10,
                // Agregamos filtros por columna (categoría)
                initComplete: function () {
                    this.api().columns(1).every( function () {
                        var column = this;
                        var select = $('<select class="bg-slate-50 border-slate-200 rounded-lg text-xs font-bold p-2"><option value="">Filtrar Categoría</option></select>')
                            .appendTo( $('#filter-container') )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column.search( val ? '^'+val+'$' : '', true, false ).draw();
                            });
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' );
                        });
                    });
                }
            });
        });
    </script>

