<x-app-layout>
    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Formulario Principal --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-indigo-600 h-2"></div>
                <div class="p-8">
                    <h2 class="text-2xl font-black text-slate-800 mb-6 flex items-center">
                        <span class="mr-3 text-3xl">🏗️</span> Registro de Proyectos de Ingeniería
                    </h2>

                    <form action="{{ route('admin.proyectos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Nombre de la Obra/Proyecto</label>
                                    <input type="text" name="titulo" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl focus:ring-indigo-500" required>
                                </div>

                                {{-- Nuevo campo: Descripción --}}
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Descripción Técnica</label>
                                    <textarea name="descripcion" rows="3" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl focus:ring-indigo-500"></textarea>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Categoría</label>
                                        <select name="tipo" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl" required>
                                            <option value="Obra Civil">Obra</option>
                                            <option value="Mantenimiento">Mantenimiento</option>
                                            <option value="Infraestructura">Infraestructura</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Responsable (Líder)</label>
                                        <select name="user_id" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl" required>
                                            @foreach($usuarios as $u)
                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Inicio</label>
                                    <input type="date" name="fecha_inicio" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl" required>
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Entrega</label>
                                    <input type="date" name="fecha_entrega" class="w-full mt-1 bg-slate-50 border-slate-200 rounded-xl" required>
                                </div>
                            </div>
                        </div>

                        {{-- Área de Archivos con validación de tipo --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 p-6 bg-slate-50 rounded-xl border border-slate-100">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Imagen de la Obra (JPG/PNG)</label>
                                <input type="file" name="imagen" accept="image/png, image/jpeg, image/jpg" class="w-full mt-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Plano o Reporte (PDF)</label>
                                <input type="file" name="archivo_pdf" accept="application/pdf" class="w-full mt-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-rose-50 file:text-rose-700">
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-slate-900 hover:bg-black text-white px-8 py-3 rounded-xl font-bold transition shadow-xl">
                                Crear Expediente de Obra
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Tabla con reporte del usuario --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                <h3 class="font-bold text-lg text-slate-800 mb-6">Proyectos Activos</h3>
                <table id="miTablaGenerica" class="w-full">
                    <thead>
                        <tr class="text-slate-400 text-xs uppercase border-b border-slate-100">
                            <th class="py-4 text-left">Obra</th>
                            <th class="py-4 text-left">Responsable</th>
                            <th class="py-4 text-left">Reporte Técnico</th>
                            <th class="py-4 text-center">Docs</th>
                            <th class="py-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($proyectos as $p)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-5">
                                <div class="font-bold text-slate-800">{{ $p->titulo }}</div>
                                <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded-full font-bold text-slate-500">{{ $p->tipo }}</span>
                            </td>
                            <td class="py-5 text-sm">{{ $p->user->name ?? 'Sin asignar' }}</td>
                            <td class="py-5 text-sm text-slate-600 italic">
                                {{ Str::limit($p->descripcion ?? 'Sin detalles técnicos...', 50) }}
                            </td>
                            <td class="py-5 text-center">
                                <div class="flex justify-center gap-2">
                                    @if($p->imagen) <span title="Imagen subida" class="text-indigo-400">🖼️</span> @endif
                                    @if($p->archivo_pdf) <span title="PDF disponible" class="text-red-400">📄</span> @endif
                                </div>
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

    {{-- DataTables scripts (asegúrate de tener jQuery cargado) --}}
    <script>
    $(document).ready(function() {
        $('#miTablaGenerica').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
            },
            "pageLength": 8,
            "dom": '<"flex justify-between items-center mb-4"lf>rt<"mt-4"p>'
        });
    });
    </script>
</x-app-layout>
