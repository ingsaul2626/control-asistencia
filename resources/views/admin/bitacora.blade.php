<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Historial de Actividades (Bitácora)') }}
            </h2>
            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                {{ $logs->total() }} Registros en total
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- SECCIÓN DE FILTROS --}}
            <div class="bg-white p-4 mb-6 rounded-lg shadow-sm border border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Buscar por Usuario</label>
                        <input type="text" id="filterUsuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Nombre del usuario...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Filtrar por Fecha</label>
                        <input type="date" id="filterFecha" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Acción (Sema)</label>
                        <select id="filterAccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Todas las acciones</option>
                            <option value="Creación">Creación</option>
                            <option value="Edición">Edición</option>
                            <option value="Eliminación">Eliminación</option>
                            <option value="Inicio de sesión">Inicio de sesión</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button id="resetFilters" class="text-sm text-gray-500 hover:text-red-600 font-medium">Limpiar Filtros</button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table id="tablaBitacora" class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-[#f6bb54] text-white text-sm">
                                    <th class="px-4 py-3 text-left rounded-tl-lg">Usuario</th>
                                    <th class="px-4 py-3 text-left">Acción</th>
                                    <th class="px-4 py-3 text-left">Descripción / Detalles</th>
                                    <th class="px-4 py-3 text-left">Dirección IP</th>
                                    <th class="px-4 py-3 text-left rounded-tr-lg">Fecha y Hora</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-200">
                                @forelse ($logs as $log)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-4 font-medium text-gray-700">
                                            {{ $log->user->name ?? 'Sistema' }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="px-2 py-1 rounded text-xs font-bold
                                                {{ $log->accion == 'Eliminación' ? 'bg-red-100 text-red-700' : '' }}
                                                {{ $log->accion == 'Creación' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $log->accion == 'Edición' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $log->accion == 'Inicio de sesión' ? 'bg-purple-100 text-purple-700' : '' }}
                                            ">
                                                {{ $log->accion }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-gray-600 italic">
                                            {{ $log->detalles }}
                                        </td>
                                        <td class="px-4 py-4 font-mono text-xs text-gray-500">
                                            {{ $log->ip }}
                                        </td>
                                        <td class="px-4 py-4 text-gray-500">
                                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    {{-- ... --}}
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        var table = $('#tablaBitacora').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "dom": 'rtip', // Ocultamos el buscador por defecto para usar nuestros filtros
            "pageLength": 15,
            "order": [[4, "desc"]] // Ordenar por fecha por defecto
        });

        // Filtro por Usuario (Columna 0)
        $('#filterUsuario').on('keyup', function() {
            table.column(0).search(this.value).draw();
        });

        // Filtro por Acción/Sema (Columna 1)
        $('#filterAccion').on('change', function() {
            table.column(1).search(this.value).draw();
        });

        // Filtro por Fecha (Columna 4)
        $('#filterFecha').on('change', function() {
            // Convertimos la fecha YYYY-MM-DD a DD/MM/YYYY que es como está en la tabla
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
