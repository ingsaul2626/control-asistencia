<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Centro de Notificaciones y Actividad') }}
            </h2>
            <span class="bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                {{ $actividades->total() }} Eventos registrados
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="relative">
                    {{-- Línea vertical del Timeline --}}
                    <div class="absolute border-l-2 border-gray-200 h-full left-4 md:left-9"></div>

                    <ul class="space-y-8">
                        @forelse ($actividades as $actividad)
                            <li class="relative flex items-center justify-between md:justify-start">
                                {{-- Icono según acción --}}
                                <div class="absolute left-0 md:left-5 w-10 h-10 rounded-full border-4 border-white flex items-center justify-center z-10
                                    {{ $actividad->accion == 'Eliminación' ? 'bg-red-500' : '' }}
                                    {{ $actividad->accion == 'Creación' ? 'bg-green-500' : '' }}
                                    {{ $actividad->accion == 'Edición' ? 'bg-blue-500' : '' }}
                                    {{ $actividad->accion == 'Inicio de sesión' ? 'bg-purple-500' : '' }}">

                                    @if($actividad->accion == 'Eliminación') 🗑️
                                    @elseif($actividad->accion == 'Creación') ➕
                                    @elseif($actividad->accion == 'Edición') 📝
                                    @else 🔑 @endif
                                </div>

                                <div class="ml-14 md:ml-20 w-full bg-gray-50 p-4 rounded-lg border border-gray-100 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span class="text-sm font-bold text-gray-900">{{ $actividad->user->name ?? 'Sistema' }}</span>
                                            <p class="text-sm text-gray-600 mt-1">{{ $actividad->detalles }}</p>
                                        </div>
                                        <span class="text-xs text-gray-400 whitespace-nowrap">{{ $actividad->created_at->diffForHumans() }}</span>
                                    </div>
                                    <div class="mt-2 flex items-center text-[10px] text-gray-400 uppercase tracking-widest">
                                        <span class="mr-2">📍 IP: {{ $actividad->ip }}</span>
                                        <span>• {{ $actividad->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="text-center py-10">
                                <p class="text-gray-500 italic">No hay actividades recientes para mostrar.</p>
                            </div>
                        @endforelse
                    </ul>
                </div>

                <div class="mt-8">
                    {{ $actividades->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
