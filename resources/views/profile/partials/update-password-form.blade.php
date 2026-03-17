<section class="relative">
    {{-- Decoración sutil de fondo para profundidad --}}
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-rose-50/50 rounded-full blur-3xl -z-10"></div>

    <header class="mb-10">
        <div class="flex items-center gap-4 mb-3">
            <div class="p-3 bg-slate-900 rounded-2xl shadow-xl shadow-slate-200 ring-1 ring-white/20">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ __('Seguridad de Acceso') }}
                </h2>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                    {{ __('Actualización de credenciales maestras') }}
                </p>
            </div>
        </div>
        <p class="mt-2 text-sm text-slate-500 max-w-md leading-relaxed">
            {{ __('Para mantener la integridad de tu cuenta, utiliza una combinación compleja de caracteres aleatorios.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 gap-y-8 max-w-xl">
            {{-- Contraseña Actual --}}
            <div class="group">
                <x-input-label for="update_password_current_password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block" :value="__('Contraseña Actual')" />
                <div class="relative">
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="block w-full border-slate-100 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 group-hover:border-slate-200"
                        autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[11px] font-bold" />
            </div>

            <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-slate-100 to-transparent"></div>

            {{-- Nueva Contraseña --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                    <x-input-label for="update_password_password" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block" :value="__('Nueva Contraseña')" />
                    <x-text-input id="update_password_password" name="password" type="password"
                        class="block w-full border-slate-100 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 group-hover:border-slate-200"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[11px] font-bold" />
                </div>

                <div class="group">
                    <x-input-label for="update_password_password_confirmation" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block" :value="__('Confirmar Nueva')" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="block w-full border-slate-100 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 group-hover:border-slate-200"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[11px] font-bold" />
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center gap-6 pt-6">
            <button type="submit" class="relative group overflow-hidden px-10 py-3.5 bg-slate-900 rounded-2xl transition-all hover:shadow-2xl hover:shadow-slate-200 active:scale-95">
                <span class="relative z-10 text-white font-black text-xs uppercase tracking-[0.2em]">{{ __('Blindar Cuenta') }}</span>
                <div class="absolute inset-0 bg-gradient-to-r from-slate-800 to-indigo-900 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-2"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-2 px-4 py-2 bg-emerald-50 rounded-xl border border-emerald-100"
                >
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">{{ __('Clave Actualizada') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
