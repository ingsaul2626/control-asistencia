<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <div class="w-1 h-8 bg-gradient-to-b from-indigo-600 to-fuchsia-600 rounded-full"></div>
            <h2 class="font-black text-3xl text-slate-800 tracking-tighter">
                {{ __('Configuración de Cuenta') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#f8fafc] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-12">

            {{-- SECCIÓN: INFORMACIÓN DE PERFIL --}}
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                <div class="relative p-8 sm:p-12 bg-white/80 backdrop-blur-xl border border-white shadow-2xl rounded-[2rem] overflow-hidden">
                    {{-- Decoración de fondo interna --}}
                    <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

                    <div class="relative max-w-2xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- SECCIÓN: SEGURIDAD (PASSWORD) --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-slate-200 to-slate-100 rounded-[2.5rem] blur opacity-20"></div>
                    <div class="relative p-8 bg-white border border-slate-100 shadow-xl rounded-[2rem] h-full">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: ZONA DE PELIGRO (DELETE) --}}
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-rose-500 to-orange-500 rounded-[2.5rem] blur opacity-0 group-hover:opacity-20 transition duration-500"></div>
                    <div class="relative p-8 bg-white border border-rose-50 border-dashed shadow-xl rounded-[2rem] h-full overflow-hidden">
                        {{-- Indicador visual de zona de peligro --}}
                        <div class="absolute top-0 right-0 p-4">
                            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            {{-- FOOTER DE SISTEMA (OPCIONAL) --}}
            <div class="text-center pt-8">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.5em]">
                    RegistryCore System v2.6 • Terminal ID: {{ request()->ip() }}
                </p>
            </div>
        </div>
    </div>

    <style>
        /* Tipografía y suavizado extra para 2026 */
        body {
            -webkit-font-smoothing: antialiased;
            letter-spacing: -0.01em;
        }

        /* Efecto de focus moderno para todos los inputs dentro de este layout */
        input:focus {
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1) !important;
            border-color: #6366f1 !important;
        }
    </style>
</x-app-layout>
