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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
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
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500 italic">
                                            No se han registrado movimientos todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
