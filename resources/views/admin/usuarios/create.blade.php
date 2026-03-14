<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
            Registrar Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-[2.5rem] border border-slate-100 p-8">

                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cédula --}}
                        <div>
                            <x-input-label for="cedula" :value="__('Cédula')" />
                            <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula')" required maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 25123456" />
                            <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                        </div>

                        {{-- Cargo --}}
                        <div>
                            <x-input-label for="cargo" :value="__('Cargo')" />
                            <select id="cargo" name="cargo" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Seleccione un cargo...</option>
                                <option value="Docente Ordinario" {{ old('cargo') == 'Docente Ordinario' ? 'selected' : '' }}>Docente Ordinario</option>
                                <option value="Administrativo Fijo" {{ old('cargo') == 'Administrativo Fijo' ? 'selected' : '' }}>Administrativo Fijo</option>
                                <option value="Administrativo Contratado" {{ old('cargo') == 'Administrativo Contratado' ? 'selected' : '' }}>Administrativo Contratado</option>
                                <option value="Obrero" {{ old('cargo') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                            </select>
                            <x-input-error :messages="$errors->get('cargo')" class="mt-2" />
                        </div>

                        {{-- Nombre --}}
                        <div class="md:col-span-2">
                            <x-input-label for="name" :value="__('Nombre Completo')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required placeholder="Ej. Juan Pérez" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2">
                            <x-input-label for="email" :value="__('Correo Electrónico')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="usuarios@correo.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Teléfono --}}
                        <div>
                            <x-input-label for="telefono" :value="__('Teléfono')" />
                            <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono')" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 04141234567" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                        </div>

                        {{-- Rol --}}
                        <div>
                            <x-input-label for="role" :value="__('Rol')" />
                            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="user">Usuario</option>
                                <option value="admin">Administrador</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                    </div>

                    {{-- Seguridad y Password --}}
                    <div class="mt-6 border-t pt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" />
                            <select id="security_question" name="security_question" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="" disabled selected>Selecciona una pregunta...</option>
                                <option value="nombre_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                                <option value="ciudad_nacimiento">¿En qué ciudad naciste?</option>
                                <option value="nombre_madre">¿Cuál es el segundo nombre de tu madre?</option>
                                <option value="escuela_primaria">¿Cómo se llamaba tu escuela primaria?</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="security_answer" :value="__('Respuesta de Seguridad')" />
                            <x-text-input id="security_answer" class="block mt-1 w-full" type="text" name="security_answer" required placeholder="Tu respuesta secreta" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Contraseña')" />
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        </div>

                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-4">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-xs font-bold text-slate-400 px-6 py-3 hover:text-slate-600 transition">CANCELAR</a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                            {{ __('REGISTRAR USUARIO') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
