<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar usuarios: {{ $usuarios->name }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100 p-8">

                <h4 class="text-xs font-black text-gray-400 uppercase mb-8 tracking-widest">Información del usuarios</h4>

                <form action="{{ route('admin.usuarios.update', $usuarios->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nombre --}}
                        <div class="bg-gray-50 p-4 rounded-2xl border border-transparent hover:border-indigo-100 transition">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Nombre</label>
                            <input type="text" name="name" value="{{ old('name', $usuarios->name) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-gray-700 placeholder-gray-300" required>
                        </div>

                        {{-- Cédula (Nueva) --}}
                        <div class="bg-gray-50 p-4 rounded-2xl border border-transparent hover:border-indigo-100 transition">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula', $usuarios->cedula) }}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="8"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-gray-700 placeholder-gray-300" required>
                        </div>

                        {{-- Email --}}
                        <div class="bg-gray-50 p-4 rounded-2xl border border-transparent hover:border-indigo-100 transition">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email', $usuarios->email) }}"
                                   class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-gray-700 placeholder-gray-300" required>
                        </div>

                        {{-- Rol --}}
                        <div class="bg-gray-50 p-4 rounded-2xl border border-transparent hover:border-indigo-100 transition relative">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Rol</label>
                            <select name="role" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-gray-700 uppercase appearance-none cursor-pointer">
                                <option value="user" {{ $usuarios->role == 'user' ? 'selected' : '' }}>usuarios</option>
                                <option value="admin" {{ $usuarios->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-indigo-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- Área --}}
                        <div class="bg-gray-50 p-4 rounded-2xl border border-transparent hover:border-indigo-100 transition relative">
                            <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Área Asignada</label>
                            <select name="area" class="w-full bg-transparent border-0 focus:ring-0 p-0 text-sm font-bold text-gray-700 uppercase appearance-none cursor-pointer" required>
                                <option value="SALA TECNICA" {{ old('area', $usuarios->area) == 'SALA TECNICA' ? 'selected' : '' }}>SALA TECNICA</option>
                                <option value="INSPECCION DE OBRAS" {{ old('area', $usuarios->area) == 'INSPECCION DE OBRAS' ? 'selected' : '' }}>INSPECCION DE OBRAS</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-4 flex items-center text-indigo-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-4 border-t border-gray-50 pt-8">
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="text-xs font-bold text-gray-500 bg-gray-100 px-6 py-3 rounded-2xl hover:bg-gray-200 transition">
                           CANCELAR
                        </a>
                        <button type="submit"
                                class="text-xs font-bold text-white bg-indigo-600 px-6 py-3 rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            GUARDAR CAMBIOS
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
