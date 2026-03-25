<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            {{-- Indicador vertical naranja --}}
            <div class="w-1.5 h-8 bg-gradient-to-b from-orange-600 to-orange-400 rounded-full shadow-sm shadow-orange-200 dark:shadow-orange-900/20"></div>
            <h2 class="font-black text-3xl text-slate-800 dark:text-white tracking-tighter italic uppercase">
                {{ __('Configuración de Cuenta') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fafafa] dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            {{-- SECCIÓN: INFORMACIÓN DE PERFIL --}}
            <div class="relative group">
                {{-- Glow exterior naranja --}}
                <div class="absolute -inset-1 bg-gradient-to-r from-orange-500 to-amber-500 rounded-[2.5rem] blur opacity-15 group-hover:opacity-30 transition duration-1000"></div>

                <div class="relative p-8 sm:p-12 bg-white/90 dark:bg-slate-900/90 backdrop-blur-2xl border border-orange-50 dark:border-slate-800 shadow-2xl rounded-[2.5rem] overflow-hidden">
                    {{-- Decoración de fondo interna --}}
                    <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-80 h-80 bg-orange-50 dark:bg-orange-500/5 rounded-full blur-3xl opacity-40"></div>

                    <div class="relative max-w-2xl">
                        <div class="mb-6 flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-[0.3em] text-orange-600 dark:text-orange-400 bg-orange-100 dark:bg-orange-500/10 px-3 py-1 rounded-lg">Ficha de Identidad</span>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- SECCIÓN: SEGURIDAD (PASSWORD) --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-slate-200 to-orange-100 dark:from-slate-800 dark:to-orange-900/20 rounded-[2.5rem] blur opacity-20 transition duration-500 group-hover:opacity-40"></div>
                    <div class="relative p-8 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl rounded-[2.5rem] h-full flex flex-col">
                        <div class="mb-6">
                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-orange-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                        </div>
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: ZONA DE PELIGRO (DELETE) --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-orange-600 rounded-[2.5rem] blur opacity-0 group-hover:opacity-10 transition duration-500"></div>
                    <div class="relative p-8 bg-white dark:bg-slate-900 border border-rose-100 dark:border-rose-900/30 border-dashed shadow-xl rounded-[2.5rem] h-full overflow-hidden">
                        {{-- Indicador visual de zona de peligro --}}
                        <div class="absolute top-0 right-0 p-6">
                            <div class="w-14 h-14 bg-rose-50 dark:bg-rose-500/10 rounded-2xl flex items-center justify-center text-rose-500 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER DE SISTEMA --}}
            <div class="text-center pt-8 border-t border-slate-100 dark:border-slate-800">
                <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.5em]">
                    RegistryCore System v2.6 • Terminal ID: {{ request()->ip() }} • Status: <span class="text-orange-500">Authenticated</span>
                </p>
            </div>
        </div>
    </div>

    <style>
        body {
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.01em;
        }

        /* Efecto de focus institucional naranja adaptable */
        input:focus, select:focus, textarea:focus {
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.15) !important;
            border-color: #ea580c !important;
            background-color: transparent !important;
        }

        /* En modo oscuro, asegurar que los labels y textos de ayuda de Laravel Breeze se vean bien */
        .dark label { color: #94a3b8; }
        .dark input { background-color: #0f172a; color: white; border-color: #1e293b; }

        /* Suavizado de transiciones para 2026 */
        .group:hover .group-hover\:opacity-30 {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</x-app-layout>
