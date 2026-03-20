<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
            Registrar Nuevo Usuario
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 sm:rounded-[3rem] border border-white p-10">

                <h4 class="text-[10px] font-black text-slate-400 uppercase mb-8 tracking-[0.3em]">Formulario de Inscripción</h4>

                <form method="POST" action="{{ route('admin.usuarios.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Cédula --}}
                        <div class="group">
                            <x-input-label for="cedula" :value="__('Cédula')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="cedula" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="text" name="cedula" :value="old('cedula')" required maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 25123456" />
                            <x-input-error :messages="$errors->get('cedula')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Cargo --}}
                        <div class="group">
                            <x-input-label for="cargo" :value="__('Cargo')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="cargo" name="cargo" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 h-[42px]" required>
                                <option value="" disabled selected>Seleccione un cargo...</option>
                                <option value="Docente Ordinario" {{ old('cargo') == 'Docente Ordinario' ? 'selected' : '' }}>Docente Ordinario</option>
                                <option value="Administrativo Fijo" {{ old('cargo') == 'Administrativo Fijo' ? 'selected' : '' }}>Administrativo Fijo</option>
                                <option value="Administrativo Contratado" {{ old('cargo') == 'Administrativo Contratado' ? 'selected' : '' }}>Administrativo Contratado</option>
                                <option value="Obrero" {{ old('cargo') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                            </select>
                            <x-input-error :messages="$errors->get('cargo')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Tipo de Trabajador --}}
                        <div class="group">
                            <x-input-label for="tipo_trabajador" :value="__('Tipo de Trabajador')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="tipo_trabajador" name="tipo_trabajador" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 h-[42px]" required>
                                <option value="" disabled selected>Seleccione...</option>
                                <option value="Docente" {{ old('tipo_trabajador') == 'Docente' ? 'selected' : '' }}>Docente</option>
                                <option value="Administrativo" {{ old('tipo_trabajador') == 'Administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="Obrero" {{ old('tipo_trabajador') == 'Obrero' ? 'selected' : '' }}>Obrero</option>
                            </select>
                            <x-input-error :messages="$errors->get('tipo_trabajador')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Sección --}}
                        <div class="group">
                            <x-input-label for="seccion" :value="__('Sección')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="seccion" name="seccion" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 h-[42px]" required>
                                <option value="" disabled selected>Seleccione la sección...</option>
                                <option value="Sala Técnica" {{ old('seccion') == 'Sala Técnica' ? 'selected' : '' }}>Sala Técnica</option>
                                <option value="Inspección de Obras" {{ old('seccion') == 'Inspección de Obras' ? 'selected' : '' }}>Inspección de Obras</option>
                                <option value="Administración" {{ old('seccion') == 'Administración' ? 'selected' : '' }}>Administración</option>
                            </select>
                            <x-input-error :messages="$errors->get('seccion')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Nombre --}}
                        <div class="md:col-span-2 group">
                            <x-input-label for="name" :value="__('Nombre Completo')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="name" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="text" name="name" :value="old('name')" required placeholder="Ej. Juan Pérez" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2 group">
                            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="email" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="email" name="email" :value="old('email')" required placeholder="usuarios@correo.com" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Teléfono --}}
                        <div class="group">
                            <x-input-label for="telefono" :value="__('Teléfono')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="telefono" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="text" name="telefono" :value="old('telefono')" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Ej: 04141234567" />
                            <x-input-error :messages="$errors->get('telefono')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        {{-- Rol --}}
                        <div class="group">
                            <x-input-label for="role" :value="__('Rol')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="role" name="role" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 h-[42px]" required>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuario</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>
                    </div>

                    {{-- Seguridad y Password --}}
                    <div class="mt-10 border-t border-slate-100 pt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <select id="security_question" name="security_question" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700 h-[42px]">
                                <option value="" disabled selected>Selecciona una pregunta...</option>
                                <option value="nombre_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                                <option value="ciudad_nacimiento">¿En qué ciudad naciste?</option>
                            </select>
                            <x-input-error :messages="$errors->get('security_question')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="security_answer" :value="__('Respuesta de Seguridad')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="security_answer" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="text" name="security_answer" required placeholder="Tu respuesta secreta" />
                            <x-input-error :messages="$errors->get('security_answer')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="password" :value="__('Contraseña')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="password" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="password" name="password" required />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group">
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-[10px] font-black uppercase tracking-widest group-hover:text-uptag-orange transition-colors" />
                            <x-text-input id="password_confirmation" class="block mt-1 w-full border-slate-200 focus:border-uptag-orange focus:ring-uptag-orange rounded-2xl shadow-sm text-sm font-bold text-slate-700" type="password" name="password_confirmation" required />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-12 gap-6">
                        <a href="{{ route('admin.usuarios.index') }}" class="text-[10px] font-black text-slate-400 px-6 py-3 hover:text-slate-700 transition uppercase tracking-widest">CANCELAR</a>
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-uptag-orange border border-transparent rounded-[1.5rem] font-black text-[10px] text-white uppercase tracking-[0.2em] hover:bg-slate-900 focus:bg-slate-900 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition-all shadow-xl shadow-orange-200/50">
                            {{ __('REGISTRAR USUARIO') }}
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
