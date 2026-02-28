<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Recuperar Cuenta</h2>
        <p class="text-sm text-gray-600 px-4 mt-2">
            {{ __('Ingresa tu correo electrónico. Si la cuenta existe en nuestro sistema, podrás restablecer tu contraseña mediante tu pregunta de seguridad.') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black uppercase tracking-widest text-slate-400" />
            <x-text-input id="email" class="block mt-1 w-full border-slate-200" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-8 flex items-center justify-between gap-4">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all active:scale-95">
                {{ __('Validar Identidad') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline text-xs font-bold text-slate-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                {{ __('Cancelar y Salir') }}
            </button>
        </form>
    </div>
</x-guest-layout>
