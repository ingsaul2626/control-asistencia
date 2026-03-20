<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 rounded-2xl mb-4 shadow-inner">
            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight italic uppercase">Restablecer Contraseña</h2>
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mt-1">Responde a tu pregunta de seguridad para continuar</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $request->email }}">

        @php
            // Obtenemos el usuarios de forma segura
            $users = \App\Models\User::where('email', $request->email)->first();

            // Diccionario de preguntas (Ajustado a los keys comunes de DB)
            $preguntas = [
                'nombre_mascota'    => '¿Cuál es el nombre de tu primera mascota?',
                'ciudad_nacimiento' => '¿En qué ciudad naciste?',
                'nombre_madre'      => '¿Cuál es el segundo nombre de tu madre?',
                'escuela_primaria'  => '¿Cómo se llamaba tu escuela primaria?',
                'mascota' => '¿Cuál es el nombre de tu primera mascota?',
                'ciudad'  => '¿En qué ciudad naciste?',
                'escuela' => '¿Cuál era el nombre de tu primera escuela?',
                'color'   => '¿Cuál es tu color favorito?',
            ];

            $preguntaTexto = $preguntas[$users->security_question ?? ''] ?? 'Por favor, responde a tu pregunta de seguridad configurada.';
        @endphp

        {{-- Pregunta de Seguridad Box --}}
        <div class="p-5 bg-orange-50/50 border border-orange-100 rounded-2xl shadow-inner">
            <label class="block text-[10px] font-black uppercase tracking-widest text-orange-800 mb-3 ml-1">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $preguntaTexto }}
                </span>
            </label>
            <x-text-input
                name="security_answer"
                class="block w-full border-orange-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm placeholder:text-orange-200/50"
                required
                autofocus
                placeholder="Escribe tu respuesta aquí..."
            />
            <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
        </div>

        <div class="relative py-2">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-slate-100"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase font-black tracking-widest">
                <span class="bg-white px-3 text-slate-300">Nuevas credenciales</span>
            </div>
        </div>

        {{-- Nueva Contraseña --}}
        <div class="space-y-1">
            <x-input-label for="password" value="Nueva Contraseña" class="text-slate-700 font-black text-[10px] uppercase tracking-widest ml-1" />
            <x-text-input id="password"
                          class="block w-full px-4 py-3 border-slate-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm"
                          type="password"
                          name="password"
                          required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Confirmar Contraseña --}}
        <div class="space-y-1">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" class="text-slate-700 font-black text-[10px] uppercase tracking-widest ml-1" />
            <x-text-input id="password_confirmation"
                          class="block w-full px-4 py-3 border-slate-200 focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm"
                          type="password"
                          name="password_confirmation"
                          required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center bg-orange-600 hover:bg-orange-700 text-white font-black py-4 rounded-xl shadow-xl shadow-orange-100 transition-all active:scale-[0.98] uppercase tracking-[0.2em] text-xs">
                {{ __('Actualizar y Guardar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
