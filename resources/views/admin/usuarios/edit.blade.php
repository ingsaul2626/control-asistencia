<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight uppercase tracking-tighter italic transition-colors">
            Editar usuarios: {{ $usuarios->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm overflow-hidden shadow-2xl shadow-slate-200/60 dark:shadow-none sm:rounded-[3rem] border border-white dark:border-slate-800 p-10 transition-all">

                <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-8 tracking-[0.3em]">Información del usuario</h4>

                <form action="{{ route('admin.usuarios.update', $usuarios->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 dark:hover:border-orange-900/50 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $usuarios->name) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" required>
                        </div>

                        {{-- Cédula --}}
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 dark:hover:border-orange-900/50 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula', $usuarios->cedula) }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="8"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" required>
                        </div>

                        {{-- Email --}}
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 dark:hover:border-orange-900/50 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuarios->email) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" required>
                        </div>

                        {{-- Rol --}}
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 dark:hover:border-orange-900/50 transition-all group relative">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Rol</label>
                            <select name="role" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase appearance-none cursor-pointer">
                                <option value="user" class="dark:bg-slate-900" {{ $usuarios->role == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" class="dark:bg-slate-900" {{ $usuarios->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-6 flex items-center text-uptag-orange opacity-40 group-hover:opacity-100 transition-opacity">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- Área --}}
                        <div class="bg-slate-50/50 dark:bg-slate-800/40 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 dark:hover:border-orange-900/50 transition-all group relative">
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Área Asignada</label>
                            <select name="area" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 dark:text-slate-200 uppercase appearance-none cursor-pointer" required>
                                <option value="SALA TECNICA" class="dark:bg-slate-900" {{ old('area', $usuarios->area) == 'SALA TECNICA' ? 'selected' : '' }}>SALA TECNICA</option>
                                <option value="INSPECCION DE OBRAS" class="dark:bg-slate-900" {{ old('area', $usuarios->area) == 'INSPECCION DE OBRAS' ? 'selected' : '' }}>INSPECCION DE OBRAS</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-6 flex items-center text-uptag-orange opacity-40 group-hover:opacity-100 transition-opacity">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4 border-t border-slate-100 dark:border-slate-800 pt-10">
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="text-[10px] font-black text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-800 px-8 py-4 rounded-[1.5rem] hover:bg-slate-200 dark:hover:bg-slate-700 transition-all uppercase tracking-widest">
                            CANCELAR
                        </a>
                        <button type="submit"
                                class="text-[10px] font-black text-white bg-uptag-orange px-8 py-4 rounded-[1.5rem] hover:bg-slate-900 dark:hover:bg-white dark:hover:text-slate-900 transition-all shadow-xl shadow-orange-200/50 dark:shadow-orange-900/20 uppercase tracking-widest">
                            GUARDAR CAMBIOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
