<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20"> {{-- Aumentado a h-20 para más aire --}}
            <div class="flex">
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('dashboard') }}" class="transition-transform duration-300 group-hover:scale-105">
                        <img src="{{ asset('img/logo.png') }}" class="h-12 w-auto drop-shadow-sm" alt="Logo">
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    @if (auth()->user()->role === 'super_admin')
                         <x-nav-link :href="url('/bitacora')" :active="request()->is('bitacora')" class="text-[11px] font-black uppercase tracking-[0.15em]">
                            {{ __('Bitácora') }}
                         </x-nav-link>
                    @endif

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
                    @endif

                    @if(auth()->user()->role === 'user')
                        <x-nav-link :href="route('user.projects')" :active="request()->routeIs('user.projects')" class="text-[11px] font-black uppercase tracking-[0.15em] text-emerald-600">
                            {{ __('Mis Tareas') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">

                {{-- Botón de Reporte Rápido (Solo Admin) --}}
                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'super_admin')
                    <a href="{{ route('admin.reporte.hoy') }}" class="inline-flex items-center px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 text-[10px] font-black uppercase tracking-widest rounded-xl transition-all border border-rose-100 group">
                        <svg class="w-4 h-4 mr-2 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        Reporte PDF
                    </a>
                @endif

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

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-slate-100">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            {{-- Añadir aquí el resto de links responsivos con el mismo estilo --}}
        </div>
    </div>
</nav>
