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
                    {{-- CAMBIO: Usamos $bitacoras aquí --}}
                    {{ $bitacoras->total() }} registros encontrados
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
                    {{-- CAMBIO: ID corregido a filterUsuario --}}
                    <input type="text" id="filterUsuario" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm" placeholder="Escribe un nombre...">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Fecha</label>
                    <input type="date" id="filterFecha" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm">
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1 block">Acción</label>
                    <select id="filterAccion" class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 focus:border-blue-500 focus:ring-blue-500 transition-all shadow-sm">
                        <option value="Inicio de sesión">Login</option>
                    </select>
                </div>
            </div>

            {{-- TABLA --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="tablaBitacora" class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Usuario</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Acción</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Detalles</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">IP</th>
                                <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Momento</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            {{-- CAMBIO: Unificado a $bitacoras --}}
                            @forelse($bitacoras as $log)
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
                                    {{-- Usamos formato de fecha normal para que el filtro JS funcione mejor --}}
                                    <td class="px-6 py-5 text-gray-500 text-xs" data-order="{{ $log->created_at }}">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-10 text-center text-gray-400">Sin registros.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Paginación de Laravel (importante si usas ->paginate()) --}}
                <div class="px-6 py-4 bg-gray-50">
                    {{ $bitacoras->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

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

    // Filtro de Usuario
    $('#filterUsuario').on('keyup', function() {
        table.column(0).search(this.value).draw();
    });

    // Filtro de Acción
    $('#filterAccion').on('change', function() {
        table.column(1).search(this.value).draw();
    });

    // Filtro de Fecha
    $('#filterFecha').on('change', function() {
        if(this.value) {
            // Reajuste para corregir desfase de zona horaria en JS
            var dateParts = this.value.split('-');
            var formattedDate = dateParts[2] + "/" + dateParts[1] + "/" + dateParts[0];
            table.column(4).search(formattedDate).draw();
        } else {
            table.column(4).search('').draw();
        }
    });
});
</script>
