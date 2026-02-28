<x-guest-layout>
    <h2 class="text-xl font-bold text-center mb-4">Identificar Cuenta</h2>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <x-input-label for="email" value="Ingresa tu correo registrado" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-primary-button class="w-full justify-center">
                BUSCAR CUENTA Y VALIDAR
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
