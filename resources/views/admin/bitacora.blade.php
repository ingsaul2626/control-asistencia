<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight uppercase tracking-tighter italic transition-colors">
                {{ __('Bitácora de Actividades') }}
            </h2>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 px-5 py-2.5 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-sm transition-all">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-uptag-orange"></span>
                </span>
                <span class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">
                    {{ $bitacoras->total() }} registros encontrados
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- FILTROS MODERNOS CON ACENTOS NARANJA --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="md:col-span-2 group">
                    <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1 block group-hover:text-uptag-orange transition-colors">Buscar usuarios</label>
                    <input type="text" id="filterUsuario" class="w-full rounded-2xl border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 px-5 py-3 focus:border-uptag-orange focus:ring-uptag-orange transition-all shadow-sm text-sm font-bold text-slate-600 dark:text-slate-300 placeholder-slate-300 dark:placeholder-slate-600" placeholder="Escribe un nombre...">
                </div>
                <div class="group">
                    <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1 block group-hover:text-uptag-orange transition-colors">Fecha</label>
                    <input type="date" id="filterFecha" class="w-full rounded-2xl border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 px-5 py-3 focus:border-uptag-orange focus:ring-uptag-orange transition-all shadow-sm text-sm font-bold text-slate-600 dark:text-slate-300 [color-scheme:light] dark:[color-scheme:dark]">
                </div>
                <div class="group">
                    <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-1 block group-hover:text-uptag-orange transition-colors">Acción</label>
                    <select id="filterAccion" class="w-full rounded-2xl border-slate-100 dark:border-slate-800 bg-white dark:bg-slate-900 px-5 py-3 focus:border-uptag-orange focus:ring-uptag-orange transition-all shadow-sm text-sm font-bold text-slate-600 dark:text-slate-300 appearance-none">
                        <option value="">Todas</option>
                        <option value="Creación">Creación</option>
                        <option value="Edición">Edición</option>
                        <option value="Eliminación">Eliminación</option>
                        <option value="Inicio de sesión">Login</option>
                    </select>
                </div>
            </div>

            {{-- TABLA ESTILIZADA --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none border border-white dark:border-slate-800 overflow-hidden transition-all">
                <div class="overflow-x-auto">
                    <table id="tablaBitacora" class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Usuario</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Acción</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Detalles</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">IP</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Momento</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @forelse($bitacoras as $log)
                                <tr class="hover:bg-orange-50/40 dark:hover:bg-orange-900/10 transition-colors group">
                                    <td class="px-8 py-5 font-bold text-slate-700 dark:text-slate-300 text-sm italic group-hover:text-uptag-orange transition-colors">
                                        {{ $log->user->name ?? 'Sistema' }}
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest
                                            {{ $log->accion == 'Eliminación' ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' : '' }}
                                            {{ $log->accion == 'Creación' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : '' }}
                                            {{ $log->accion == 'Edición' ? 'bg-orange-50 dark:bg-orange-950/30 text-uptag-orange' : '' }}
                                            {{ $log->accion == 'Inicio de sesión' ? 'bg-orange-100/50 dark:bg-orange-900/40 text-orange-600 dark:text-orange-400' : '' }}">
                                            {{ $log->accion }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-slate-500 dark:text-slate-400 text-xs max-w-xs truncate font-medium">{{ $log->detalles }}</td>
                                    <td class="px-8 py-5 text-slate-400 dark:text-slate-600 font-mono text-[10px]">{{ $log->ip }}</td>
                                    <td class="px-8 py-5 text-slate-500 dark:text-slate-400 text-[11px] font-bold" data-order="{{ $log->created_at }}">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-12 text-center text-slate-400 dark:text-slate-600 font-bold uppercase text-xs tracking-widest">Sin registros encontrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-8 py-6 bg-slate-50/50 dark:bg-slate-800/30 border-t border-slate-100 dark:border-slate-800 bitacora-pagination">
                    {{ $bitacoras->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<style>
    /* Estilización de DataTables para que coincida con el tema naranja y modo oscuro */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #f97316 !important;
        color: white !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: bold !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #94a3b8 !important; /* text-slate-400 */
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #475569 !important; /* text-slate-600 para modo oscuro */
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 11px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        color: #94a3b8 !important;
        font-weight: 800 !important;
        padding-top: 1.5rem !important;
    }

    /* Estilo para el input date en modo oscuro */
    .dark input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
</style>

<script>
$(document).ready(function() {
    var table = $('#tablaBitacora').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "dom": 'rtip',
        "pageLength": 15,
        "order": [[4, "desc"]]
    });

    $('#filterUsuario').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });

    $('#filterAccion').on('change', function() {
        table.column(1).search(this.value).draw();
    });

    $('#filterFecha').on('change', function() {
        if(this.value) {
            var dateParts = this.value.split('-');
            var formattedDate = dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0];
            table.column(4).search(formattedDate).draw();
        } else {
            table.column(4).search('').draw();
        }
    });
});
</script>
