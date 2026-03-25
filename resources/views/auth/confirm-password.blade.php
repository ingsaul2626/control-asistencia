<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-100 dark:bg-orange-500/10 text-orange-600 dark:text-orange-500 rounded-2xl mb-4 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
        </div>

        <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Área Restringida</h2>

        <div class="mt-3 px-6">
            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-relaxed">
                {{ __('Esta es una zona segura de la aplicación. Por favor, confirme su contraseña para continuar.') }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="space-y-1">
            <x-input-label for="password" :value="__('Contraseña de Acceso')" class="text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1" />

            <x-text-input id="password"
                class="block w-full px-4 py-3 bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 dark:text-white text-sm"
                type="password"
                name="password"
                required
                placeholder="••••••••"
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <x-primary-button class="w-full justify-center py-4 bg-orange-600 dark:bg-orange-600 hover:bg-orange-700 dark:hover:bg-orange-500 text-white shadow-xl shadow-orange-100 dark:shadow-none transition-all active:scale-95 font-black uppercase tracking-[0.2em] text-xs rounded-xl border-none">
                {{ __('Confirmar Identidad') }}
            </x-primary-button>

            <a href="{{ url()->previous() }}" class="text-center text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-500 uppercase tracking-widest transition-colors">
                {{ __('Cancelar y Volver') }}
            </a>
        </div>
    </form>
</x-guest-layout>
