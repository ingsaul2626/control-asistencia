<section class="relative group p-8 bg-slate-50/30 dark:bg-slate-900/40 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 transition-all hover:bg-white dark:hover:bg-slate-900 hover:shadow-2xl hover:shadow-orange-100/50 dark:hover:shadow-orange-950/20">
    {{-- Efecto de iluminación de fondo (Actualizado a Naranja) --}}
    <div class="absolute -top-6 -right-6 w-24 h-24 bg-orange-500/5 dark:bg-orange-500/10 rounded-full blur-2xl group-hover:bg-orange-500/10 dark:group-hover:bg-orange-500/20 transition-colors"></div>

    <header class="relative mb-8">
        <div class="flex items-center gap-4 mb-3">
            <div class="flex-none w-12 h-12 flex items-center justify-center bg-orange-600 rounded-2xl shadow-lg shadow-orange-200 dark:shadow-none text-white transform group-hover:rotate-12 transition-transform duration-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-tighter leading-none italic uppercase">
                    {{ __('Terminal de Purga') }}
                </h2>
                <p class="mt-1 text-[10px] font-black text-orange-600 dark:text-orange-400 uppercase tracking-[0.3em]">
                    {{ __('Protocolo de eliminación final') }}
                </p>
            </div>
        </div>

        <div class="max-w-xl">
            <p class="text-[11px] text-slate-400 dark:text-slate-500 font-bold uppercase leading-relaxed tracking-tight">
                {{ __('Al confirmar la purga, todos tus registros, activos digitales y credenciales serán fragmentados y eliminados permanentemente. Esta acción es irreversible según los protocolos de integridad del sistema.') }}
            </p>
        </div>
    </header>

    {{-- Botón de Acción Principal --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="relative inline-flex items-center justify-center px-10 py-4 overflow-hidden font-black text-xs uppercase tracking-[0.2em] text-orange-600 dark:text-orange-400 border-2 border-orange-600 dark:border-orange-500 rounded-2xl group/btn hover:text-white transition-all duration-300 active:scale-95 shadow-lg shadow-orange-50 dark:shadow-none"
    >
        <span class="absolute inset-0 w-full h-full bg-orange-600 transform -translate-x-full group-hover/btn:translate-x-0 transition-transform duration-300 ease-out"></span>
        <span class="relative italic">{{ __('Iniciar Secuencia de Borrado') }}</span>
    </button>

    {{-- Modal de Confirmación --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-0 overflow-hidden bg-white dark:bg-slate-900 rounded-[2rem] border dark:border-slate-800">
            @csrf
            @method('delete')

            {{-- Cabecera del Modal Estilo Alerta Naranja --}}
            <div class="bg-orange-600 p-10 text-white relative overflow-hidden">
                {{-- Icono de advertencia en el fondo --}}
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4">
                    <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M13 14h-2V9h2v5zm0 4h-2v-2h2v2zM1 21h22L12 2 1 21z"/></svg>
                </div>

                <h2 class="text-3xl font-black tracking-tighter mb-2 relative italic uppercase">
                    {{ __('¿Autorizar Purga?') }}
                </h2>
                <div class="flex items-center gap-2 relative">
                    <span class="w-2 h-2 bg-white rounded-full animate-ping"></span>
                    <p class="text-orange-100 font-bold text-[10px] uppercase tracking-[0.3em] opacity-90">
                        {{ __('Se requiere validación de identidad nivel 1') }}
                    </p>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-start gap-4 p-6 bg-orange-50 dark:bg-orange-500/5 rounded-2xl border border-orange-100 dark:border-orange-500/20 mb-8">
                    <div class="flex-none p-2 bg-orange-100 dark:bg-orange-500/20 rounded-xl text-orange-600 dark:text-orange-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <p class="text-[11px] font-black text-orange-900 dark:text-orange-200 leading-relaxed uppercase tracking-tight">
                        {{ __('Para prevenir eliminaciones accidentales, ingresa tu clave maestra. Todos los datos vinculados a Saul Lugo serán borrados de la asistencia_db.') }}
                    </p>
                </div>

                <div class="space-y-2">
                    <x-input-label for="password" value="{{ __('Validación de Seguridad') }}" class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest ml-1" />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="block w-full border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white rounded-2xl py-4 px-6 focus:ring-4 focus:ring-orange-500/10 focus:border-orange-600 transition-all font-mono placeholder:text-slate-300 dark:placeholder:text-slate-700"
                        placeholder="••••••••••••"
                    />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] font-black italic text-orange-600 dark:text-orange-400 uppercase" />
                </div>

                <div class="mt-12 flex flex-col-reverse sm:flex-row justify-end gap-4">
                    <button
                        type="button"
                        x-on:click="$dispatch('close')"
                        class="px-8 py-4 rounded-2xl text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-600 dark:hover:text-slate-300 transition-all"
                    >
                        {{ __('Abortar Operación') }}
                    </button>

                    <button
                        type="submit"
                        class="px-10 py-4 bg-slate-900 dark:bg-white rounded-2xl text-[10px] font-black text-white dark:text-slate-900 uppercase tracking-[0.2em] shadow-xl shadow-slate-200 dark:shadow-none hover:bg-orange-600 dark:hover:bg-orange-600 hover:text-white dark:hover:text-white hover:shadow-orange-200 transition-all active:scale-95 group"
                    >
                        <span class="group-hover:italic italic sm:not-italic">{{ __('Confirmar Purga Total') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </x-modal>
</section>
