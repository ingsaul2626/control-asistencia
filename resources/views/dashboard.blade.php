<x-app-layout>
    <div class="py-12 bg-[#f8fafc] min-h-screen font-sans antialiased text-slate-900">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- HEADER: RELOJ Y ESTADO DEL SISTEMA --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-12 gap-6">
                <div>
                    <h1 class="text-3xl font-black tracking-tight text-slate-800">Panel<span class="text-indigo-600">Control</span></h1>
                    <p class="text-slate-500 text-sm font-medium uppercase tracking-tighter">Control de asistencia y proyectos • Ciclo 2026</p>
                </div>

                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-fuchsia-500 rounded-3xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <div class="relative bg-white/70 backdrop-blur-xl px-8 py-4 rounded-3xl border border-white shadow-xl flex items-center gap-6">
                        <div class="text-right">
                            <div class="flex items-baseline gap-1">
                                <span id="reloj" class="text-4xl font-black tracking-tighter tabular-nums text-slate-800">00:00:00</span>
                                <span id="ampm" class="text-xs font-black text-indigo-600 uppercase">AM</span>
                            </div>
                            <div id="fecha-reloj" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cargando...</div>
                        </div>
                        <div class="h-10 w-[1px] bg-slate-200"></div>
                        <div class="p-3 bg-indigo-50 rounded-2xl text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KPIs PRINCIPALES --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @php
                    $kpis = [
                        ['label' => 'Plantilla Total', 'val' => $totalUsuarios, 'color' => 'slate', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                        ['label' => 'Confirmados', 'val' => $conteoPresentes, 'color' => 'emerald', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Por Confirmar', 'val' => $conteoAusentes ?? $conteoPendientes, 'color' => 'rose', 'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Ratio Asistencia', 'val' => $porcentajeAsistencias . '%', 'color' => 'indigo', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6']
                    ];
                @endphp

                @foreach($kpis as $kpi)
                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:shadow-md transition-all group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-{{ $kpi['color'] }}-50 rounded-2xl text-{{ $kpi['color'] }}-600 group-hover:rotate-12 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $kpi['icon'] }}"></path></svg>
                        </div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $kpi['label'] }}</span>
                    </div>
                    <div class="text-4xl font-black text-slate-800 tracking-tighter">{{ $kpi['val'] }}</div>
                </div>
                @endforeach
            </div>

            {{-- SECCIÓN DE PROYECTOS Y RENDIMIENTO --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">

                {{-- GRÁFICO COMPARATIVO ASISTENCIA --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-400 uppercase text-[10px] tracking-[0.2em] mb-8 text-center">Status de Presencia</h3>
                    <div class="h-64 relative">
                        <canvas id="chartAsistencia"></canvas>
                    </div>
                </div>

                {{-- GRÁFICO PRODUCTIVIDAD --}}
                <div class="lg:col-span-2 bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="font-black text-slate-400 uppercase text-[10px] tracking-[0.2em] mb-8">Carga de Trabajo por Usuario</h3>
                    <div class="h-64">
                        <canvas id="chartActividadUsuarios"></canvas>
                    </div>
                </div>
            </div>

            {{-- TABLAS DETALLADAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- TABLA: RANKING DE PROYECTOS --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex items-center justify-between">
                        <h3 class="font-black text-slate-700 text-sm uppercase">Ranking de Participación</h3>
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-white">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-tighter">Usuario</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase text-center">Proyectos</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase">Eficiencia</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($topUsuarios as $usuario)
                                <tr class="hover:bg-indigo-50/20 transition-colors group">
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-600 text-white flex items-center justify-center text-[10px] font-black shadow-lg shadow-indigo-100">
                                                {{ substr($usuario->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-bold text-slate-700">{{ $usuario->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-4 text-center">
                                        <span class="px-2 py-1 bg-slate-100 rounded-lg text-xs font-black text-slate-600">{{ $usuario->proyectos_count }}</span>
                                    </td>
                                    <td class="px-8 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                                <div class="bg-indigo-500 h-full" style="width: {{ min(($usuario->proyectos_count / 10) * 100, 100) }}%"></div>
                                            </div>
                                            <span class="text-[10px] font-black text-slate-400">{{ min(($usuario->proyectos_count / 10) * 100, 100) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- TABLA: PENDIENTES DE ASISTENCIA --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
                    <div class="px-8 py-6 border-b border-rose-50 bg-rose-50/30 flex items-center justify-between">
                        <h3 class="font-black text-rose-600 text-sm uppercase">Pendientes de Registro (Hoy)</h3>
                        <div class="flex items-center gap-2">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
                        </div>
                    </div>
                    <div class="max-h-[400px] overflow-y-auto divide-y divide-slate-50">
                        @forelse($usuariosAusentes as $usuario)
                        <div class="px-8 py-5 flex items-center group hover:bg-rose-50/10 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-2xl bg-white border-2 border-rose-100 flex items-center justify-center text-rose-400 shadow-sm group-hover:scale-105 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-800">{{ $usuario->name }}</p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[9px] font-bold text-rose-500 uppercase tracking-widest">Ausente</span>
                                        <span class="h-1 w-1 bg-slate-300 rounded-full"></span>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Sin actividad reportada</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="py-24 text-center">
                            <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-sm font-black text-slate-400 italic">¡Perfecto! Todos han registrado su asistencia.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- RELOJ ---
        function actualizarReloj() {
            const ahora = new Date();
            let horas = ahora.getHours();
            const minutos = String(ahora.getMinutes()).padStart(2, '0');
            const segundos = String(ahora.getSeconds()).padStart(2, '0');
            const ampm = horas >= 12 ? 'PM' : 'AM';
            horas = horas % 12 || 12;

            document.getElementById('reloj').textContent = `${String(horas).padStart(2, '0')}:${minutos}:${segundos}`;
            document.getElementById('ampm').textContent = ampm;

            const opciones = { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric' };
            document.getElementById('fecha-reloj').textContent = ahora.toLocaleDateString('es-ES', opciones);
        }
        setInterval(actualizarReloj, 1000);
        actualizarReloj();

        // --- CHART: ASISTENCIA (DONUT REFINADO) ---
        const ctxAsistencia = document.getElementById('chartAsistencia').getContext('2d');
        new Chart(ctxAsistencia, {
            type: 'doughnut',
            data: {
                labels: ['Presentes', 'Pendientes'],
                datasets: [{
                    data: [{{ $conteoPresentes }}, {{ $conteoAusentes ?? $conteoPendientes }}],
                    backgroundColor: ['#10b981', '#f43f5e'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 8, font: { size: 10, weight: '900' } } }
                }
            }
        });

        // --- CHART: ACTIVIDAD (BARRA GRADIENTE) ---
        const ctxBarUser = document.getElementById('chartActividadUsuarios').getContext('2d');
        const gradient = ctxBarUser.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, '#6366f1');
        gradient.addColorStop(1, '#c7d2fe');

        new Chart(ctxBarUser, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topUsuarios->pluck('name')) !!},
                datasets: [{
                    label: 'Proyectos Activos',
                    data: {!! json_encode($topUsuarios->pluck('proyectos_count')) !!},
                    backgroundColor: gradient,
                    borderRadius: 20,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 10, weight: '700' } }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 10, weight: '700' } } }
                },
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
