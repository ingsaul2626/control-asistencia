<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white/80 dark:bg-slate-950/80 backdrop-blur-xl sticky top-0 z-50 border-b border-slate-100 dark:border-slate-800/60 shadow-sm transition-all duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="transition-transform duration-300 group-hover:scale-105">
                        <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto drop-shadow-sm dark:brightness-125 dark:contrast-125" alt="Logo">
                    </a>
                </div>

                {{-- Menú Izquierdo --}}
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $navClasses = "text-[11px] font-black uppercase tracking-[0.15em] dark:text-slate-400 dark:hover:text-orange-500 transition-colors duration-200";
                    @endphp

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="{{ $navClasses }}">
                        {{ __('Panel') }}
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.panelControl')" :active="request()->routeIs('admin.panelControl.*')" class="{{ $navClasses }}">
                            {{ __('Seguimiento') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.asistencias.index')" :active="request()->routeIs('admin.asistencias.*')" class="{{ $navClasses }}">
                             {{ __('Asistencias') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.proyectos.index')" :active="request()->routeIs('admin.proyectos.*')" class="{{ $navClasses }}">
                             {{ __('Proyectos') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.*')" class="{{ $navClasses }}">
                             {{ __('Usuarios') }}
                        </x-nav-link>

                        <x-nav-link :href="url('/bitacora')" :active="request()->is('bitacora')" class="{{ $navClasses }}">
                            {{ __('Bitácora') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('user.asignaciones')" :active="request()->routeIs('user.asignaciones')" class="{{ $navClasses }}">
                            {{ __('Mis Asignaciones') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @if(auth()->user()->role === 'admin')
                    {{-- Botón Reporte --}}
                    <a href="{{ route('admin.reporte.hoy') }}" class="inline-flex items-center px-4 py-2 bg-rose-50 dark:bg-rose-500/10 hover:bg-rose-100 dark:hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-rose-100 dark:border-rose-500/20 group">
                        <svg class="w-4 h-4 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        Reporte PDF
                    </a>
                @endif

                {{-- CAMPANA CON DESPLEGABLE DINÁMICO --}}
                <div class="relative" @click.away="notificationsOpen = false">
                    @php
                        $is_admin = auth()->user()->role === 'admin';
                        $notifs = collect();
                        $count = 0;

                        if (\Schema::hasTable('actividads')) {
                            if ($is_admin) {
                                $notifs = \App\Models\Actividad::with('user')->latest()->take(5)->get();
                                $count = \App\Models\Actividad::where('leido', false)->count();
                            } else {
                                $notifs = \App\Models\Actividad::where('user_id', auth()->id())->latest()->take(5)->get();
                                $count = \App\Models\Actividad::where('user_id', auth()->id())->where('leido', false)->count();
                            }
                        }
                    @endphp

                    {{-- Botón de Campana --}}
                    <button id="boton-campana" @click="notificationsOpen = !notificationsOpen" class="relative inline-flex items-center p-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-500 dark:text-slate-400 hover:bg-white dark:hover:bg-slate-800 hover:text-orange-500 dark:hover:text-orange-500 hover:shadow-sm rounded-2xl transition-all duration-200 group">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>

                        @if($count > 0)
                            <span id="contador-notificaciones" class="absolute -top-1 -right-1 flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full h-4 w-4 flex items-center justify-center font-black">
                                    {{ $count > 9 ? '+9' : $count }}
                                </span>
                            </span>
                        @endif
                    </button>

                    {{-- Panel Desplegable --}}
                    <div x-show="notificationsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-2xl z-50 overflow-hidden"
                         style="display: none;">

                        <div class="px-5 py-4 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500">
                                {{ $is_admin ? 'Actividad Reciente' : 'Mis Notificaciones' }}
                            </h3>
                            @if(!$is_admin && $count > 0)
                                <form action="{{ route('notificaciones.leer') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[9px] bg-white dark:bg-slate-800 px-2 py-1 rounded-lg border border-slate-200 dark:border-slate-700 text-orange-600 dark:text-orange-500 font-black uppercase hover:bg-orange-50 dark:hover:bg-orange-950/30 transition-colors">
                                        Limpiar
                                    </button>
                                </form>
                            @endif
                        </div>

                        <div class="max-h-[450px] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-700">
                            @forelse($notifs as $n)
                                @php
                                    $tipo = strtolower($n->accion ?? $n->titulo);
                                    $config = [
                                        'proyecto'   => ['bg' => 'bg-orange-50 dark:bg-orange-500/10', 'text' => 'text-orange-600 dark:text-orange-500', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                                        'asistencia' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'entrada'    => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-600 dark:text-emerald-400', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'error'      => ['bg' => 'bg-rose-50 dark:bg-rose-500/10', 'text' => 'text-rose-600 dark:text-rose-400', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                                        'eliminación'=> ['bg' => 'bg-orange-50 dark:bg-orange-500/10', 'text' => 'text-orange-600 dark:text-orange-500', 'icon' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16'],
                                        'actualización' => ['bg' => 'bg-amber-50 dark:bg-amber-500/10', 'text' => 'text-amber-600 dark:text-amber-400', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                                        'default'    => ['bg' => 'bg-slate-50 dark:bg-slate-800', 'text' => 'text-slate-500 dark:text-slate-400', 'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z']
                                    ];
                                    $style = collect($config)->first(fn($v, $k) => str_contains($tipo, $k)) ?? $config['default'];
                                @endphp

                                <div class="group relative px-5 py-4 border-b border-slate-100 dark:border-slate-800 {{ !$n->leido ? 'bg-orange-50/30 dark:bg-orange-500/5' : 'bg-white dark:bg-slate-900' }} hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200">
                                    @if(!$n->leido)
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-orange-500"></div>
                                    @endif

                                    <div class="flex items-start gap-4">
                                        <div class="h-10 w-10 rounded-xl {{ $style['bg'] }} {{ $style['text'] }} flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $style['icon'] }}" />
                                            </svg>
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline mb-0.5">
                                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 dark:text-slate-500">
                                                    {{ $n->accion ?? 'Notificación' }}
                                                </span>
                                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-medium">
                                                    {{ $n->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <p class="text-sm leading-relaxed {{ !$n->leido ? 'text-slate-900 dark:text-slate-100 font-semibold' : 'text-slate-500 dark:text-slate-400' }}">
                                                @if($is_admin)
                                                    <span class="text-orange-500 font-bold">{{ $n->user->name ?? 'Sistema' }}</span>
                                                @endif
                                                <span class="text-slate-700 dark:text-slate-300">{{ $n->detalles ?? $n->mensaje }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="flex flex-col items-center justify-center py-12 px-5 text-center">
                                    <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-full mb-3 border border-slate-100 dark:border-slate-700">
                                        <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Bandeja vacía</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ $is_admin ? url('/bitacora') : route('user.asignaciones') }}" class="block py-4 text-center text-[10px] font-black uppercase tracking-widest text-orange-600 dark:text-orange-500 bg-orange-50/50 dark:bg-orange-500/10 hover:bg-orange-100 dark:hover:bg-orange-500/20 transition-colors">
                            Ver Historial Completo
                        </a>
                    </div>
                </div>

                {{-- SWITCH MODO OSCURO --}}
                <button onclick="toggleTheme()" class="p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-100 dark:border-slate-800 text-slate-500 dark:text-orange-400 hover:bg-white dark:hover:bg-slate-800 hover:border-orange-500/50 transition-all duration-300 group">
                    <svg class="hidden dark:block w-5 h-5 group-hover:rotate-45 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                    </svg>
                    <svg class="block dark:hidden w-5 h-5 group-hover:-rotate-12 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                </button>

                {{-- Dropdown de Perfil --}}
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-100 dark:border-slate-800 text-sm leading-4 font-bold rounded-2xl text-slate-600 dark:text-slate-300 bg-slate-50 dark:bg-slate-900 hover:bg-white dark:hover:bg-slate-800 hover:border-orange-500/30 transition-all duration-300">
                            <div class="h-6 w-6 rounded-lg bg-gradient-to-br from-orange-400 to-orange-600 text-[10px] flex items-center justify-center text-white mr-2 shadow-sm uppercase font-black">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="max-w-[100px] truncate">{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 opacity-40 group-hover:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/30">
                             <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Rol asignado</p>
                             <p class="text-[11px] font-bold text-orange-600 dark:text-orange-500 uppercase">{{ auth()->user()->role }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs font-bold py-3 dark:text-slate-300 dark:hover:bg-slate-800 transition-colors">
                            {{ __('⚙️ Mi Perfil') }}
                        </x-dropdown-link>
                        <div class="border-t border-slate-50 dark:border-slate-800"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="text-xs font-black text-rose-500 py-3 dark:hover:bg-slate-800 transition-colors"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('🚪 Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Menú Hamburguesa Móvil --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-3 rounded-2xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-900 transition-colors border border-transparent dark:border-slate-800">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
{{-- Lógica de Notificaciones (Mantener igual) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const bellButton = document.querySelector('#boton-campana');
    const badge = document.querySelector('#contador-notificaciones');

    if (bellButton) {
        bellButton.addEventListener('click', function() {
            if (badge) {
                fetch('{{ route("notificaciones.leer") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        badge.remove();
                    }
                });
            }
        });
    }
});
</script>
