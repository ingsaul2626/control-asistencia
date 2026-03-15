<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Header Moderno --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Gestión de Obras</h1>
                    <p class="text-slate-500 mt-1">Panel de control centralizado para proyectos 2026.</p>
                </div>
            </div>

            {{-- Formulario Principal: Estilo Card Flotante con Borde Suave --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 transition-all hover:shadow-md">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">🏗️</div>
                    Nuevo Proyecto
                </h2>

                <form action="{{ route('admin.proyectos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-2 space-y-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nombre del Proyecto</label>
                                <input type="text" name="titulo" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-500 px-4 py-3" placeholder="Ej: Edificio Central fase II" required>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Descripción Técnica</label>
                                <textarea name="descripcion" rows="3" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-500 px-4 py-3" placeholder="Detalles relevantes..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Categoría</label>
                                    <select name="tipo" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-500 px-4 py-3">
                                        <option>Obra Civil</option>
                                        <option>Mantenimiento</option>
                                        <option>Infraestructura</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Responsable</label>
                                    <select name="user_id" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-500 px-4 py-3">
                                        @foreach($usuarios as $u) <option value="{{ $u->id }}">{{ $u->name }}</option> @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Fechas (Inicio/Entrega)</label>
                                <input type="date" name="fecha_inicio" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2 mb-2">
                                <input type="date" name="fecha_entrega" class="w-full bg-slate-50 border-0 rounded-xl px-4 py-2">
                            </div>
                            
                            {{-- Dropzones simplificados --}}
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-300 transition-colors">
                                <input type="file" name="imagen" class="hidden" id="file-img">
                                <label for="file-img" class="cursor-pointer text-xs font-semibold text-slate-500">📷 Subir Portada</label>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-900/20">
                            Registrar Proyecto
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabla con diseño optimizado para escaneo rápido --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800">Proyectos Activos</h3>
                </div>
                <div class="p-6">
                    <table id="miTablaGenerica" class="w-full text-sm">
                        <thead class="text-slate-400 uppercase text-[10px] tracking-wider">
                            <tr>
                                <th class="pb-4 text-left">Proyecto</th>
                                <th class="pb-4 text-left">Responsable</th>
                                <th class="pb-4 text-center">Estado</th>
                                <th class="pb-4 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($proyectos as $p)
                            <tr class="group hover:bg-slate-50/50 transition">
                                <td class="py-5">
                                    <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition">{{ $p->titulo }}</div>
                                    <span class="text-[10px] text-slate-400">{{ $p->tipo }}</span>
                                </td>
                                <td class="py-5 text-slate-600">{{ $p->user->name ?? '—' }}</td>
                                <td class="py-5 text-center">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full font-bold text-[10px]">Activo</span>
                                </td>
                                <td class="py-5 text-center">
                                    <a href="{{ route('admin.proyectos.edit', $p->id) }}" class="text-indigo-600 font-bold hover:underline">Gestionar</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#miTablaGenerica').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                "pageLength": 6,
                "dom": '<"flex justify-between items-center mb-6"f>rt<"mt-6"p>'
            });
        });
    </script>
</x-app-layout>