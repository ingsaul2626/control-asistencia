<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <nav class="flex mb-5 text-sm text-slate-500 italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Editar Proyecto</span>
            </nav>

            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 overflow-hidden border border-slate-100">
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 14.293L8 15l.707-4.071 12.293-12.293z"></path></svg>
                        Editar Proyecto: <span class="ml-2 font-light opacity-90">{{ $proyecto->titulo }}</span>
                    </h2>
                </div>

                <form action="{{ route('admin.proyectos.update', $proyecto->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2 group-focus-within:text-indigo-600 transition-colors">Título del Proyecto</label>
                            <input type="text" name="titulo" value="{{ $proyecto->titulo }}"
                                class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all placeholder:text-slate-400"
                                placeholder="Ej. Remodelación Fase 1" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Responsable Asignado</label>
                            <div class="relative">
                                <select name="user_id" class="w-full border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 appearance-none bg-slate-50">
                                    @foreach($usuarios as $user)
                                        <option value="{{ $user->id }}" {{ $proyecto->user_id == $user->id ? 'selected' : '' }}>
                                            👤 {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 py-4">
                            <div class="bg-slate-50 p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-colors">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Imagen de Portada</label>
                                <div class="flex items-center space-x-4">
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $proyecto->imagen) }}" class="w-20 h-20 object-cover rounded-lg shadow-md group-hover:opacity-75 transition">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-[10px] text-white bg-black/40 rounded-lg">Actual</div>
                                    </div>
                                    <input type="file" name="imagen" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                                </div>
                            </div>

                            <div class="bg-slate-50 p-4 rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-300 transition-colors">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Documentación / Plano</label>
                                <div class="flex flex-col space-y-2">
                                    @if($proyecto->archivo)
                                        <div class="flex items-center text-xs text-emerald-600 bg-emerald-50 p-2 rounded-lg border border-emerald-100">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                                            Archivo actual preservado
                                        </div>
                                    @endif
                                    <input type="file" name="archivo" class="text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-200 file:text-slate-700 hover:file:bg-slate-300 cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end space-x-4 border-t border-slate-100">
                            <a href="{{ route('admin.dashboard') }}" class="px-6 py-2.5 text-sm font-medium text-slate-600 hover:text-slate-800 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 active:scale-95 transition-all">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
