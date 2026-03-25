<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight uppercase tracking-tighter italic transition-colors">
                Perfil de usuarios: {{ $usuarios->name }}
            </h2>
            <a href="{{ route('admin.usuarios.index') }}" class="text-[10px] font-black text-uptag-orange bg-orange-50 dark:bg-orange-900/20 px-4 py-2 rounded-xl hover:bg-uptag-orange hover:text-white transition-all uppercase tracking-widest border border-orange-100 dark:border-orange-900/30">
                ← VOLVER AL LISTADO
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm overflow-hidden shadow-2xl shadow-slate-200/60 dark:shadow-none sm:rounded-[3rem] border border-white dark:border-slate-800 p-10 transition-all">

                {{-- Cabecera con Avatar Naranja --}}
                <div class="flex items-center gap-8 mb-10 border-b border-slate-100 dark:border-slate-800 pb-10">
                    <div class="h-28 w-28 rounded-[2rem] bg-uptag-orange flex items-center justify-center text-white text-5xl font-black shadow-2xl shadow-orange-200/50 dark:shadow-orange-900/40 rotate-3 transition-transform hover:rotate-0 duration-300">
                        <span class="-rotate-3 group-hover:rotate-0">{{ substr($usuarios->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black text-slate-800 dark:text-slate-100 uppercase tracking-tighter leading-none mb-2">{{ $usuarios->name }}</h3>
                        <p class="text-uptag-orange font-black tracking-[0.2em] text-xs uppercase">{{ $usuarios->role ?? 'usuarios SIN ROL' }}</p>
                    </div>
                </div>

                {{-- Detalles principales --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-50/50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 p-5 rounded-3xl transition-colors">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Correo Electrónico</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $usuarios->email }}</p>
                    </div>

                    <div class="bg-slate-50/50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 p-5 rounded-3xl transition-colors">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Cédula de Identidad</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $usuarios->cedula ?? 'No registrado' }}</p>
                    </div>

                    <div class="bg-slate-50/50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 p-5 rounded-3xl transition-colors">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Área Asignada</p>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300 italic text-uptag-orange">{{ $usuarios->area ?? 'Sin asignar' }}</p>
                    </div>

                    <div class="bg-slate-50/50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700/50 p-5 rounded-3xl transition-colors">
                        <p class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Estado de Aprobación</p>
                        @if($usuarios->is_approved)
                            <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase flex items-center gap-1 tracking-widest">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                APROBADO
                            </span>
                        @else
                            <span class="text-xs font-black text-orange-500 dark:text-orange-400 uppercase flex items-center gap-1 tracking-widest">
                                <svg class="w-3 h-3 animate-pulse" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                PENDIENTE
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Registro de Asistencia con acento naranja --}}
                <div class="mt-10 border-t border-slate-100 dark:border-slate-800 pt-10">
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-5 tracking-[0.3em]">Último Registro de Asistencia</h4>
                    <div class="flex justify-between items-center bg-orange-50/30 dark:bg-orange-900/10 p-8 rounded-[2.5rem] border border-orange-100/50 dark:border-orange-900/20">
                        <div class="text-center">
                            <p class="text-[10px] font-black text-orange-300 dark:text-orange-700 uppercase mb-2 tracking-widest">Entrada</p>
                            <p class="text-2xl font-black text-uptag-orange italic tracking-tighter">
                                {{ $usuarios->ultimaAsistencia->hora_entrada ?? '--:--' }}
                            </p>
                        </div>
                        {{-- Divisor naranja --}}
                        <div class="h-12 w-[1px] bg-orange-200 dark:bg-orange-800 opacity-50"></div>
                        <div class="text-center">
                            <p class="text-[10px] font-black text-orange-300 dark:text-orange-700 uppercase mb-2 tracking-widest">Salida</p>
                            <p class="text-2xl font-black text-uptag-orange italic tracking-tighter">
                                {{ $usuarios->ultimaAsistencia->hora_salida ?? '--:--' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Información de Registro --}}
                <div class="mt-10 border-t border-slate-100 dark:border-slate-800 pt-10">
                    <h4 class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase mb-5 tracking-[0.3em]">Auditoría de Registro</h4>
                    <div class="bg-slate-50/50 dark:bg-slate-800/40 p-6 rounded-[2rem] border border-slate-100 dark:border-slate-700/50">
                        <div class="grid grid-cols-2 gap-8 text-center md:text-left">
                            <div>
                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Creado en</p>
                                <p class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $usuarios->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase mb-1 tracking-widest">Último cambio</p>
                                <p class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $usuarios->updated_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
