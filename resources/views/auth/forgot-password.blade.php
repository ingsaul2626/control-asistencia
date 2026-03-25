<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-flex items-center justify-center w-14 h-14 bg-orange-100 dark:bg-orange-500/10 text-orange-600 dark:text-orange-500 rounded-2xl mb-4 shadow-inner">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
        <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Identificar Cuenta</h2>
        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">Verificación de credenciales de usuario</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        {{-- Input de Correo --}}
        <div>
            <x-input-label for="email" value="Ingresa tu correo registrado" class="text-[10px] font-black uppercase tracking-widest text-slate-500 dark:text-slate-400 ml-1 mb-1" />
            <x-text-input id="email"
                class="block w-full bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 focus:border-orange-500 dark:focus:border-orange-500 focus:ring-orange-500 rounded-xl shadow-sm transition-all placeholder:text-slate-300 dark:placeholder:text-slate-700 dark:text-white text-sm"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="ejemplo@correo.com"
                required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
        </div>

        {{-- Botón de Acción --}}
        <div class="mt-4">
            <x-primary-button class="w-full justify-center py-4 bg-orange-600 dark:bg-orange-600 hover:bg-orange-700 dark:hover:bg-orange-500 shadow-xl shadow-orange-100 dark:shadow-none transition-all active:scale-95 font-black uppercase tracking-[0.2em] text-xs rounded-xl border-none">
                BUSCAR CUENTA Y VALIDAR
            </x-primary-button>
        </div>
    </form>

    {{-- Enlace de retorno --}}
    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-[10px] font-black text-slate-400 dark:text-slate-500 hover:text-orange-600 dark:hover:text-orange-500 uppercase tracking-widest transition-colors flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Volver al inicio
        </a>
    </div>
</x-guest-layout>
