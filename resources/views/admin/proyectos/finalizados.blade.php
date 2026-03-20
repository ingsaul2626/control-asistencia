<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Historial de Eventos Culminados') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Contenedor principal con bordes más suaves y sombra naranja sutil --}}
            <div class="bg-white overflow-hidden shadow-xl shadow-slate-200/60 sm:rounded-3xl p-6 border border-slate-100">

                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Proyecto</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Trabajador Responsable</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Fecha de Cierre</th>
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 uppercase tracking-widest">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @foreach($eventosCulminados as $evento)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-900">
                                {{ $evento->titulo }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                <div class="flex items-center">
                                    {{-- Cambio: Badge en tonos naranja (uptag-orange) --}}
                                    <span class="bg-orange-50 text-uptag-orange px-3 py-1 rounded-full text-xs font-bold border border-orange-100">
                                        {{ $evento->user->name ?? 'Sin asignar' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500 font-medium">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $evento->updated_at->format('d/m/Y') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{-- Cambio: Enlace en uptag-orange con efecto hover --}}
                                <a href="{{ route('admin.proyectos.show', $evento->id) }}" class="text-uptag-orange hover:text-orange-700 font-black uppercase text-[11px] tracking-tighter transition-colors">
                                    Ver Reporte
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($eventosCulminados->isEmpty())
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        <p class="text-slate-500 font-medium">No hay proyectos finalizados aún.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
