<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reportes de Avance Técnico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($reportes as $reporte)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500 p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-lg text-indigo-900">{{ $reporte->titulo }}</h3>
                            <span class="text-xs bg-gray-100 px-2 py-1 rounded text-gray-600">
                                {{ $reporte->updated_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4">Enviado por: <strong>{{ $reporte->user->name }}</strong></p>

                        <div class="bg-amber-50 p-4 rounded-md border border-amber-100">
                            <p class="text-gray-800 italic">"{{ $reporte->reporte_trabajador }}"</p>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('admin.proyectos.show', $reporte->id) }}" class="text-indigo-600 text-sm font-bold hover:underline">
                                Ver detalles del proyecto &rarr;
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-10 text-center rounded-lg shadow">
                        <p class="text-gray-500 italic">No hay reportes técnicos enviados todavía.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
