<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nuevo Trabajador / Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-3 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-[2rem] border border-gray-100">
                <div class="bg-white p-8">
                    <form action="{{ route('admin.empleados.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Cédula</label>
                            <input type="text" name="cedula"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    maxlength="8"
                                    value="{{ old('cedula') }}"
                                    placeholder="Ej: 25123456"
                                    class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
                            @error('cedula')
                                <p class="text-red-600 text-xs mt-1 font-bold flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" /></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Nombre y Apellido</label>
                            <input type="text" name="name"
                                    oninput="this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g, '')"
                                    value="{{ old('name') }}"
                                    placeholder="Ej: Juan Perez"
                                    class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Correo Electrónico (Usuario)</label>
                            <input type="email" name="email"
                                    value="{{ old('email') }}"
                                    placeholder="juan.perez@uptag.edu.ve"
                                    class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
                            @error('email')
                                <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Contraseña Provisional</label>
                            <input type="password" name="password"
                                    placeholder="Mínimo 8 caracteres"
                                    class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Tipo de Trabajador</label>
                            <select name="tipo_trabajador" class="w-full rounded-xl border-gray-300">
                                <option value="ADM/FIJO">ADM/FIJO</option>
                                <option value="ADM/CONT">ADM/CONT</option>
                                <option value="DOC/ORDINARIO">DOC/ORDINARIO</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold mb-2 text-slate-700">Sección / Departamento</label>
                            <input type="text" name="seccion" placeholder="Ej: Sala Técnica" class="w-full rounded-xl border-gray-300">
                        </div>

                        <div class="flex items-center justify-end mt-8 space-x-4">
                            <a href="{{ route('admin.empleados.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-transparent rounded-xl font-bold text-xs text-gray-600 uppercase tracking-widest hover:bg-gray-200 transition">
                                {{ __('Cancelar') }}
                            </a>

                            <x-primary-button
                                type="submit"
                                onclick="this.innerHTML='Creando Cuenta...'; this.style.opacity='0.7';"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 py-3 rounded-xl transition shadow-lg shadow-indigo-200">
                                {{ __('+ Registrar y Crear Usuario') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

