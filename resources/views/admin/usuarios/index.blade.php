<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-2xl text-slate-800 dark:text-slate-100 leading-tight uppercase tracking-tighter italic transition-colors">
                Gestión de {{ __('usuarios') }}
            </h2>
            <a href="{{ route('admin.usuarios.create') }}"
               class="px-6 py-3 bg-uptag-orange text-white font-black text-xs uppercase rounded-2xl hover:bg-slate-900 dark:hover:bg-white dark:hover:text-slate-900 transition-all shadow-lg shadow-orange-200/50 dark:shadow-orange-900/20">
                + Nuevo usuario
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-slate-50/50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm shadow-2xl shadow-slate-200/60 dark:shadow-none sm:rounded-[2.5rem] border border-white dark:border-slate-800 p-4 md:p-8 transition-all">

                <div class="overflow-x-auto">
                    <table id="tablausuarios" class="w-full border-separate border-spacing-y-3">
                        <thead>
                            <tr class="text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                                <th class="px-6 py-4 text-left">Usuario</th>
                                <th class="px-6 py-4 text-left">Rol / Estado</th>
                                <th class="px-6 py-4 text-center">Acceso</th>
                                <th class="px-6 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y-0">
                            @foreach($usuarios as $user)
                                <tr class="bg-white dark:bg-slate-800/50 border border-slate-50 dark:border-slate-700/50 shadow-sm rounded-2xl hover:bg-slate-50/50 dark:hover:bg-slate-800 transition-all group">
                                    <td class="px-6 py-5 rounded-l-3xl">
                                        <div class="flex items-center">
                                            <div class="h-12 w-12 rounded-2xl {{ $user->id === 1 ? 'bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900' : (strtolower($user->status ?? '') === 'pending' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400' : 'bg-orange-50 dark:bg-orange-900/20 text-uptag-orange') }} flex items-center justify-center font-black transition-colors">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-black text-slate-800 dark:text-slate-200">
                                                    {{ $user->name }}
                                                    @if($user->id === 1) <span class="text-[9px] bg-slate-200 dark:bg-slate-700 px-1 rounded text-slate-500 dark:text-slate-400 ml-1">SISTEMA</span> @endif
                                                </div>
                                                <div class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-5">
                                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ strtolower($user->status ?? '') === 'pending' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400' : 'bg-orange-100 dark:bg-orange-900/30 text-uptag-orange' }}">
                                            {{ strtolower($user->status ?? '') === 'pending' ? 'PENDIENTE' : strtoupper($user->role) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-5 text-center">
                                        @if(auth()->user()->role === 'admin' && $user->id !== 1)
                                            <form action="{{ route('admin.admin.usuarios.toggle', $user->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:text-uptag-orange dark:hover:text-uptag-orange transition-colors uppercase underline underline-offset-4 decoration-orange-200 dark:decoration-orange-900">
                                                    {{ $user->role === 'admin' ? 'Revocar Admin' : 'Hacer Admin' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[10px] text-slate-300 dark:text-slate-600 font-bold uppercase">No permitido</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-5 text-right rounded-r-3xl">
                                        <div class="flex justify-end items-center gap-2">
                                            @if(!$user->is_approved && $user->id !== 1)
                                                <form action="{{ route('admin.admin.usuarios.approve', $user->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="px-3 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-600 dark:hover:bg-emerald-600 hover:text-white rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Aprobar</button>
                                                </form>

                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.admin.usuarios.decline', $user->id) }}" method="POST" onsubmit="return confirm('¿Rechazar usuario?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 hover:bg-rose-600 dark:hover:bg-rose-600 hover:text-white rounded-xl transition-all font-bold text-xs">X</button>
                                                    </form>
                                                @endif
                                            @endif

                                            <a href="{{ route('admin.usuarios.show', $user->id) }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Ver</a>

                                            @if($user->id !== 1)
                                                <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="px-3 py-2 bg-orange-50 dark:bg-orange-900/20 text-uptag-orange hover:bg-uptag-orange hover:text-white rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Edit</a>

                                                @if(auth()->user()->role === 'admin')
                                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro?')">
                                                        @csrf @method('DELETE')
                                                        <button class="px-3 py-2 bg-slate-900 dark:bg-slate-950 text-white hover:bg-red-600 rounded-xl transition-all font-bold text-xs uppercase tracking-tighter">Del</button>
                                                    </form>
                                                @endif
                                            @else
                                                <div class="bg-slate-100 dark:bg-slate-700 p-2 rounded-xl" title="Protección de Sistema">
                                                    <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 4.925-3.467 9.47-8 10.655C5.467 16.47 2 11.925 2 7a11.931 11.931 0 00.166-2.001zM10 5a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
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
            var table = $('#tablausuarios').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                    "search": "",
                    "searchPlaceholder": "Buscar usuario..."
                },
                "pageLength": 10,
                "responsive": true,
                "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6"f>rt<"flex justify-between items-center mt-6"ip>',
            });

            // Estilizar buscador dinámicamente para soportar dark mode
            $('.dataTables_filter input').addClass('bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-2xl text-sm px-6 py-3 focus:ring-4 focus:ring-orange-100 dark:focus:ring-orange-900/20 outline-none border transition-all w-full md:w-80 shadow-sm text-slate-600 dark:text-slate-300');
        }
    });
</script>

<style>
    /* Estilos personalizados para la paginación de DataTables */
    .dataTables_paginate .paginate_button { @apply !rounded-xl !border-none !font-bold !text-xs !tracking-widest !px-4 !py-2 !text-slate-400; }
    .dark .dataTables_paginate .paginate_button { @apply !text-slate-600; }

    .dataTables_paginate .paginate_button.current {
        @apply !bg-uptag-orange !text-white !shadow-lg !shadow-orange-200;
    }
    .dark .dataTables_paginate .paginate_button.current {
        @apply !shadow-orange-900/20;
    }

    .dataTables_info {
        @apply !text-[10px] !font-black !uppercase !tracking-widest !text-slate-400;
    }

    /* Eliminar borde por defecto de datatables */
    table.dataTable.no-footer { border-bottom: none !important; }
</style>
