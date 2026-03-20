<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 leading-tight uppercase tracking-tighter italic">
                Gestión de {{ __('usuarios') }}
            </h2>
            {{-- Cambio: bg-uptag-orange y shadow-orange-200 --}}
            <a href="{{ route('admin.usuarios.create') }}"
               class="px-6 py-3 bg-uptag-orange text-white font-black text-xs uppercase rounded-2xl hover:bg-slate-900 transition-all shadow-lg shadow-orange-200/50">
                + Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 sm:rounded-[2.5rem] border border-white p-4 md:p-8">

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
                                <tr class="bg-white border border-slate-50 shadow-sm rounded-2xl hover:bg-slate-50/50 transition-all group">
                                    <td class="px-6 py-5 rounded-l-3xl">
                                        <div class="flex items-center">
                                            {{-- Cambio: Avatar dinámico con tonos naranja si no es sistema --}}
                                            <div class="h-12 w-12 rounded-2xl {{ $user->id === 1 ? 'bg-slate-900 text-white' : (strtolower($user->status ?? '') === 'pending' ? 'bg-amber-50 text-amber-600' : 'bg-orange-50 text-uptag-orange') }} flex items-center justify-center font-black">
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
                                        {{-- Cambio: Badge de rol con naranja para aprobados --}}
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ strtolower($user->status ?? '') === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-orange-100 text-uptag-orange' }}">
                                            {{ strtolower($user->status ?? '') === 'pending' ? 'PENDIENTE' : strtoupper($user->role) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if(auth()->user()->role === 'admin' && $user->id !== 1)
                                            <form action="{{ route('admin.admin.usuarios.toggle', $user->id) }}" method="POST">
                                                @csrf
                                                {{-- Cambio: hover:text-uptag-orange --}}
                                                <button type="submit" class="text-[10px] font-bold text-slate-600 hover:text-uptag-orange transition-colors uppercase underline underline-offset-4 decoration-orange-200">
                                                    {{ $user->role === 'admin' ? 'Revocar Admin' : 'Hacer Admin' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-300 font-bold uppercase">No permitido</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-right rounded-r-3xl">
                                        <div class="flex justify-end items-center gap-2">
                                            @if(!$user->is_approved && $user->id !== 1)
                                                <form action="{{ route('admin.admin.usuarios.approve', $user->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="px-3 py-2 bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Aprobar</button>
                                                </form>

                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.admin.usuarios.decline', $user->id) }}" method="POST" onsubmit="return confirm('¿Rechazar usuario?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition-all font-bold text-xs">X</button>
                                                    </form>
                                                @endif
                                            @endif

                                            <a href="{{ route('admin.usuarios.show', $user->id) }}" class="px-3 py-2 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Ver</a>

                                            @if($user->id !== 1)
                                                {{-- Cambio: bg-orange-50 text-uptag-orange hover:bg-uptag-orange --}}
                                                <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="px-3 py-2 bg-orange-50 text-uptag-orange hover:bg-uptag-orange hover:text-white rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Edit</a>

                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-slate-900 text-white hover:bg-red-600 rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Del</button>
                                                    </form>
                                                @endif
                                            @else
                                                <div class="bg-slate-100 p-2 rounded-xl" title="Protección de Sistema">
                                                    <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.925-3.467 9.47-8 10.655C5.467 16.47 2 11.925 2 7a11.931 11.931 0 00.166-2.001zM10 5a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                                                </div>
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
</x-app-layout>

<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#tablausuarios')) {
            $('#tablausuarios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                    "search": "",
                    "searchPlaceholder": "Buscar usuario..."
                },
                "pageLength": 10,
                "responsive": true,
                "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6"f>rt<"flex justify-between items-center mt-6"ip>',
            });

            // Estilizar buscador para que coincida con el tema naranja
            $('.dataTables_filter input').addClass('bg-white border-slate-200 rounded-2xl text-sm px-6 py-3 focus:ring-4 focus:ring-orange-100 outline-none border transition-all w-full md:w-80 shadow-sm');
        }
    });
</script>

<style>
    /* Estilos personalizados para la paginación de DataTables */
    .dataTables_paginate .paginate_button { @apply !rounded-xl !border-none !font-bold !text-xs !tracking-widest !px-4 !py-2; }
    .dataTables_paginate .paginate_button.current { @apply !bg-uptag-orange !text-white !shadow-lg !shadow-orange-200; }
</style>
