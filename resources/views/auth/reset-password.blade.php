<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Restablecer Contraseña</h2>
        <p class="text-slate-500 text-sm">Responde a tu pregunta de seguridad para continuar</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $request->email }}">

        @php
            // Obtenemos el usuario de forma segura
            $user = \App\Models\User::where('email', $request->email)->first();

            // Diccionario de preguntas (Asegúrate de que coincidan con los keys de tu DB)
            $preguntas = [
                'mascota' => '¿Cuál es el nombre de tu primera mascota?',
                'ciudad'  => '¿En qué ciudad naciste?',
                'escuela' => '¿Cuál era el nombre de tu primera escuela?',
                'color'   => '¿Cuál es tu color favorito?',
            ];

            // Si el usuario no tiene pregunta asignada, mostramos un texto genérico
            $preguntaTexto = $preguntas[$user->security_question ?? ''] ?? 'Por favor, responde a tu pregunta de seguridad configurada.';
        @endphp

        <div class="p-5 bg-indigo-50 border border-indigo-100 rounded-2xl shadow-sm">
            <label class="block text-sm font-bold text-indigo-900 mb-2">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    {{ $preguntaTexto }}
                </span>
            </label>
            <x-text-input
                name="security_answer"
                class="block w-full border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl"
                required
                autofocus
                placeholder="Escribe tu respuesta aquí..."
            />
            <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
        </div>

        <hr class="border-slate-100 my-2">

        <div class="space-y-1">
            <x-input-label for="password" value="Nueva Contraseña" class="text-slate-700 font-medium" />
            <x-text-input id="password"
                          class="block w-full px-4 py-3 border-slate-300 rounded-xl shadow-sm"
                          type="password"
                          name="password"
                          required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <x-input-label for="password_confirmation" value="Confirmar Contraseña" class="text-slate-700 font-medium" />
            <x-text-input id="password_confirmation"
                          class="block w-full px-4 py-3 border-slate-300 rounded-xl shadow-sm"
                          type="password"
                          name="password_confirmation"
                          required
                          placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-100 transition-all active:scale-[0.98]">
                {{ __('Actualizar y Guardar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
