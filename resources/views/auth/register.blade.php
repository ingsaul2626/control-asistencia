<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-orange-100 dark:bg-orange-500/10 rounded-xl mb-3 shadow-inner">
            <svg class="w-6 h-6 text-orange-600 dark:text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h2 class="text-xl font-black text-slate-800 dark:text-white tracking-tight italic uppercase">Registro de Usuario</h2>
        <p class="text-slate-400 dark:text-slate-500 text-[9px] font-black uppercase tracking-[0.2em] mt-1">Crea tu cuenta en el sistema operativo</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Cédula --}}
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1">Cédula</label>
                <input type="text" name="cedula"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    maxlength="8"
                    value="{{ old('cedula') }}"
                    placeholder="Ej: 25123456"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-600" required>
                @error('cedula')
                    <p class="text-rose-600 dark:text-rose-400 text-[10px] mt-1 font-black uppercase tracking-tighter">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1">Teléfono</label>
                <input type="text" name="telefono"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
                    value="{{ old('telefono') }}"
                    placeholder="Ej: 04141234567"
                    class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm transition-all shadow-sm placeholder:text-slate-300 dark:placeholder:text-slate-600" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Cargo --}}
            <div>
                <x-input-label for="cargo" :value="__('Cargo')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <select name="cargo" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm shadow-sm" required>
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Docente Ordinario" {{ old('cargo') == 'Docente Ordinario' ? 'selected' : '' }}>Docente Ordinario</option>
                    <option value="Administrativo Fijo" {{ old('cargo') == 'Administrativo Fijo' ? 'selected' : '' }}>Administrativo Fijo</option>
                    <option value="Administrativo Contratado" {{ old('cargo') == 'Administrativo Contratado' ? 'selected' : '' }}>Administrativo Contratado</option>
                    <option value="Obrero" {{ old('cargo') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                </select>
            </div>

            {{-- Tipo de Trabajador --}}
            <div>
                <x-input-label for="tipo_trabajador" :value="__('Tipo')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <select name="tipo_trabajador" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm shadow-sm" required>
                    <option value="" disabled selected>Seleccione...</option>
                    <option value="Docente" {{ old('tipo_trabajador') == 'Docente' ? 'selected' : '' }}>Docente</option>
                    <option value="Administrativo" {{ old('tipo_trabajador') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                    <option value="Obrero" {{ old('tipo_trabajador') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                </select>
            </div>
        </div>

        {{-- Sección --}}
        <div>
            <x-input-label for="seccion" :value="__('Sección o Unidad')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
            <select name="seccion" id="seccion" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm shadow-sm" required>
                <option value="" disabled selected>Seleccione la sección...</option>
                <option value="Sala Técnica" {{ old('seccion') == 'Sala Técnica' ? 'selected' : '' }}>Sala Técnica</option>
                <option value="Inspección de Obras" {{ old('seccion') == 'Inspección de Obras' ? 'selected' : '' }}>Inspección de Obras</option>
                <option value="Administración" {{ old('seccion') == 'Administración' ? 'selected' : '' }}>Administración</option>
            </select>
            <x-input-error :messages="$errors->get('seccion')" class="mt-1" />
        </div>

        {{-- Nombre Completo --}}
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
            <x-text-input id="name" class="block w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm" type="text" name="name" :value="old('name')" required />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
            <x-text-input id="email" class="block w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm" type="email" name="email" :value="old('email')" required />
        </div>

        {{-- Pregunta de Seguridad --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <select id="security_question" name="security_question" class="w-full rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 text-sm shadow-sm">
                    <option value="" disabled selected>Selecciona una...</option>
                    <option value="nombre_mascota">Nombre primera mascota</option>
                    <option value="ciudad_nacimiento">Ciudad de nacimiento</option>
                    <option value="nombre_madre">Segundo nombre de madre</option>
                    <option value="escuela_primaria">Escuela primaria</option>
                </select>
            </div>
            <div>
                <x-input-label for="security_answer" :value="__('Respuesta')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <x-text-input id="security_answer" class="block w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm" type="text" name="security_answer" required />
            </div>
        </div>

        {{-- Passwords --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" :value="__('Contraseña')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <x-text-input id="password" class="block w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm" type="password" name="password" required />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirmar')" class="text-[10px] font-black uppercase tracking-widest text-slate-700 dark:text-slate-400 mb-1 ml-1" />
                <x-text-input id="password_confirmation" class="block w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm" type="password" name="password_confirmation" required />
            </div>
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-xs font-bold text-slate-400 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-500 uppercase tracking-tighter transition-all" href="{{ route('login') }}">
                {{ __('¿Ya tienes cuenta?') }}
            </a>
            <x-primary-button class="bg-orange-600 hover:bg-orange-700 dark:bg-orange-600 dark:hover:bg-orange-500 shadow-lg shadow-orange-100 dark:shadow-none font-black uppercase tracking-widest text-xs py-3 px-6 rounded-xl border-none">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
