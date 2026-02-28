<x-guest-layout>
    <div class="mb-6 text-center">

    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ej. Juan Pérez" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="usuario@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="security_question" :value="__('Pregunta de Seguridad')" />
            <select id="security_question" name="security_question" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="" disabled selected>Selecciona una pregunta...</option>
                <option value="nombre_mascota">¿Cuál es el nombre de tu primera mascota?</option>
                <option value="ciudad_nacimiento">¿En qué ciudad naciste?</option>
                <option value="nombre_madre">¿Cuál es el segundo nombre de tu madre?</option>
                <option value="escuela_primaria">¿Cómo se llamaba tu escuela primaria?</option>
            </select>
            <x-input-error :messages="$errors->get('security_question')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="security_answer" :value="__('Respuesta de Seguridad')" />
            <x-text-input id="security_answer" class="block mt-1 w-full" type="text" name="security_answer" required placeholder="Tu respuesta secreta" />
            <x-input-error :messages="$errors->get('security_answer')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-slate-600 hover:text-indigo-600 rounded-md focus:outline-none transition-colors" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="ms-4 bg-indigo-600 hover:bg-indigo-700">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
