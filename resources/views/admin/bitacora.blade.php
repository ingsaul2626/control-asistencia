<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            {{-- Texto adaptable al modo oscuro --}}
            <h2 class="font-semibold text-xl text-gray-800 dark:text-slate-200 leading-tight">
                {{ __('Historial de Actividades (Bitácora)') }}
            </h2>
            <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-xs font-medium px-2.5 py-0.5 rounded-full border border-blue-200 dark:border-blue-800">
                {{ $logs->total() }} Registros en total
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SECCIÓN DE FILTROS (Adaptada a Dark Mode) --}}
            <div class="bg-white dark:bg-slate-900 p-4 mb-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 transition-colors">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Buscar por Usuario</label>
                        <input type="text" id="filterUsuario" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nombre del usuario...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Filtrar por Fecha</label>
                        <input type="date" id="filterFecha" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-slate-400">Acción (Sema)</label>
                        <select id="filterAccion" class="mt-1 block w-full rounded-xl border-gray-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Todas las acciones</option>
                            <option value="Creación">Creación</option>
                            <option value="Edición">Edición</option>
                            <option value="Eliminación">Eliminación</option>
                            <option value="Inicio de sesión">Inicio de sesión</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="resetFilters" class="text-sm text-gray-500 dark:text-slate-500 hover:text-red-600 dark:hover:text-rose-400 font-medium transition-colors">Limpiar Filtros</button>
                </div>
            </div>

            {{-- TABLA DE BITÁCORA --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-slate-800">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="tablaBitacora" class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-[#f6bb54] text-white text-sm">
                                    <th class="px-4 py-3 text-left rounded-tl-xl">Usuario</th>
                                    <th class="px-4 py-3 text-left">Acción</th>
                                    <th class="px-4 py-3 text-left">Descripción / Detalles</th>
                                    <th class="px-4 py-3 text-left">Dirección IP</th>
                                    <th class="px-4 py-3 text-left rounded-tr-xl">Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-200 dark:divide-slate-800">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-4 py-4 font-medium text-gray-700 dark:text-slate-300">
                                            {{ $log->user->name ?? 'Sistema' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="px-2 py-1 rounded-lg text-[10px] uppercase tracking-wider font-black
                                                {{ $log->accion == 'Eliminación' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                                {{ $log->accion == 'Creación' ? 'bg-green-100 text-green-700 dark:bg-emerald-900/30 dark:text-emerald-400' : '' }}
                                                {{ $log->accion == 'Edición' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                                {{ $log->accion == 'Inicio de sesión' ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : '' }}
                                            ">
                                                {{ $log->accion }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600 dark:text-slate-400 italic">
                                            {{ $log->detalles }}
                                        </td>
                                        <td class="px-4 py-4 font-mono text-xs text-gray-500 dark:text-slate-500">
                                            {{ $log->ip }}
                                        </td>
                                        <td class="px-4 py-4 text-gray-500 dark:text-slate-500">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-slate-500">
                                            No hay registros de actividad disponibles.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS (Mantenidos) --}}
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

        // Filtro por Usuario
        $('#filterUsuario').on('keyup', function() {
            table.column(0).search(this.value).draw();
        });

        // Filtro por Acción
        $('#filterAccion').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        // Filtro por Fecha
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

        // Limpiar Filtros
        $('#resetFilters').on('click', function() {
            $('#filterUsuario').val('');
            $('#filterFecha').val('');
            $('#filterAccion').val('');
            table.search('').columns().search('').draw();
        });
    });
    </script>
</x-app-layout>
