<x-app-layout>
    <div class="py-12 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex mb-5 text-sm text-slate-500 dark:text-slate-400 italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-uptag-orange transition-colors">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Editar Proyecto</span>
            </nav>

            <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-xl shadow-slate-200/60 dark:shadow-none overflow-hidden border border-slate-100 dark:border-slate-800 transition-all">
                {{-- Header Degradado UPTAG --}}
                <div class="bg-gradient-to-r from-uptag-orange to-orange-500 px-8 py-8">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Editar Proyecto: <span class="ml-2 font-light opacity-90">{{ $proyecto->titulo }}</span>
                    </h2>
                </div>

                <form action="{{ route('admin.proyectos.update', $proyecto->id)}}" method="POST" enctype="multipart/form-data" class="p-8 md:p-10">
                    @csrf
                    @method('PUT')

                    <div class="space-y-8">
                        {{-- Título y Responsable --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="group">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 group-focus-within:text-uptag-orange transition-colors">Título del Proyecto</label>
                                <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}"
                                    class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 focus:border-uptag-orange text-slate-700 dark:text-slate-200 transition-all" required>
                            </div>
                            <div class="group">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2 group-focus-within:text-uptag-orange transition-colors">Responsable</label>
                                <select name="user_id" class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 focus:border-uptag-orange text-slate-700 dark:text-slate-200 transition-all">
                                    @foreach($usuarios as $users)
                                        <option value="{{ $users->id }}" {{ $proyecto->user_id == $users->id ? 'selected' : '' }} class="dark:bg-slate-900">
                                            👤 {{ $users->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Campos de Fechas y Categoría --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio"
                                    value="{{ old('fecha_inicio', $proyecto->fecha_inicio ? \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('Y-m-d') : '') }}"
                                    class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 text-slate-700 dark:text-slate-200 dark:[color-scheme:dark]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Fecha Entrega</label>
                                <input type="date" name="fecha_entrega"
                                    value="{{ old('fecha_entrega', $proyecto->fecha_entrega ? \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('Y-m-d') : '') }}"
                                    class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 text-slate-700 dark:text-slate-200 dark:[color-scheme:dark]">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Categoría</label>
                                <select name="categoria" class="w-full bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 text-slate-700 dark:text-slate-200">
                                    <option value="" class="dark:bg-slate-900">Seleccione...</option>
                                    @foreach(['Obra', 'Mantenimiento', 'Infraestructura'] as $cat)
                                        <option value="{{ $cat }}" {{ old('categoria', $proyecto->categoria) == $cat ? 'selected' : '' }} class="dark:bg-slate-900">
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Archivos con diseño dinámico --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4">
                            {{-- Dropzone Imagen --}}
                            <div class="bg-slate-50 dark:bg-slate-800/30 p-6 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-uptag-orange dark:hover:border-uptag-orange transition-all group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Imagen de Portada</label>
                                <input type="file" name="imagen" class="text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-orange-50 dark:file:bg-orange-900/20 file:text-uptag-orange dark:file:text-orange-400 file:font-bold cursor-pointer">
                            </div>

                            {{-- Dropzone Archivo --}}
                            <div class="bg-slate-50 dark:bg-slate-800/30 p-6 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700 hover:border-uptag-orange dark:hover:border-uptag-orange transition-all group">
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Documentación / Plano (PDF)</label>
                                @if($proyecto->archivo)
                                    <div class="inline-flex items-center text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1.5 rounded-lg mb-4 truncate max-w-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                        </svg>
                                        {{ basename($proyecto->archivo) }}
                                    </div>
                                @endif
                                <input type="file" name="archivo" class="text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-slate-200 dark:file:bg-slate-700 file:text-slate-600 dark:file:text-slate-300 file:font-bold cursor-pointer">
                            </div>
                        </div>

                        {{-- Botonera --}}
                        <div class="pt-8 flex flex-col md:flex-row items-center justify-end space-y-4 md:space-y-0 md:space-x-6 border-t border-slate-100 dark:border-slate-800">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300 transition-colors uppercase tracking-widest">
                                Cancelar
                            </a>
                            <button type="submit" class="w-full md:w-auto px-10 py-4 bg-uptag-orange text-white dark:text-slate-950 text-xs font-black rounded-2xl hover:bg-orange-600 dark:hover:bg-white transition-all shadow-lg shadow-orange-500/20 dark:shadow-orange-900/10 uppercase tracking-[0.15em]">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <p class="mt-6 text-center text-[10px] text-slate-400 dark:text-slate-600 uppercase tracking-widest">
                Sistema de Automatización y Seguimiento • UPTAG 2026
            </p>
        </div>
    </div>
</x-app-layout>
