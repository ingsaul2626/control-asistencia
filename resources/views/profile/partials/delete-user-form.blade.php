<section class="relative group p-8 bg-slate-50/50 rounded-3xl border border-slate-100 transition-all hover:bg-white hover:shadow-2xl hover:shadow-rose-100/50">
    {{-- Efecto de iluminación de fondo --}}
    <div class="absolute -top-6 -right-6 w-24 h-24 bg-rose-500/5 rounded-full blur-2xl group-hover:bg-rose-500/10 transition-colors"></div>

    <header class="relative mb-8">
        <div class="flex items-center gap-4 mb-3">
            <div class="flex-none w-12 h-12 flex items-center justify-center bg-rose-600 rounded-2xl shadow-lg shadow-rose-200 text-white transform group-hover:rotate-12 transition-transform duration-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tighter leading-none">
                    {{ __('Terminal de Purga') }}
                </h2>
                <p class="mt-1 text-[10px] font-black text-rose-500 uppercase tracking-[0.3em]">
                    {{ __('Protocolo de eliminación final') }}
                </p>
            </div>
        </div>

        <div class="max-w-xl">
            <p class="text-sm text-slate-500 font-medium leading-relaxed">
                {{ __('Al confirmar la purga, todos tus registros, activos digitales y credenciales serán fragmentados y eliminados permanentemente. Esta acción es irreversible según los protocolos de integridad del sistema.') }}
            </p>
        </div>
    </header>

    {{-- Botón de Acción Principal --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="relative inline-flex items-center justify-center px-10 py-4 overflow-hidden font-black text-xs uppercase tracking-[0.2em] text-rose-600 border-2 border-rose-600 rounded-2xl group/btn hover:text-white transition-all duration-300 active:scale-95"
    >
        <span class="absolute inset-0 w-full h-full bg-rose-600 transform -translate-x-full group-hover/btn:translate-x-0 transition-transform duration-300 ease-out"></span>
        <span class="relative">{{ __('Iniciar Secuencia de Borrado') }}</span>
    </button>

    {{-- Modal de Confirmación --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-0 overflow-hidden bg-white">
            @csrf
            @method('delete')

            {{-- Cabecera del Modal Estilo Alerta --}}
            <div class="bg-rose-600 p-8 text-white relative">
                <div class="absolute top-0 right-0 p-4 opacity-20 transform translate-x-4 -translate-y-4">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14h-2V9h2v5zm0 4h-2v-2h2v2zM1 21h22L12 2 1 21z"/></svg>
                </div>

                <h2 class="text-3xl font-black tracking-tighter mb-2 relative">
                    {{ __('¿Autorizar Purga?') }}
                </h2>
                <p class="text-rose-100 font-bold text-xs uppercase tracking-widest opacity-90">
                    {{ __('Se requiere validación de identidad') }}
                </p>
            </div>

            <div class="p-8">
                <div class="flex items-start gap-4 p-5 bg-rose-50 rounded-2xl border border-rose-100 mb-8">
                    <div class="flex-none p-2 bg-rose-100 rounded-lg text-rose-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <p class="text-xs font-bold text-rose-800 leading-relaxed">
                        {{ __('Para prevenir eliminaciones accidentales, ingresa tu clave maestra. Todos los datos vinculados a Saul Lugo serán borrados de la asistencia_db.') }}
                    </p>
                </div>

                <div class="space-y-2">
                    <x-input-label for="password" value="{{ __('Validación de Seguridad') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full border-slate-100 bg-slate-50 rounded-2xl py-4 px-6 focus:ring-4 focus:ring-rose-500/10 focus:border-rose-600 transition-all font-mono"
                        placeholder="••••••••••••"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[11px] font-black italic" />
                </div>

                <div class="mt-10 flex flex-col-reverse sm:flex-row justify-end gap-4">
                    <button
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-8 py-4 rounded-2xl text-[10px] font-black text-slate-400 uppercase tracking-widest hover:bg-slate-50 transition-colors"
                    >
                        {{ __('Abortar Operación') }}
                    </button>

                    <button
                        type="submit"
                        class="px-10 py-4 bg-slate-900 rounded-2xl text-[10px] font-black text-white uppercase tracking-[0.2em] shadow-xl shadow-slate-200 hover:bg-rose-600 hover:shadow-rose-200 transition-all active:scale-95"
                    >
                        {{ __('Confirmar Purga Total') }}
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</section>
