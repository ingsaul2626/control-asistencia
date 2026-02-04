<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial de Eventos Culminados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Proyecto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Trabajador Responsable</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha de Cierre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($eventosCulminados as $evento)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                {{ $evento->titulo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="flex items-center">
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs font-semibold">
                                        {{ $evento->user->name ?? 'Sin asignar' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $evento->updated_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('admin.proyectos.show', $evento->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Ver Reporte</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($eventosCulminados->isEmpty())
                    <p class="text-center py-4 text-gray-500">No hay proyectos finalizados aún.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
