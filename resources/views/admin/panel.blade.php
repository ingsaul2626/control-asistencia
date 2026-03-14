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
                                <th class="px-4 pb-2 text-center">Visibilidad</th>
                                <th class="px-6 pb-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyectos as $proyecto)
                            <tr class="bg-white shadow-sm border border-slate-100 rounded-2xl hover:shadow-md transition-shadow">
                                <td class="py-4 px-6 font-bold text-slate-700">{{ $proyecto->titulo }}</td>
                                <td class="py-4 px-4 uppercase text-[10px] font-black text-slate-400">{{ $proyecto->tipo }}</td>
                                <td class="py-4 px-4">
                                    <span class="text-xs font-bold text-slate-600">{{ $proyecto->responsable ?? 'Sin asignar' }}</span>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold {{ $proyecto->activo ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                        {{ $proyecto->activo ? 'VISIBLE' : 'OCULTO' }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors">
                                            Reasignar
                                        </a>
                                        <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}" class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-200 transition-colors">
                                            Actualizar
                                        </a>
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

