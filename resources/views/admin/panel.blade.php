<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- HEADER CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800 tracking-tight italic uppercase">Gestión de Proyectos</h2>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-1">Reasigna y actualiza el estado operativo.</p>
                    </div>
                    <div class="bg-orange-50 p-3 rounded-2xl">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v4M7 7h10"></path></svg>
                    </div>
                </div>

                {{-- Card Total: Contraste Slate --}}
                <div class="bg-slate-900 p-6 rounded-2xl shadow-xl shadow-slate-200 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] uppercase font-black opacity-60 tracking-[0.2em]">Total Proyectos</p>
                        <h4 class="text-3xl font-black mt-1 group-hover:text-orange-400 transition-colors">{{ $proyectos->count() }}</h4>
                    </div>
                </div>

                {{-- Card Activos: Naranja Vibrante --}}
                <div class="bg-orange-500 p-6 rounded-2xl shadow-xl shadow-orange-200 text-white relative overflow-hidden group">
                    <div class="relative z-10">
                        <p class="text-[10px] uppercase font-black opacity-80 tracking-[0.2em]">En Proceso</p>
                        <h4 class="text-3xl font-black mt-1">{{ $proyectos->where('activo', true)->count() }}</h4>
                    </div>
                    <div class="absolute -right-2 -bottom-2 opacity-20">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
            </div>

            {{-- TABLA --}}
            <div class="bg-white rounded-[2rem] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                        <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em]">Listado de Proyectos</h3>
                        <div id="filter-container" class="flex gap-2"></div>
                    </div>

                    <table id="miTablaProyectos" class="w-full border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                <th class="px-6 pb-2 text-left">Proyecto</th>
                                <th class="px-4 pb-2 text-left">Categoría</th>
                                <th class="px-4 pb-2 text-left">Visibilidad</th>
                                <th class="px-4 pb-2 text-left">Estado</th>
                                <th class="px-6 pb-2 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyectos as $proyecto)
                            <tr class="group hover:bg-orange-50/50 transition-all duration-200">
                                {{-- Título --}}
                                <td class="p-4 bg-white group-hover:bg-transparent border-y border-l border-slate-50 rounded-l-2xl text-sm font-bold text-slate-700">
                                    {{ $proyecto->titulo }}
                                </td>

                                {{-- Categoría --}}
                                <td class="p-4 bg-white group-hover:bg-transparent border-y border-slate-50 text-xs font-black uppercase text-slate-400 tracking-wider">
                                    {{ $proyecto->tipo }}
                                </td>

                                {{-- Visibilidad (Toggle) --}}
                                <td class="p-4 bg-white group-hover:bg-transparent border-y border-slate-50">
                                    <form action="{{ route('admin.proyectos.toggle', $proyecto->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="visible" value="1">
                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all
                                            {{ $proyecto->visible ? 'bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-500 hover:text-white' : 'bg-slate-50 text-slate-400 border border-slate-200 hover:bg-slate-800 hover:text-white' }}">
                                            <span>●</span> {{ $proyecto->visible ? 'Visible' : 'Oculto' }}
                                        </button>
                                    </form>
                                </td>

                                {{-- Estado (Toggle) --}}
                                <td class="p-4 bg-white group-hover:bg-transparent border-y border-slate-50">
                                    <form action="{{ route('admin.proyectos.toggle', $proyecto->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="activo" value="1">
                                        <button type="submit" class="flex items-center gap-1.5 px-3 py-1 text-[9px] font-black uppercase tracking-widest rounded-xl transition-all
                                            {{ $proyecto->activo ? 'bg-orange-50 text-orange-600 border border-orange-200 hover:bg-orange-500 hover:text-white' : 'bg-slate-800 text-white border border-slate-700 hover:bg-black' }}">
                                            <span>●</span> {{ $proyecto->activo ? 'En Proceso' : 'Finalizado' }}
                                        </button>
                                    </form>
                                </td>

                                {{-- Acciones --}}
                                <td class="p-4 bg-white group-hover:bg-transparent border-y border-r border-slate-50 rounded-r-2xl text-right">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('admin.proyectos.show', $proyecto->id) }}" class="text-slate-300 hover:text-orange-500 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('admin.proyectos.edit', $proyecto->id) }}" class="text-slate-300 hover:text-sky-500 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('admin.proyectos.destroy', $proyecto->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este proyecto?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
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

<style>
    /* Personalización de DataTables para el tema Naranja */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f97316 !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        font-weight: 800 !important;
    }
    .dataTables_wrapper .dataTables_filter input {
        border-radius: 12px !important;
        border: 1px solid #e2e8f0 !important;
        padding: 6px 12px !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #f97316 !important;
        ring: 2px #f97316 !important;
    }
</style>

<script>
    $(document).ready(function() {
        var table = $('#miTablaProyectos').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
            "responsive": true,
            "pageLength": 10,
            initComplete: function () {
                this.api().columns(1).every( function () {
                    var column = this;
                    var select = $('<select class="bg-white border-slate-200 rounded-xl text-[10px] font-black uppercase tracking-widest p-2 focus:ring-orange-500 focus:border-orange-500 shadow-sm"><option value="">Filtrar Categoría</option></select>')
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
