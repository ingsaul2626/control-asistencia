<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Panel de Eventos</h2>
                    <p class="text-sm text-slate-500 font-medium">Gestiona y despliega nuevos proyectos al sistema.</p>
                </div>
                <div class="flex items-center space-x-2 text-xs font-bold text-indigo-600 bg-indigo-50 px-4 py-2 rounded-full uppercase tracking-widest">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span>Admin Mode Active</span>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">
                <div class="p-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-100 flex items-start space-x-3 animate-bounce">
                            <svg class="w-5 h-5 text-red-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            <ul class="text-sm text-red-700 font-medium">
                                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.proyectos.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Título del Proyecto</label>
                                    <input type="text" name="titulo" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 px-4 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-slate-700 font-bold placeholder:font-normal" value="{{ old('titulo') }}" placeholder="Nombre descriptivo del evento" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Responsable</label>
                                    <select name="user_id" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all font-bold text-slate-600" required>
                                        <option value="">Seleccione un líder...</option>
                                        @foreach($usuarios as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>👤 {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Fecha Programada</label>
                                    <input type="date" name="fecha" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all font-bold text-slate-600" value="{{ old('fecha') }}" required>
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Ubicación / Lugar</label>
                                    <input type="text" name="lugar" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all font-bold text-slate-600" value="{{ old('lugar') }}" placeholder="Ej: Planta Industrial 4">
                                </div>

                                <div>
                                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Categoría</label>
                                    <select name="tipo" class="w-full bg-slate-50 border-slate-200 rounded-2xl py-3 focus:ring-4 focus:ring-indigo-100 transition-all font-bold text-slate-600" required>
                                        <option value="">Seleccione tipo...</option>
                                        @foreach(['Obra', 'Mantenimiento', 'Reparación', 'Diseño'] as $t)
                                            <option value="{{ $t }}" {{ old('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="bg-slate-50 p-6 rounded-3xl border-2 border-dashed border-slate-200 group hover:border-indigo-400 transition-all">
                                    <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-4 text-center">Imagen Principal</label>
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-slate-300 group-hover:text-indigo-400 mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <input type="file" name="imagen" accept="image/*" class="text-[10px] text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-white file:text-indigo-600 file:font-bold hover:file:bg-indigo-50 cursor-pointer" required>
                                    </div>
                                </div>

                                <div class="bg-indigo-50/50 p-5 rounded-3xl border border-indigo-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="text-xs font-black text-indigo-900 uppercase tracking-widest">Publicar Ahora</label>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="publicado" value="1" class="sr-only peer" {{ old('publicado') ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                        </label>
                                    </div>
                                    <p class="text-[10px] text-indigo-700/60 leading-tight font-medium">Si se activa, el proyecto será visible inmediatamente en el catálogo público.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Descripción y Detalles Técnicos</label>
                                <textarea name="descripcion" rows="4" class="w-full bg-slate-50 border-slate-200 rounded-3xl p-4 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-600" placeholder="Describe los objetivos y alcances técnicos...">{{ old('descripcion') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Planos / Documentación (PDF)</label>
                                <div class="flex items-center p-4 bg-slate-50 rounded-3xl border border-slate-200 h-[116px]">
                                    <input type="file" name="archivo" accept="application/pdf" class="text-xs text-slate-500 file:rounded-xl file:border-0 file:bg-slate-200 file:px-4 file:py-2 file:font-bold hover:file:bg-slate-300 transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="group relative bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-sm uppercase tracking-widest overflow-hidden transition-all hover:bg-indigo-600 active:scale-95 shadow-2xl shadow-slate-300">
                                <span class="relative z-10 flex items-center">
                                    Finalizar y Asignar
                                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-slate-50/50 border-t border-slate-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Historial de Eventos Recientes</h3>
                        <div class="h-1 w-20 bg-indigo-200 rounded-full"></div>
                    </div>

                    <div class="overflow-x-auto">
                        <table id="miTablaGenerica" class="w-full border-separate border-spacing-y-3">
                            <thead>
                                <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] px-4">
                                    <th class="pb-4 px-6 text-left">Proyecto</th>
                                    <th class="pb-4 px-4 text-left">Categoría</th>
                                    <th class="pb-4 px-4 text-left">Fecha</th>
                                    <th class="pb-4 px-4 text-center">Visibilidad</th>
                                    <th class="pb-4 px-6 text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventos as $evento)
                                <tr class="bg-white shadow-sm border border-slate-100 rounded-2xl group transition-all hover:shadow-md hover:-translate-y-0.5">
                                    <td class="py-4 px-6 rounded-l-2xl font-bold text-slate-700">{{ $evento->titulo }}</td>
                                    <td class="py-4 px-4 uppercase text-[10px] font-black text-slate-400 tracking-wider">{{ $evento->tipo }}</td>
                                    <td class="py-4 px-4 text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase {{ $evento->activo ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                            <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $evento->activo ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $evento->activo ? 'Visible' : 'Oculto' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 rounded-r-2xl text-right">
                                        <div class="flex justify-end items-center space-x-3">
                                            <a href="{{ route('admin.proyectos.edit', $evento) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.proyectos.destroy', $evento) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-2 bg-slate-50 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        if ( ! $.fn.DataTable.isDataTable( '#miTablaGenerica' ) ) {
            $('#miTablaGenerica').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                    "search": "",
                    "searchPlaceholder": "Filtrar eventos..."
                },
                "responsive": true,
                "pageLength": 5,
                "order": [[2, "desc"]],
                "dom": '<"flex justify-between items-center mb-4"f>rt<"flex justify-between items-center mt-4"ip>',
            });

            // Estilizar el input de búsqueda de DataTables
            $('.dataTables_filter input').addClass('bg-white border-slate-200 rounded-full text-xs px-6 py-2 focus:ring-4 focus:ring-indigo-100 transition-all outline-none border');
        }
    });
    </script>

    <style>
        /* Ajustes para DataTables Moderno */
        .dataTables_wrapper .dataTables_paginate .paginate_button { @apply rounded-xl border-none font-bold text-xs !important; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current { @apply bg-indigo-600 text-white !important; }
        table.dataTable.no-footer { border-bottom: none !important; }
    </style>
</x-app-layout>
