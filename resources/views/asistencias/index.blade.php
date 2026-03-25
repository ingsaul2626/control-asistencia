<x-app-layout>
    @if(session('success'))
        <div id="alert-success" class="fixed top-20 right-5 z-50 max-w-sm animate-fade-in-down">
            <div class="bg-emerald-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        </div>
        <script>setTimeout(() => document.getElementById('alert-success')?.remove(), 4000);</script>
    @endif

    <div class="py-10 bg-slate-50 dark:bg-slate-950 min-h-screen transition-colors duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- CABECERA E INFO --}}
            <div class="mb-8 p-8 bg-slate-900 rounded-[2.5rem] shadow-2xl border border-slate-800 relative overflow-hidden group">
                {{-- Brillo decorativo naranja --}}
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-uptag-orange/20 rounded-full blur-[100px] transition-all group-hover:bg-uptag-orange/30"></div>

                <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex flex-col gap-1 border-b border-slate-800 pb-4 md:border-none md:pb-0">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Operador</span>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                            <span class="text-emerald-400 font-bold text-sm tracking-tight">{{ auth()->user()->name }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-1 border-b border-slate-800 pb-4 md:border-none md:pb-0">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Sincronización</span>
                        <span class="text-white font-mono text-sm tracking-tight">{{ now()->format('d M, Y') }}</span>
                        <span class="text-[10px] font-mono text-slate-500">{{ now()->format('H:i:s') }}</span>
                    </div>

                    <div class="flex flex-col gap-1 border-b border-slate-800 pb-4 md:border-none md:pb-0">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Filtro Activo</span>
                        <span class="text-uptag-orange font-mono text-sm tracking-tight bg-uptag-orange/10 px-2 py-1 rounded-lg w-fit">{{ $fecha }}</span>
                    </div>

                    <div class="flex flex-col gap-1">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Tráfico de Hoy</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-white font-black text-2xl tracking-tighter">{{ $asistenciasHoy->count() }}</span>
                            <span class="text-slate-500 text-xs font-bold uppercase">Registros</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLA DE REGISTROS --}}
            <div class="bg-white dark:bg-slate-900 shadow-2xl shadow-slate-200/50 dark:shadow-none rounded-[2.5rem] overflow-hidden border border-slate-100 dark:border-slate-800 p-4 sm:p-8 transition-colors">
                <table id="miTablaGenerica" class="w-full border-separate border-spacing-y-3">
                    <thead>
                        <tr class="text-slate-400 dark:text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">
                            <th class="px-6 py-4 text-left">Colaborador</th>
                            <th class="px-6 py-4 text-center">Entrada</th>
                            <th class="px-6 py-4 text-center">Salida</th>
                            <th class="px-6 py-4 text-center">Notas</th>
                            <th class="px-6 py-4 text-right">Operaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($User as $usuario)
                            @php
                                $asistencia = $asistenciasHoy->get($usuario->id);
                                $res = new \stdClass();
                                if (!$asistencia) {
                                    $res->label = 'PENDIENTE';
                                    $res->clase_punto = 'bg-slate-300 dark:bg-slate-700';
                                    $res->clase_boton = 'bg-uptag-orange';
                                    $res->boton = 'ASIGNAR';
                                } else {
                                    $res->label = strtoupper($asistencia->status);
                                    $res->clase_punto = ($asistencia->status == 'aceptado') ? 'bg-emerald-500' : 'bg-amber-500';
                                    $res->clase_boton = 'bg-slate-700 dark:bg-slate-800';
                                    $res->boton = 'ACTUALIZAR';
                                }
                            @endphp
                            <tr class="bg-white dark:bg-slate-950 border border-slate-50 dark:border-slate-800 shadow-sm rounded-2xl group hover:shadow-md dark:hover:bg-slate-800/50 transition-all">
                                <td class="px-6 py-5 rounded-l-3xl">
                                    <div class="flex items-center">
                                        <div class="relative">
                                            <div class="h-10 w-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold transition-colors">{{ substr($usuario->name, 0, 1) }}</div>
                                            <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white dark:border-slate-950 {{ $res->clase_punto }} {{ $res->label === 'ACEPTADO' ? 'animate-pulse' : '' }}"></div>
                                        </div>
                                        <div class="ml-4">
                                            <span class="text-sm font-black text-slate-700 dark:text-slate-200 block tracking-tight">{{ $usuario->name }}</span>
                                            <span class="text-[9px] font-bold py-0.5 px-2 rounded-md bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 uppercase">Status: {{ $res->label }}</span>
                                        </div>
                                    </div>
                                </td>

                                <form action="{{ route('admin.asistencias.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $usuario->id }}">
                                    <td class="px-6 py-5 text-center">
                                        <input type="time" name="hora_entrada" value="{{ $asistencia && $asistencia->hora_entrada ? \Carbon\Carbon::parse($asistencia->hora_entrada)->format('H:i') : '' }}" class="text-sm font-black text-slate-600 dark:text-slate-300 bg-slate-100/50 dark:bg-slate-800/50 rounded-xl p-2 w-28 text-center focus:ring-uptag-orange/20 border-transparent dark:border-slate-700 transition-all">
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <input type="time" name="hora_salida" value="{{ $asistencia && $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('H:i') : '' }}" class="text-sm font-black text-uptag-orange bg-orange-50/50 dark:bg-uptag-orange/5 rounded-xl p-2 w-28 text-center focus:ring-uptag-orange/20 border-transparent dark:border-slate-700 transition-all">
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <input type="text" name="observaciones" value="{{ $asistencia->observaciones ?? '' }}" placeholder="Añadir..." class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-100/50 dark:bg-slate-800/50 rounded-xl w-full p-2 focus:ring-uptag-orange/20 border-transparent dark:border-slate-700 transition-all">
                                    </td>
                                    <td class="px-6 py-5 text-right rounded-r-3xl">
                                        <div class="flex justify-end items-center gap-2">
                                            <button type="submit" class="{{ $res->clase_boton }} text-white text-[10px] font-black px-5 py-2.5 rounded-xl transition-all hover:-translate-y-1 uppercase tracking-widest shadow-lg shadow-orange-500/10">
                                                {{ $res->boton }}
                                            </button>
                                            </form>
                                            @if($res->label !== 'FALTA')
                                                <form action="{{ route('admin.asistencias.marcar-falta', ['id' => $usuario->id]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-rose-50 dark:bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white p-2.5 rounded-xl transition-all border border-transparent dark:border-rose-500/20">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                    </button>
                                                </form>
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
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        if (!$.fn.DataTable.isDataTable('#miTablaGenerica')) {
            $('#miTablaGenerica').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
                    "search": "",
                    "searchPlaceholder": "Buscar colaborador..."
                },
                "responsive": true,
                "pageLength": 10,
                "ordering": false,
                "dom": '<"flex flex-col md:flex-row justify-between items-center mb-6"f>rt<"flex justify-between items-center mt-6"ip>',
            });

            // Estilizar buscador modo oscuro adaptativo
            $('.dataTables_filter input').addClass('bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 rounded-2xl text-sm px-6 py-3 focus:ring-4 focus:ring-uptag-orange/20 outline-none border transition-all w-full md:w-80 shadow-sm dark:text-white');
        }
    });
</script>

<style>
    .animate-fade-in-down { animation: fadeInDown 0.5s ease-out; }
    @keyframes fadeInDown {
        0% { opacity: 0; transform: translateY(-20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .dataTables_paginate .paginate_button { @apply !rounded-xl !border-none !font-bold !text-xs !tracking-widest !px-4 !py-2 dark:!text-slate-400; }
    .dataTables_paginate .paginate_button.current { @apply !bg-uptag-orange !text-white !shadow-lg !shadow-orange-500/20; }

    /* Ajuste para texto de información de la tabla en modo oscuro */
    .dataTables_info { @apply dark:text-slate-500 text-xs font-bold uppercase tracking-widest; }
</style>
