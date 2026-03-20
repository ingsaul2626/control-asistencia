<section class="relative">
    {{-- Decoración sutil de fondo para profundidad (Actualizado a Naranja) --}}
    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-orange-50/50 rounded-full blur-3xl -z-10"></div>

    <header class="mb-10">
        <div class="flex items-center gap-4 mb-3">
            <div class="p-3 bg-slate-900 rounded-2xl shadow-xl shadow-orange-100 ring-1 ring-white/20">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight italic uppercase">
                    {{ __('Seguridad de Acceso') }}
                </h2>
                <p class="text-[10px] font-black text-orange-600 bg-orange-50 px-2 py-0.5 rounded-md uppercase tracking-[0.2em] inline-block">
                    {{ __('Actualización de credenciales maestras') }}
                </p>
            </div>
        </div>
        <p class="mt-2 text-sm text-slate-400 max-w-md leading-relaxed font-medium uppercase text-[11px] tracking-tight">
            {{ __('Para mantener la integridad de tu cuenta, utiliza una combinación compleja de caracteres aleatorios.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-8">
        @csrf
        @method('put')

        <div class="grid grid-cols-1 gap-y-8 max-w-xl">
            {{-- Contraseña Actual --}}
            <div class="group">
                <x-input-label for="update_password_current_password" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block" :value="__('Contraseña Actual')" />
                <div class="relative">
                    <x-text-input id="update_password_current_password" name="current_password" type="password"
                        class="block w-full border-slate-200 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-orange-500/10 focus:border-orange-600 group-hover:border-orange-300"
                        autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] font-black uppercase text-rose-600" />
            </div>

            <div class="h-[1px] w-full bg-gradient-to-r from-transparent via-orange-100 to-transparent"></div>

            {{-- Nueva Contraseña --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                    <x-input-label for="update_password_password" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block" :value="__('Nueva Contraseña')" />
                    <x-text-input id="update_password_password" name="password" type="password"
                        class="block w-full border-slate-200 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-orange-500/10 focus:border-orange-600 group-hover:border-orange-300"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px] font-black uppercase text-rose-600" />
                </div>

                <div class="group">
                    <x-input-label for="update_password_password_confirmation" class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block" :value="__('Confirmar Nueva')" />
                    <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                        class="block w-full border-slate-200 bg-white/60 backdrop-blur-md rounded-2xl py-3.5 px-4 shadow-sm transition-all focus:ring-4 focus:ring-orange-500/10 focus:border-orange-600 group-hover:border-orange-300"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[10px] font-black uppercase text-rose-600" />
                </div>
            </div>
        </div>

        {{-- Acciones --}}
        <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
            <button type="submit" class="relative group overflow-hidden px-12 py-4 bg-slate-900 rounded-2xl transition-all hover:shadow-2xl hover:shadow-orange-100 active:scale-95">
                <span class="relative z-10 text-white font-black text-xs uppercase tracking-[0.2em] italic">{{ __('Blindar Cuenta') }}</span>
                {{-- Efecto de hover naranja --}}
                <div class="absolute inset-0 bg-gradient-to-r from-orange-600 to-amber-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </button>

            @if (session('status') === 'password-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 -translate-x-2"
                    x-init="setTimeout(() => show = false, 4000)"
                    class="flex items-center gap-3 px-5 py-2.5 bg-emerald-50 rounded-xl border border-emerald-100"
                >
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em]">{{ __('Clave Actualizada') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
