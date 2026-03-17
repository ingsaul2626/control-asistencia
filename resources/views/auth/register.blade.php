<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-800">Registro de Usuario</h2>
    </div>

    <form method="POST" action="{{ route('register') }}">
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
                <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2 text-slate-700">Cargo</label>
            <select name="cargo" class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
                <option value="" disabled selected>Seleccione un cargo...</option>
                <option value="Docente Ordinario" {{ old('cargo') == 'Docente Ordinario' ? 'selected' : '' }}>Docente Ordinario</option>
                <option value="Administrativo Fijo" {{ old('cargo') == 'Administrativo Fijo' ? 'selected' : '' }}>Administrativo Fijo</option>
                <option value="Administrativo Contratado" {{ old('cargo') == 'Administrativo Contratado' ? 'selected' : '' }}>Administrativo Contratado</option>
                <option value="Obrero" {{ old('cargo') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="tipo_trabajador" :value="__('Tipo de Trabajador')" />
            <select name="tipo_trabajador" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                <option value="" disabled selected>Seleccione...</option>
                <option value="Docente" {{ old('tipo_trabajador') == 'Docente' ? 'selected' : '' }}>Docente</option>
                <option value="Administrativo" {{ old('tipo_trabajador') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                <option value="Obrero" {{ old('tipo_trabajador') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="seccion" :value="__('Sección')" />
                <select name="seccion" id="seccion" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                <option value="" disabled selected>Seleccione la sección...</option>
                <option value="Sala Técnica" {{ old('seccion') == 'Sala Técnica' ? 'selected' : '' }}>Sala Técnica</option>
                <option value="Inspección de Obras" {{ old('seccion') == 'Inspección de Obras' ? 'selected' : '' }}>Inspección de Obras</option>
                <option value="Administración" {{ old('seccion') == 'Administración' ? 'selected' : '' }}>Administración</option>
             </select>
    <x-input-error :messages="$errors->get('seccion')" class="mt-2" />
        </div>

        <div class="mb-4 mt-4">
            <label class="block text-sm font-bold mb-2 text-slate-700">Teléfono</label>
            <input type="text" name="telefono"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                value="{{ old('telefono') }}"
                placeholder="Ej: 04141234567"
                class="w-full rounded-xl border-gray-300 focus:ring-indigo-500" required>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
        </div>

        <div class="mt-4">
            <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" />
            <select id="security_question" name="security_question" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="" disabled selected>Selecciona una pregunta...</option>
                <option value="nombre_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="ciudad_nacimiento">¿En qué ciudad naciste?</option>
                <option value="nombre_madre">¿Cuál es el segundo nombre de tu madre?</option>
                <option value="escuela_primaria">¿Cómo se llamaba tu escuela primaria?</option>
            </select>
        </div>

        <div class="mt-4">
            <x-input-label for="security_answer" :value="__('Respuesta de Seguridad')" />
            <x-text-input id="security_answer" class="block mt-1 w-full" type="text" name="security_answer" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-slate-600 hover:text-indigo-600" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>
            <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
