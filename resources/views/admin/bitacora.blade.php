<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                {{ __('Bitácora de Actividades') }}
            </h2>
            <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-gray-200 shadow-sm">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                <span class="text-sm font-semibold text-gray-600">
                    {{ $logs->total() }} registros encontrados
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- FILTROS MODERNOS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="md:col-span-2">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Buscar usuarios</label>
                    <input type="text" id="filterusuarios" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" placeholder="Escribe un nombre...">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Fecha</label>
                    <input type="date" id="filterFecha" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Acción</label>
                    <select id="filterAccion" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm">
                        <option value="">Todas</option>
                        <option value="Creación">Creación</option>
                        <option value="Edición">Edición</option>
                        <option value="Eliminación">Eliminación</option>
                        <option value="Inicio de sesión">Login</option>
                    </select>
                </div>
            </div>

            {{-- TABLA CON ESTILO MODERNO --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="tablaBitacora" class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">usuarios</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Acción</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Detalles</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">IP</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Momento</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse ($logs as $log)
                                <tr class="hover:bg-blue-50/30 transition-colors">
                                    <td class="px-6 py-5 font-semibold text-gray-700">{{ $log->user->name ?? 'Sistema' }}</td>
                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest
                                            {{ $log->accion == 'Eliminación' ? 'bg-red-50 text-red-600' : '' }}
                                            {{ $log->accion == 'Creación' ? 'bg-emerald-50 text-emerald-600' : '' }}
                                            {{ $log->accion == 'Edición' ? 'bg-blue-50 text-blue-600' : '' }}
                                            {{ $log->accion == 'Inicio de sesión' ? 'bg-amber-50 text-amber-600' : '' }}">
                                            {{ $log->accion }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-gray-500 text-sm max-w-xs truncate">{{ $log->detalles }}</td>
                                    <td class="px-6 py-5 text-gray-400 font-mono text-xs">{{ $log->ip }}</td>
                                    <td class="px-6 py-5 text-gray-500 text-xs">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
{{-- Scripts y Estilos --}}

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

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
                var date = new Date(this.value);
                var day = ("0" + (date.getDate() + 1)).slice(-2);
                var month = ("0" + (date.getMonth() + 1)).slice(-2);
                var year = date.getFullYear();
                var formattedDate = day + "/" + month + "/" + year;
                table.column(4).search(formattedDate).draw();
            } else {
                table.column(4).search('').draw();
            }
        });
        $('#resetFilters').on('click', function() {
            $('#filterUsuario').val('');
            $('#filterFecha').val('');
            $('#filterAccion').val('');
            table.search('').columns().search('').draw();
        });
    });
    </script>
