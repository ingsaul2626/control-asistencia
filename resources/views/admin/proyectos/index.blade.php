<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                {{ __('Centro de Gestión de Proyectos') }}
            </h2>
            <div class="text-sm text-slate-500">
                Administrador: <span class="font-bold text-indigo-600">{{ auth()->user()->name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-700 p-1"></div>
                <div class="p-8">
                    <h3 class="text-indigo-600 font-extrabold flex items-center mb-8 text-lg uppercase tracking-wider">
                        <span class="p-2 bg-indigo-50 rounded-lg mr-3">🚀</span>
                        Vincular Proyecto y Talento
                    </h3>

                    <form action="{{ route('admin.proyectos.asignar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Proyecto Objetivo</label>
                                <select name="evento_id" class="w-full bg-slate-50 border-slate-200 rounded-xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-700" required>
                                    <option value="">-- Elige un proyecto --</option>
                                    @foreach($eventos as $e)
                                        <option value="{{ $e->id }}">{{ $e->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase ml-1">Especialista Responsable</label>
                                <select name="user_id" class="w-full bg-slate-50 border-slate-200 rounded-xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-700" required>
                                    <option value="">Seleccione un trabajador</option>
                                    @foreach($usuarios as $u)
                                        <option value="{{ $u->id }}">👤 {{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-3 rounded-xl font-bold transition-all transform active:scale-95 shadow-lg shadow-indigo-200 flex items-center">
                                Guardar Asignación
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-bold text-slate-800">Proyectos Activos</h3>
                    <div class="flex space-x-2">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold">Total: {{ $eventos->count() }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="miTablaGenerica" class="w-full">
                        <thead>
                            <tr class="text-slate-400 text-xs uppercase tracking-widest border-b border-slate-100">
                                <th class="py-4 px-4 text-left font-bold">Información del Proyecto</th>
                                <th class="py-4 px-4 text-left font-bold">Líder Asignado</th>
                                <th class="py-4 px-4 text-center font-bold">Avance Técnico</th>
                                <th class="py-4 px-4 text-center font-bold">Estatus</th>
                                <th class="py-4 px-4 text-center font-bold">Gestión</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($eventos as $evento)
                            <tr class="group hover:bg-slate-50/80 transition-all duration-200">
                                <td class="py-5 px-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $evento->titulo }}</span>
                                        <div class="flex items-center mt-1 space-x-2">
                                            <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded">{{ $evento->tipo }}</span>
                                            <span class="text-[10px] text-slate-400">📍 {{ $evento->lugar }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 px-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs mr-3">
                                            {{ substr($evento->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <span class="text-sm text-slate-600 font-medium">{{ $evento->user->name ?? 'Sin asignar' }}</span>
                                    </div>
                                </td>
                                <td class="py-5 px-4 text-center">
                                    @if($evento->reporte_trabajador)
                                        <div class="group relative inline-block">
                                            <button class="flex items-center justify-center mx-auto px-4 py-1.5 bg-amber-50 text-amber-700 text-[11px] font-extrabold rounded-lg border border-amber-100 hover:bg-amber-100 transition shadow-sm">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                REPORTE
                                            </button>
                                            <div class="hidden group-hover:block absolute z-50 w-72 p-4 bg-slate-900 text-white text-[11px] rounded-2xl shadow-2xl -mt-2 left-1/2 transform -translate-x-1/2 -translate-y-full border border-slate-700 animate-fade-in">
                                                <div class="font-bold text-amber-400 mb-2 uppercase tracking-widest">Resumen de Avance</div>
                                                <p class="leading-relaxed text-slate-300 italic">"{{ $evento->reporte_trabajador }}"</p>
                                                <div class="absolute w-3 h-3 bg-slate-900 rotate-45 left-1/2 -bottom-1.5 -translate-x-1/2 border-r border-b border-slate-700"></div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-[11px] text-slate-300 uppercase tracking-tighter">Pendiente</span>
                                    @endif
                                </td>
                                <td class="py-5 px-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $evento->activo ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-50 text-slate-400 border border-slate-100' }}">
                                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $evento->activo ? 'bg-emerald-500 animate-pulse' : 'bg-slate-300' }}"></span>
                                        {{ $evento->activo ? 'Activo' : 'Pausado' }}
                                    </span>
                                </td>
                                <td class="py-5 px-4 text-center">
                                    <a href="{{ route('admin.proyectos.edit', $evento->id) }}" class="inline-flex p-2 text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-600 hover:text-white transition-all transform hover:rotate-12 shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .dataTables_wrapper .dataTables_length select {
            @apply bg-slate-50 border-slate-200 rounded-lg text-xs font-bold py-1 px-8;
        }
        .dataTables_wrapper .dataTables_filter input {
            @apply bg-slate-50 border-slate-200 rounded-xl text-sm py-2 px-4 focus:ring-4 focus:ring-indigo-100 transition-all;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-indigo-600 !important border-none rounded-lg text-white font-bold !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            @apply bg-indigo-50 !important border-none rounded-lg text-indigo-600 !important;
        }
        @keyframes fade-in {
            from { opacity: 0; transform: translate(-50%, -90%); }
            to { opacity: 1; transform: translate(-50%, -100%); }
        }
        .animate-fade-in { animation: fade-in 0.3s ease-out forwards; }
    </style>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#miTablaGenerica').DataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_",
                "zeroRecords": "No hay proyectos que coincidan",
                "info": "Página _PAGE_ de _PAGES_",
                "search": "",
                "searchPlaceholder": "Buscar proyecto o líder...",
                "paginate": { "next": "→", "previous": "←" }
            },
            "pageLength": 8,
            "responsive": true,
            "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6 gap-4"lf>rt<"flex justify-between items-center mt-6"ip>'
        });
    });
    </script>
</x-app-layout>
