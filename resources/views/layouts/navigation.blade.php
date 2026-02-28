<nav x-data="{ open: false, notificationsOpen: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="transition-transform duration-300 group-hover:scale-105">
                        <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto drop-shadow-sm" alt="Logo">
                    </a>
                </div>

                {{-- Menú Izquierdo --}}
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('admin.admin.panelControl')" :active="request()->routeIs('admin.admin.panelControl')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                            {{ __('Panel') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.empleados.index')" :active="request()->routeIs('admin.empleados.*')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                            {{ __('Personal') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.asistencias.index')" :active="request()->routeIs('admin.asistencias.*')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                             {{ __('Asistencias') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.proyectos.index')" :active="request()->routeIs('admin.proyectos.*')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                             {{ __('Proyectos') }}
                        </x-nav-link>

                        <x-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.*')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                             {{ __('Usuarios') }}
                        </x-nav-link>

                        <x-nav-link :href="url('/bitacora')" :active="request()->is('bitacora')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                            {{ __('Bitácora') }}
                        </x-nav-link>
                    @else
                        {{-- ENLACE PARA USUARIO COMÚN --}}
                        <x-nav-link :href="route('user.asignaciones')" :active="request()->routeIs('user.asignaciones')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                            {{ __('Mis Asignaciones') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                @if(auth()->user()->role === 'admin')
                    {{-- Botón Reporte --}}
                    <a href="{{ route('admin.reporte.hoy') }}" class="inline-flex items-center px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-rose-100 group">
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

                        if ($is_admin) {
                            // Verifica si existe la tabla de Actividad para evitar errores
                            if (\Schema::hasTable('actividads')) {
                                $notifs = \App\Models\Actividad::with('user')->latest()->take(5)->get();
                                $count = $notifs->count();
                            }
                        } else {
                            // Verifica si existe la tabla de notificaciones nativa de Laravel
                            if (\Schema::hasTable('notifications')) {
                                $notifs = auth()->user()->unreadNotifications()->take(5)->get();
                                $count = auth()->user()->unreadNotifications()->count();
                            }
                        }
                    @endphp

                    <button @click="notificationsOpen = !notificationsOpen" class="relative inline-flex items-center p-2.5 bg-slate-50 border border-slate-100 text-slate-500 hover:bg-white hover:text-indigo-600 hover:shadow-sm rounded-2xl transition-all duration-200 group">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>

                        @if($count > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                <span class="relative inline-flex items-center justify-center rounded-full h-5 w-5 bg-rose-500 text-[9px] font-black text-white">
                                    {{ $count }}
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
                         class="absolute right-0 mt-2 w-80 bg-white border border-slate-100 rounded-3xl shadow-xl z-50 overflow-hidden"
                         style="display: none;">

                        <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/50">
                            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                {{ $is_admin ? 'Actividad Reciente' : 'Mis Notificaciones' }}
                            </h3>
                        </div>

                        <div class="max-h-96 overflow-y-auto">
                            @forelse($notifs as $n)
                                <div class="px-5 py-4 border-b border-slate-50 hover:bg-slate-50 transition-colors">
                                    <div class="flex items-start gap-3">
                                        <div class="h-8 w-8 rounded-full {{ $is_admin ? 'bg-indigo-100 text-indigo-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center text-[10px] font-bold shrink-0">
                                            @if($is_admin)
                                                {{ substr($n->user->name ?? 'S', 0, 1) }}
                                            @else
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-xs text-slate-600 leading-snug">
                                                @if($is_admin)
                                                    <span class="font-bold text-slate-900">{{ $n->user->name ?? 'Sistema' }}</span> {{ $n->accion }} en {{ strtolower($n->modelo) }}
                                                @else
                                                    {{ $n->data['mensaje'] ?? 'Nueva actualización' }}
                                                @endif
                                            </p>
                                            <p class="text-[10px] text-slate-400 mt-1 uppercase font-bold tracking-tight">
                                                {{ $n->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="px-5 py-8 text-center text-xs text-slate-400 font-bold">
                                    No hay novedades por ahora
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ $is_admin ? url('/bitacora') : route('user.asignaciones') }}" class="block py-3 text-center text-[10px] font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors">
                            {{ $is_admin ? 'Ver toda la bitácora' : 'Ver todas mis asignaciones' }}
                        </a>
                    </div>
                </div>

                {{-- Dropdown de Perfil --}}
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-100 text-sm leading-4 font-bold rounded-2xl text-slate-600 bg-slate-50 hover:bg-white hover:shadow-sm transition-all duration-200">
                            <div class="h-6 w-6 rounded-full bg-indigo-600 text-[10px] flex items-center justify-center text-white mr-2 shadow-sm uppercase font-black">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-2">
                                <svg class="fill-current h-4 w-4 opacity-40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-50">
                             <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Rol asignado</p>
                             <p class="text-[11px] font-bold text-indigo-600 uppercase">{{ auth()->user()->role }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs font-bold py-3">
                            {{ __('⚙️ Mi Perfil') }}
                        </x-dropdown-link>
                        <div class="border-t border-slate-50"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="text-xs font-black text-rose-500 py-3"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('🚪 Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Menú Hamburguesa Móvil --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-3 rounded-2xl text-slate-400 hover:bg-slate-50 transition-colors">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
