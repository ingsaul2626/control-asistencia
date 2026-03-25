<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight uppercase tracking-tighter italic transition-colors">
            Registrar Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 dark:shadow-none sm:rounded-[3rem] border border-white dark:border-slate-800 p-10 transition-all">

                <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-8 tracking-[0.3em]">Formulario de Inscripción</h4>

                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cédula --}}
                        <div class="group">
                            <x-input-label for="cedula" :value="__('Cédula')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="cedula" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" type="text" name="cedula" :value="old('cedula')" required maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 25123456" />
                            <x-input-error :messages="$errors->get('cedula')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Cargo --}}
                        <div class="group">
                            <x-input-label for="cargo" :value="__('Cargo')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="cargo" name="cargo" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 h-[42px] transition-colors" required>
                                <option value="" disabled selected class="dark:bg-slate-900">Seleccione un cargo...</option>
                                <option value="Docente Ordinario" class="dark:bg-slate-900" {{ old('cargo') == 'Docente Ordinario' ? 'selected' : '' }}>Docente Ordinario</option>
                                <option value="Administrativo Fijo" class="dark:bg-slate-900" {{ old('cargo') == 'Administrativo Fijo' ? 'selected' : '' }}>Administrativo Fijo</option>
                                <option value="Administrativo Contratado" class="dark:bg-slate-900" {{ old('cargo') == 'Administrativo Contratado' ? 'selected' : '' }}>Administrativo Contratado</option>
                                <option value="Obrero" class="dark:bg-slate-900" {{ old('cargo') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                            </select>
                            <x-input-error :messages="$errors->get('cargo')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Tipo de Trabajador --}}
                        <div class="group">
                            <x-input-label for="tipo_trabajador" :value="__('Tipo de Trabajador')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="tipo_trabajador" name="tipo_trabajador" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 h-[42px] transition-colors" required>
                                <option value="" disabled selected class="dark:bg-slate-900">Seleccione...</option>
                                <option value="Docente" class="dark:bg-slate-900" {{ old('tipo_trabajador') == 'Docente' ? 'selected' : '' }}>Docente</option>
                                <option value="Administrativo" class="dark:bg-slate-900" {{ old('tipo_trabajador') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="Obrero" class="dark:bg-slate-900" {{ old('tipo_trabajador') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo_trabajador')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Sección --}}
                        <div class="group">
                            <x-input-label for="seccion" :value="__('Sección')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="seccion" name="seccion" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 h-[42px] transition-colors" required>
                                <option value="" disabled selected class="dark:bg-slate-900">Seleccione la sección...</option>
                                <option value="Sala Técnica" class="dark:bg-slate-900" {{ old('seccion') == 'Sala Técnica' ? 'selected' : '' }}>Sala Técnica</option>
                                <option value="Inspección de Obras" class="dark:bg-slate-900" {{ old('seccion') == 'Inspección de Obras' ? 'selected' : '' }}>Inspección de Obras</option>
                                <option value="Administración" class="dark:bg-slate-900" {{ old('seccion') == 'Administración' ? 'selected' : '' }}>Administración</option>
                            </select>
                            <x-input-error :messages="$errors->get('seccion')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Nombre --}}
                        <div class="md:col-span-2 group">
                            <x-input-label for="name" :value="__('Nombre Completo')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="name" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" type="text" name="name" :value="old('name')" required placeholder="Ej. Juan Pérez" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2 group">
                            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="email" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" type="email" name="email" :value="old('email')" required placeholder="usuarios@correo.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Teléfono --}}
                        <div class="group">
                            <x-input-label for="telefono" :value="__('Teléfono')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="telefono" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" type="text" name="telefono" :value="old('telefono')" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 04141234567" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Rol --}}
                        <div class="group">
                            <x-input-label for="role" :value="__('Rol')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="role" name="role" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 h-[42px] transition-colors" required>
                                <option value="user" class="dark:bg-slate-900" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" class="dark:bg-slate-900" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>
                    </div>

                    {{-- Seguridad y Password --}}
                    <div class="mt-10 border-t border-slate-100 dark:border-slate-800 pt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="security_question" name="security_question" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 h-[42px] transition-colors">
                                <option value="" disabled selected class="dark:bg-slate-900">Selecciona una pregunta...</option>
                                <option value="nombre_mascota" class="dark:bg-slate-900">¿Cuál es el nombre de tu primera mascota?</option>
                                <option value="ciudad_nacimiento" class="dark:bg-slate-900">¿En qué ciudad naciste?</option>
                            </select>
                            <x-input-error :messages="$errors->get('security_question')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="security_answer" :value="__('Respuesta de Seguridad')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="security_answer" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200 placeholder-slate-300 dark:placeholder-slate-600" type="text" name="security_answer" required placeholder="Tu respuesta secreta" />
                            <x-input-error :messages="$errors->get('security_answer')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="password" :value="__('Contraseña')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="password" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-[10px] font-black dark:text-slate-400 uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full border-slate-200 dark:border-slate-700 dark:bg-slate-800/50 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 dark:text-slate-200" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 gap-6">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-[10px] font-black text-slate-400 dark:text-slate-500 px-6 py-3 hover:text-slate-700 dark:hover:text-slate-300 transition uppercase tracking-widest">CANCELAR</a>
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-uptag-orange border border-transparent rounded-[1.5rem] font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-slate-900 dark:hover:bg-white dark:hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all shadow-xl shadow-orange-200/50 dark:shadow-orange-900/20">
                            {{ __('REGISTRAR USUARIO') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
