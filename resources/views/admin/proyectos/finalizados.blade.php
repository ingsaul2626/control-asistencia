<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white leading-tight transition-colors">
            {{ __('Historial de Eventos Culminados') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Contenedor principal adaptativo --}}
            <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-xl shadow-slate-200/60 dark:shadow-none sm:rounded-[2.5rem] p-2 sm:p-8 border border-slate-100 dark:border-slate-800 transition-all">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-950/50">
                            <tr>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Proyecto</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Trabajador Responsable</th>
                                <th class="px-6 py-5 text-left text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Fecha de Cierre</th>
                                <th class="px-6 py-5 text-right text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-[0.2em]">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-100 dark:divide-slate-800 transition-colors">
                            @foreach($eventosCulminados as $evento)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-900 dark:text-slate-100 group-hover:text-uptag-orange transition-colors">
                                        {{ $evento->titulo }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-600 font-medium uppercase tracking-tighter">ID: #00{{ $evento->id }}</div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{-- Badge dinámico: En oscuro es un borde naranja sutil --}}
                                        <span class="bg-orange-50 dark:bg-orange-950/20 text-uptag-orange px-4 py-1.5 rounded-xl text-[11px] font-black border border-orange-100 dark:border-orange-900/30 transition-all group-hover:scale-105">
                                            {{ $evento->user->name ?? 'Sin asignar' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400 font-medium">
                                    <span class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-300 dark:text-slate-600 group-hover:text-uptag-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $evento->updated_at->format('d M, Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 whitespace-nowrap text-right text-sm">
                                    {{-- Botón de acción con estilo UPTAG --}}
                                    <a href="{{ route('admin.proyectos.show', $evento->id) }}"
                                       class="inline-flex items-center px-5 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-uptag-orange dark:hover:bg-uptag-orange hover:text-white dark:hover:text-white font-black uppercase text-[10px] tracking-widest rounded-xl transition-all shadow-sm active:scale-95">
                                        Ver Registro
                                        <svg class="ml-2 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($eventosCulminados->isEmpty())
                    <div class="text-center py-20 bg-slate-50/50 dark:bg-slate-950/30 rounded-3xl mt-4 border-2 border-dashed border-slate-100 dark:border-slate-800">
                        <div class="w-20 h-20 bg-white dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl dark:shadow-none border border-slate-100 dark:border-slate-800">
                            <svg class="h-10 w-10 text-slate-200 dark:text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <p class="text-slate-500 dark:text-slate-500 font-bold italic tracking-tight">El archivo histórico está vacío.</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-700 uppercase mt-1 tracking-[0.2em]">No se han procesado cierres de proyecto hoy</p>
                    </div>
                @endif
            </div>

            <div class="mt-8 flex justify-between items-center px-4">
                <p class="text-[10px] text-slate-400 dark:text-slate-600 font-black uppercase tracking-widest italic">
                    Unidad de Ingeniería y Proyectos • Falcón
                </p>
                <div class="h-px bg-slate-200 dark:bg-slate-800 flex-grow mx-8"></div>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-uptag-orange opacity-20"></div>
                    <div class="w-2 h-2 rounded-full bg-uptag-orange opacity-40"></div>
                    <div class="w-2 h-2 rounded-full bg-uptag-orange opacity-60"></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
