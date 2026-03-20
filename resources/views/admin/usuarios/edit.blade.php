<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
            Editar usuarios: {{ $usuarios->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-2xl shadow-slate-200/60 sm:rounded-[3rem] border border-white p-10">

                <h4 class="text-[10px] font-black text-slate-400 uppercase mb-8 tracking-[0.3em]">Información del usuario</h4>

                <form action="{{ route('admin.usuarios.update', $usuarios->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        {{-- Cambio: hover:border-orange-100 --}}
                        <div class="bg-slate-50/50 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $usuarios->name) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 placeholder-slate-300" required>
                        </div>

                        {{-- Cédula --}}
                        <div class="bg-slate-50/50 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula', $usuarios->cedula) }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="8"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 placeholder-slate-300" required>
                        </div>

                        {{-- Email --}}
                        <div class="bg-slate-50/50 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 transition-all group">
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuarios->email) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 placeholder-slate-300" required>
                        </div>

                        {{-- Rol --}}
                        {{-- Cambio: Icono en uptag-orange --}}
                        <div class="bg-slate-50/50 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 transition-all group relative">
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Rol</label>
                            <select name="role" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 uppercase appearance-none cursor-pointer">
                                <option value="user" {{ $usuarios->role == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" {{ $usuarios->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-6 flex items-center text-uptag-orange opacity-40 group-hover:opacity-100 transition-opacity">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- Área --}}
                        <div class="bg-slate-50/50 p-5 rounded-[2rem] border border-transparent hover:border-orange-100 transition-all group relative">
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 tracking-widest group-hover:text-uptag-orange transition-colors">Área Asignada</label>
                            <select name="area" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-slate-700 uppercase appearance-none cursor-pointer" required>
                                <option value="SALA TECNICA" {{ old('area', $usuarios->area) == 'SALA TECNICA' ? 'selected' : '' }}>SALA TECNICA</option>
                                <option value="INSPECCION DE OBRAS" {{ old('area', $usuarios->area) == 'INSPECCION DE OBRAS' ? 'selected' : '' }}>INSPECCION DE OBRAS</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-6 flex items-center text-uptag-orange opacity-40 group-hover:opacity-100 transition-opacity">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 flex justify-end gap-4 border-t border-slate-100 pt-10">
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="text-[10px] font-black text-slate-500 bg-slate-100 px-8 py-4 rounded-[1.5rem] hover:bg-slate-200 transition-all uppercase tracking-widest">
                            CANCELAR
                        </a>
                        {{-- Cambio: bg-uptag-orange y shadow-orange-200 --}}
                        <button type="submit"
                                class="text-[10px] font-black text-white bg-uptag-orange px-8 py-4 rounded-[1.5rem] hover:bg-slate-900 transition-all shadow-xl shadow-orange-200/50 uppercase tracking-widest">
                            GUARDAR CAMBIOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
