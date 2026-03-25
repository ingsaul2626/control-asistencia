<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Header Moderno --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-slate-100 tracking-tight">Gestión de Obras</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1 font-medium">Panel de control centralizado • UPTAG 2026</p>
                </div>
                <div class="hidden md:block">
                    <span class="bg-orange-100 text-uptag-orange dark:bg-orange-900/20 px-4 py-2 rounded-2xl text-xs font-bold uppercase tracking-widest">
                        Ingeniería e Infraestructura
                    </span>
                </div>
            </div>

            {{-- Formulario Principal --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 p-8 md:p-10 transition-all hover:shadow-xl hover:shadow-slate-200/50 dark:hover:shadow-none">
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex items-center justify-center shadow-lg shadow-orange-500/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    Registrar Nuevo Proyecto
                </h2>

                <form action="{{ route('admin.proyectos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                        {{-- Columna Izquierda: Datos --}}
                        <div class="lg:col-span-2 space-y-7">
                            <div class="group">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2 group-focus-within:text-uptag-orange transition-colors">Nombre del Proyecto</label>
                                <input type="text" name="titulo" class="w-full bg-slate-50 dark:bg-slate-800/40 border-0 rounded-2xl focus:ring-2 focus:ring-uptag-orange px-5 py-4 text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 transition-all" placeholder="Ej: Rehabilitación de Laboratorios de Informática" required>
                            </div>

                            <div class="group">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2 group-focus-within:text-uptag-orange transition-colors">Descripción Técnica</label>
                                <textarea name="descripcion" rows="4" class="w-full bg-slate-50 dark:bg-slate-800/40 border-0 rounded-2xl focus:ring-2 focus:ring-uptag-orange px-5 py-4 text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600 transition-all" placeholder="Describe los alcances, materiales y objetivos técnicos..."></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">Categoría de Obra</label>
                                    <select name="tipo" class="w-full bg-slate-50 dark:bg-slate-800/40 border-0 rounded-2xl focus:ring-2 focus:ring-uptag-orange px-5 py-4 text-slate-700 dark:text-slate-200 transition-all">
                                        <option class="dark:bg-slate-900">Obra Civil</option>
                                        <option class="dark:bg-slate-900">Mantenimiento Preventivo</option>
                                        <option class="dark:bg-slate-900">Infraestructura Eléctrica</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">Ingeniero Responsable</label>
                                    <select name="user_id" class="w-full bg-slate-50 dark:bg-slate-800/40 border-0 rounded-2xl focus:ring-2 focus:ring-uptag-orange px-5 py-4 text-slate-700 dark:text-slate-200 transition-all">
                                        @foreach($usuarios as $u)
                                            <option value="{{ $u->id }}" class="dark:bg-slate-900">{{ $u->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Columna Derecha: Archivos y Fechas --}}
                        <div class="space-y-8">
                            <div class="bg-slate-50 dark:bg-slate-800/30 p-6 rounded-[2rem] space-y-4">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">Cronograma Estimado</label>
                                <div class="space-y-3">
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">INICIO</span>
                                        <input type="date" name="fecha_inicio" class="w-full bg-white dark:bg-slate-800 border-0 rounded-xl pl-16 pr-4 py-3 focus:ring-2 focus:ring-uptag-orange text-slate-700 dark:text-slate-200 dark:[color-scheme:dark]">
                                    </div>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">FINAL</span>
                                        <input type="date" name="fecha_entrega" class="w-full bg-white dark:bg-slate-800 border-0 rounded-xl pl-16 pr-4 py-3 focus:ring-2 focus:ring-uptag-orange text-slate-700 dark:text-slate-200 dark:[color-scheme:dark]">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                {{-- Input Imagen --}}
                                <div class="relative group">
                                    <input type="file" name="imagen" class="hidden" id="file-img" accept="image/*" onchange="updateLabel(this, 'label-img')">
                                    <label for="file-img" id="label-img" class="flex items-center justify-center gap-3 w-full border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-5 cursor-pointer hover:border-uptag-orange dark:hover:border-uptag-orange hover:bg-orange-50/30 transition-all group">
                                        <span class="text-xl">🖼️</span>
                                        <div class="text-left">
                                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Imagen de Portada</p>
                                            <p class="text-[10px] text-slate-400 uppercase tracking-tighter">JPG, PNG hasta 5MB</p>
                                        </div>
                                    </label>
                                </div>

                                {{-- Input PDF (Nuevo) --}}
                                <div class="relative group">
                                    <input type="file" name="documento_pdf" class="hidden" id="file-pdf" accept=".pdf" onchange="updateLabel(this, 'label-pdf')">
                                    <label for="file-pdf" id="label-pdf" class="flex items-center justify-center gap-3 w-full border-2 border-dashed border-slate-200 dark:border-slate-700 rounded-2xl p-5 cursor-pointer hover:border-red-500 dark:hover:border-red-500/50 hover:bg-red-50/30 transition-all group">
                                        <span class="text-xl">📄</span>
                                        <div class="text-left">
                                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Documentación PDF</p>
                                            <p class="text-[10px] text-slate-400 uppercase tracking-tighter">Planos o Memoria Descriptiva</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex flex-col md:flex-row items-center justify-between border-t border-slate-100 dark:border-slate-800 pt-8 gap-6">
                        {{-- Texto informativo con hover naranja --}}
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium italic hover:text-uptag-orange dark:hover:text-uptag-orange transition-colors cursor-default max-w-md">
                            * Asegúrese de que toda la información técnica coincida con el presupuesto aprobado para el proyecto 2026.
                        </p>

                        {{-- Botón con respuesta inversa en modo oscuro y hover naranja en modo claro --}}
                        <button type="submit" class="group relative bg-slate-900 dark:bg-uptag-orange text-white dark:text-slate-950 px-10 py-4 rounded-2xl font-black transition-all shadow-xl shadow-slate-900/20 dark:shadow-orange-900/30 uppercase text-xs tracking-[0.15em] hover:bg-uptag-orange hover:text-slate-950 dark:hover:bg-white active:scale-95 overflow-hidden">
                            <span class="relative z-10 flex items-center gap-2">
                                Confirmar y Registrar
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabla Proyectos (Manteniendo la estructura anterior con mejoras visuales) --}}
            <div class="bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-800 overflow-hidden">
                <div class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/20">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Listado de Proyectos Activos
                    </h3>
                </div>
                <div class="p-8">
                    <table id="miTablaGenerica" class="w-full text-sm">
                        <thead class="text-slate-400 dark:text-slate-500 uppercase text-[10px] tracking-[0.2em]">
                            <tr>
                                <th class="pb-6 text-left">Detalles de Obra</th>
                                <th class="pb-6 text-left">Responsable</th>
                                <th class="pb-6 text-center">Estado</th>
                                <th class="pb-6 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            @foreach($proyectos as $p)
                            <tr class="group hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-all">
                                <td class="py-6">
                                    <div class="font-bold text-slate-800 dark:text-slate-200 group-hover:text-uptag-orange transition-colors">{{ $p->titulo }}</div>
                                    <div class="flex gap-2 mt-1">
                                        <span class="text-[9px] bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md text-slate-500 font-bold uppercase tracking-tighter">{{ $p->tipo }}</span>
                                    </div>
                                </td>
                                <td class="py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                            {{ substr($p->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-slate-600 dark:text-slate-400 font-semibold">{{ $p->user->name ?? 'No asignado' }}</span>
                                    </div>
                                </td>
                                <td class="py-6 text-center">
                                    <span class="px-4 py-1.5 bg-emerald-100/50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-xl font-black text-[9px] uppercase tracking-widest">Ejecución</span>
                                </td>
                                <td class="py-6 text-right">
                                    <a href="{{ route('admin.proyectos.edit', $p->id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:bg-uptag-orange hover:text-white dark:hover:bg-uptag-orange dark:hover:text-slate-900 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                        </svg>
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
        /* Estilos personalizados DataTables */
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #1e293b;
            border: 1px solid #334155;
            color: #f1f5f9;
            border-radius: 12px;
            padding: 8px 16px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #f97316 !important;
            border-color: #f97316 !important;
            color: white !important;
            border-radius: 10px;
        }
    </style>

    <script>
        function updateLabel(input, labelId) {
            const label = document.getElementById(labelId);
            if (input.files && input.files[0]) {
                const fileName = input.files[0].name;
                label.classList.add('border-solid', 'bg-orange-50', 'dark:bg-orange-900/20', 'border-uptag-orange');
                label.querySelector('p').innerText = "Seleccionado:";
                label.querySelector('.uppercase').innerText = fileName;
            }
        }

        $(document).ready(function() {
            $('#miTablaGenerica').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                "pageLength": 6,
                "dom": '<"flex flex-col md:flex-row justify-between items-center gap-4 mb-8"f>rt<"mt-8 flex justify-between items-center"ip>'
            });
        });
    </script>
</x-app-layout>
