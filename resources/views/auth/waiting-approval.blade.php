<x-guest-layout>
    <div class="max-w-md w-full bg-white dark:bg-slate-900 rounded-[2.5rem] shadow-2xl shadow-orange-100/50 dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] border border-orange-50 dark:border-slate-800 p-10 text-center transition-colors duration-500">

        {{-- Icono de Reloj con resplandor adaptado --}}
        <div class="text-orange-500 dark:text-orange-500 mb-6 relative">
            <div class="absolute inset-0 bg-orange-200 dark:bg-orange-500 blur-2xl opacity-20 dark:opacity-10 rounded-full h-16 w-16 mx-auto"></div>
            <svg class="w-20 h-20 mx-auto relative" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>

        <h2 class="text-2xl font-black text-slate-800 dark:text-white uppercase tracking-tighter italic">Cuenta en Revisión</h2>

        <div class="mt-4 px-2">
            <p class="text-slate-500 dark:text-slate-400 text-[11px] font-bold uppercase tracking-wide leading-relaxed">
                @auth
                    Hola <span class="text-orange-600 dark:text-orange-500 font-black">{{ auth()->user()->name }}</span>, tus datos están siendo validados por un administrador del sistema.
                @else
                    Hola, tus datos están siendo validados por un administrador del sistema.
                @endauth
            </p>
            <p class="mt-2 text-[9px] font-black text-orange-400 dark:text-orange-500/80 uppercase tracking-[0.2em]">Recibirás acceso una vez verificado</p>
        </div>

        {{-- Botón de Salida Estilizado --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-10">
            @csrf
            <button type="submit" class="w-full bg-orange-600 dark:bg-orange-600 text-white font-black py-4 rounded-2xl hover:bg-orange-700 dark:hover:bg-orange-500 shadow-xl shadow-orange-200 dark:shadow-none transition-all active:scale-[0.97] uppercase tracking-widest text-xs border-none">
                Cerrar Sesión y Salir
            </button>
        </form>

        <div class="mt-6">
            <span class="inline-block w-8 h-1 bg-orange-100 dark:bg-slate-800 rounded-full"></span>
        </div>
    </div>
</x-guest-layout>
