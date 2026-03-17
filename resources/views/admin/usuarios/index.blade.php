<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
                Gestión de {{ __('usuarios') }}
            </h2>
            <a href="{{ route('admin.usuarios.create') }}"
               class="px-6 py-3 bg-slate-900 text-white font-black text-xs uppercase rounded-2xl hover:bg-indigo-600 transition-all shadow-lg shadow-indigo-200">
                + Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 sm:rounded-[2.5rem] border border-white p-4 md:p-8">

                {{-- Contenedor con overflow para permitir responsive --}}
                <div class="overflow-x-auto">
                    <table id="tablausuarios" class="w-full border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">
                                <th class="px-6 py-4 text-left">Usuario</th>
                                <th class="px-6 py-4 text-left">Rol / Estado</th>
                                <th class="px-6 py-4 text-center">Acceso</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-0">
                            @foreach($usuarios as $user)
                                <tr class="bg-white border border-slate-50 shadow-sm rounded-2xl hover:bg-slate-50/50 transition-all">
                                    <td class="px-6 py-5 rounded-l-3xl">
                                        <div class="flex items-center">
                                            {{-- Avatar con color dinámico si es el Admin Principal --}}
                                            <div class="h-12 w-12 rounded-2xl {{ $user->id === 1 ? 'bg-slate-900 text-white' : (strtolower($user->status ?? '') === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600') }} flex items-center justify-center font-black">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-black text-slate-800">
                                                    {{ $user->name }}
                                                    @if($user->id === 1) <span class="text-[9px] bg-slate-200 px-1 rounded text-slate-500 ml-1">SISTEMA</span> @endif
                                                </div>
                                                <div class="text-[10px] text-slate-400 font-mono">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ strtolower($user->status ?? '') === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                            {{ strtolower($user->status ?? '') === 'pending' ? 'PENDIENTE' : strtoupper($user->role) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        {{-- PROTECCIÓN: El Operador no puede cambiar roles y nadie puede revocar al ID 1 --}}
                                        @if(auth()->user()->role === 'admin' && $user->id !== 1)
                                            <form action="{{ route('admin.admin.usuarios.toggle', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-bold text-slate-600 hover:text-indigo-600 transition-colors uppercase underline underline-offset-4">
                                                    {{ $user->role === 'admin' ? 'Revocar Admin' : 'Hacer Admin' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-300 font-bold uppercase">No permitido</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-right rounded-r-3xl">
                                        <div class="flex justify-end items-center gap-2">
                                            {{-- Bloque de aprobación (Solo para usuarios no aprobados y que NO sean ID 1) --}}
                                            @if(!$user->is_approved && $user->id !== 1)
                                                <form action="{{ route('admin.admin.usuarios.approve', $user->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="px-3 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all font-bold text-xs">Aprobar</button>
                                                </form>

                                                {{-- Solo el Admin puede rechazar --}}
                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.admin.usuarios.decline', $user->id) }}" method="POST" onsubmit="return confirm('¿Rechazar usuario?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all font-bold text-xs">X</button>
                                                    </form>
                                                @endif
                                            @endif

                                            <a href="{{ route('admin.usuarios.show', $user->id) }}" class="px-3 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl transition-all font-bold text-xs">Ver</a>

                                            {{-- BOTONES CRÍTICOS: Se ocultan si el objetivo es el ID 1 o si el usuario es Operador --}}
                                            @if($user->id !== 1)
                                                <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="px-3 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-600 hover:text-white rounded-xl transition-all font-bold text-xs">Edit</a>

                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-slate-900 text-white hover:bg-red-600 rounded-xl transition-all font-bold text-xs">Del</button>
                                                    </form>
                                                @endif
                                            @else
                                                <i class="fas fa-shield-alt text-slate-400 ml-2" title="Registro de sistema protegido"></i>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Script para inicializar DataTables --}}


</x-app-layout>


<script>
        $(document).ready(function() {
            $('#tablausuarios').DataTable({
                "language": { "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json" },
                "pageLength": 10,
                "responsive": true
            });
        });
    </script>
