<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 dark:bg-orange-500/10 text-orange-600 dark:text-orange-500 rounded-2xl mb-4 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Recuperar Cuenta</h2>

        <div class="mt-3 px-6">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-tight leading-relaxed">
                {{ __('Ingresa tu correo electrónico. Si la cuenta existe en nuestro sistema, podrás restablecer tu contraseña mediante tu pregunta de seguridad.') }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        {{-- Input de Correo --}}
        <div>
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1" />
            <x-text-input id="email"
                class="block mt-1 w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 dark:text-white text-sm"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
        </div>

        {{-- Botón de Acción Principal --}}
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-4 bg-orange-600 dark:bg-orange-600 hover:bg-orange-700 dark:hover:bg-orange-500 shadow-xl shadow-orange-100 dark:shadow-none transition-all active:scale-95 font-black uppercase tracking-[0.2em] text-xs rounded-xl border-none">
                {{ __('Validar Identidad') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Botón de Cancelar con estilo destructivo suave --}}
    <div class="mt-8 text-center border-t border-slate-100 dark:border-slate-800 pt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-rose-600 dark:hover:text-rose-500 uppercase tracking-[0.15em] transition-all flex items-center justify-center gap-2 mx-auto group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Cancelar y Salir') }}
            </button>
        </form>
    </div>
</x-guest-layout>
