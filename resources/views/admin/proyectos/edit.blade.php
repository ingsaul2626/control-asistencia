<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            {{-- Breadcrumb: Cambio a uptag-orange en hover --}}
            <nav class="flex mb-5 text-sm text-slate-500 italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-uptag-orange">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Editar Proyecto</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                {{-- Header: Cambio de índigo/violeta a naranja degradado --}}
                <div class="bg-gradient-to-r from-uptag-orange to-orange-500 px-8 py-6">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        Editar Proyecto: <span class="ml-2 font-light opacity-90">{{ $proyecto->titulo }}</span>
                    </h2>
                </div>

                <form action="{{ route('admin.proyectos.update', $proyecto->id)}}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        {{-- Título y Responsable --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Título del Proyecto</label>
                                {{-- Cambio: focus:ring-orange-100 focus:border-uptag-orange --}}
                                <input type="text" name="titulo" value="{{ old('titulo', $proyecto->titulo) }}"
                                    class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-100 focus:border-uptag-orange" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Responsable</label>
                                {{-- Cambio: focus:ring-orange-100 --}}
                                <select name="user_id" class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-100 bg-slate-50">
                                    @foreach($usuarios as $users)
                                        <option value="{{ $users->id }}" {{ $proyecto->user_id == $users->id ? 'selected' : '' }}>
                                            👤 {{ $users->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Campos de Fechas y Categoría --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha Inicio</label>
                                <input type="date" name="fecha_inicio"
                                    value="{{ old('fecha_inicio', $proyecto->fecha_inicio ? \Carbon\Carbon::parse($proyecto->fecha_inicio)->format('Y-m-d') : '') }}"
                                    class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Fecha Entrega</label>
                                <input type="date" name="fecha_entrega"
                                    value="{{ old('fecha_entrega', $proyecto->fecha_entrega ? \Carbon\Carbon::parse($proyecto->fecha_entrega)->format('Y-m-d') : '') }}"
                                    class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-100">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Categoría</label>
                                <select name="categoria" class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-orange-100 bg-slate-50">
                                    <option value="">Seleccione...</option>
                                    @foreach(['Obra', 'Mantenimiento', 'Infraestructura'] as $cat)
                                        <option value="{{ $cat }}" {{ old('categoria', $proyecto->categoria) == $cat ? 'selected' : '' }}>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Archivos --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4">
                            {{-- Cambio: hover:border-orange-300 y file:text-uptag-orange --}}
                            <div class="bg-slate-50 p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-orange-300 transition-colors">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Imagen de Portada</label>
                                <input type="file" name="imagen" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-orange-50 file:text-uptag-orange cursor-pointer">
                            </div>
                            <div class="bg-slate-50 p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-orange-300 transition-colors">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-3">Documentación / Plano</label>
                                @if($proyecto->archivo)
                                    <div class="text-[10px] text-emerald-600 bg-emerald-50 p-2 rounded-lg mb-2 truncate">
                                        Actual: {{ basename($proyecto->archivo) }}
                                    </div>
                                @endif
                                <input type="file" name="archivo" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:bg-slate-200 cursor-pointer">
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end space-x-4 border-t border-slate-100">
                            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800">Cancelar</a>
                            {{-- Cambio: bg-uptag-orange hover:bg-orange-600 --}}
                            <button type="submit" class="px-8 py-2.5 bg-uptag-orange text-white text-sm font-bold rounded-xl hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
