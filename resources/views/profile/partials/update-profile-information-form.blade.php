<section class="relative">
    {{-- Background Decor (Opcional para dar profundidad) --}}
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-100/50 rounded-full blur-3xl"></div>

    <header class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="p-2 bg-indigo-600 rounded-xl shadow-lg shadow-indigo-200">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">
                {{ __('Información del Perfil') }}
            </h2>
        </div>
        <p class="text-sm font-medium text-slate-500 uppercase tracking-widest text-[10px]">
            {{ __("Gestión de identidad y credenciales de acceso") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Campo: Nombre --}}
            <div class="group relative">
                <x-input-label for="name" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block" :value="__('Nombre Completo')" />
                <div class="relative">
                    <x-text-input id="name" name="name" type="text"
                        class="block w-full border-slate-100 bg-white/50 backdrop-blur-sm rounded-2xl py-3 px-4 shadow-sm transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 group-hover:border-slate-200"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                </div>
                <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('name')" />
            </div>

            {{-- Campo: Email --}}
            <div class="group relative">
                <x-input-label for="email" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block" :value="__('Correo Electrónico')" />
                <div class="relative">
                    <x-text-input id="email" name="email" type="email"
                        class="block w-full border-slate-100 bg-white/50 backdrop-blur-sm rounded-2xl py-3 px-4 shadow-sm transition-all focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 group-hover:border-slate-200"
                        :value="old('email', $user->email)" required autocomplete="username" />
                </div>
                <x-input-error class="mt-2 text-[11px] font-bold" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-4 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <p class="text-xs font-bold text-amber-700 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            {{ __('Tu correo no ha sido verificado.') }}
                        </p>

                        <button form="send-verification" class="mt-2 text-[10px] font-black uppercase tracking-tighter text-indigo-600 hover:text-indigo-800 transition-colors">
                            {{ __('Reenviar enlace de verificación') }}
                        </button>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-black text-[10px] text-emerald-600 uppercase">
                                {{ __('Un nuevo enlace ha sido enviado.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- Footer del Formulario --}}
        <div class="flex items-center gap-6 pt-4 border-t border-slate-50">
            <button type="submit" class="relative group overflow-hidden px-8 py-3 bg-slate-900 rounded-2xl transition-all hover:shadow-xl hover:shadow-indigo-100 active:scale-95">
                <span class="relative z-10 text-white font-black text-xs uppercase tracking-widest">{{ __('Guardar Cambios') }}</span>
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-fuchsia-600 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-x-4"
                    x-transition:leave="transition ease-in duration-300"
                    x-init="setTimeout(() => show = false, 3000)"
                    class="flex items-center gap-2 text-emerald-600"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span class="text-xs font-black uppercase tracking-widest">{{ __('Actualizado') }}</span>
                </div>
            @endif
        </div>
    </form>
</section>
