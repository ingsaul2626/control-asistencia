<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-slate-800">Bienvenido de nuevo</h2>
        <p class="text-slate-500 text-sm">Ingresa tus credenciales para acceder</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        <div class="space-y-1">
            <x-input-label for="email" :value="__('Correo Electrónico')" class="text-slate-700 font-medium" />
            <x-text-input id="email" class="block w-full px-4 py-3 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="tu@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="mt-5 space-y-1" x-data="{ show: false }">
            <x-input-label for="password" :value="__('Contraseña')" class="text-slate-700 font-medium" />
            <div class="relative">
                <input :type="show ? 'text' : 'password'"
                       id="password"
                       name="password"
                       class="block w-full pl-4 pr-12 py-3 border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition-all"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••">

                <button type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-indigo-600 transition-colors focus:outline-none">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors" name="remember">
                <span class="ms-2 text-sm text-slate-500 group-hover:text-slate-700 transition-colors">{{ __('Recordarme') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 transition-colors" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
        </div>

        <div id="captcha-wrapper" class="mt-6 flex flex-col items-center bg-slate-50 p-4 rounded-2xl border border-slate-100 shadow-inner" style="display: none;">
            <div class="g-recaptcha" data-sitekey="{{ env('NOCAPTCHA_SITEKEY') }}"></div>
            @if ($errors->has('g-recaptcha-response'))
                <p class="text-xs text-red-600 mt-2 font-medium">{{ $errors->first('g-recaptcha-response') }}</p>
            @endif
        </div>

        <div class="flex flex-col gap-4 mt-8">
            <x-primary-button id="login-btn" class="w-full justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-indigo-200 transition-all active:scale-[0.98]">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>

            @if (Route::has('register'))
                <div class="text-center">
                    <p class="text-sm text-slate-500">
                        ¿No tienes una cuenta?
                        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-500 hover:underline decoration-2 underline-offset-4 transition-all">
                            Regístrate ahora
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </form>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function checkCaptchaStatus() {
            const captchaContainer = document.getElementById('captcha-wrapper');
            if (navigator.onLine) {
                captchaContainer.style.display = 'flex';
            } else {
                captchaContainer.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', checkCaptchaStatus);
        window.addEventListener('online', checkCaptchaStatus);
        window.addEventListener('offline', checkCaptchaStatus);
    </script>
</x-guest-layout>
