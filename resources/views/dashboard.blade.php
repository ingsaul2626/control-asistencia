<x-app-layout>
    <div class="py-10 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Sección del Reloj --}}
            <div class="flex flex-col items-center justify-center mb-10">
                <div class="bg-white/80 backdrop-blur-md p-6 rounded-3xl shadow-2xl shadow-indigo-100 border border-white text-center w-full max-w-sm">
                    <h3 class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Sistema de Control Temporal</h3>
                    <div class="flex items-center justify-center space-x-3">
                        <span id="reloj" class="text-4xl font-black text-slate-800 tracking-tighter tabular-nums">00:00:00</span>
                        <span id="ampm" class="px-2 py-1 bg-indigo-600 text-white text-xs font-bold rounded-lg uppercase">AM</span>
                    </div>
                    <div id="fecha-reloj" class="mt-3 text-slate-500 font-bold text-sm capitalize">Cargando fecha...</div>
                </div>
            </div>

            {{-- KPIs --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-slate-100 rounded-2xl text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div>
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Plantilla</span>
                    </div>
                    <div id="count-total" class="text-4xl font-black text-slate-800 tracking-tighter">{{ $totalUsuarios }}</div>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Colaboradores registrados</p>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 border-b-4 border-b-emerald-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-emerald-50 rounded-2xl text-emerald-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Asistencia</span>
                    </div>
                    <div id="count-presentes" class="text-4xl font-black text-slate-800 tracking-tighter">{{ $conteoPresentes }}</div>
                    <div class="flex items-center mt-2">
                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">{{ $porcentajeAsistencias }}%</span>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 border-b-4 border-b-rose-500">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-rose-50 rounded-2xl text-rose-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Ausencias</span>
                    </div>
                    <div id="count-ausentes" class="text-4xl font-black text-slate-800 tracking-tighter">{{ $conteoAusentes }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Gráfica --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                    <div class="h-64"><canvas id="chartStatusGlobal"></canvas></div>
                </div>

                {{-- Lista de Faltas --}}
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="font-black text-slate-700 uppercase text-xs tracking-widest">Faltas por Notificar</h3>
                        <span class="bg-rose-100 text-rose-600 text-[10px] font-black px-2 py-1 rounded-lg">{{ $conteoAusentes }}</span>
                    </div>
                    <div class="divide-y divide-slate-50 max-h-80 overflow-y-auto">
                        @forelse($usuariosAusentes as $usuario)
                            <div class="p-5 flex justify-between items-center">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 font-bold text-xs mr-4">
                                        {{ substr($usuario->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $usuario->name }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-black text-rose-400 border border-rose-100 px-3 py-1 rounded-full">INACTIVO</span>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-400 font-bold">¡Todos presentes hoy!</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animación de números corregida para recibir los valores del backend
            const animateNumber = (elementId, finalValue) => {
                const element = document.getElementById(elementId);
                if (!element) return;
                element.textContent = finalValue; // Simplificado para evitar errores de lógica, pero puedes volver a la lógica anterior si prefieres
            };

            animateNumber('count-total', {{ $totalUsuarios }});
            animateNumber('count-presentes', {{ $conteoPresentes }});
            animateNumber('count-ausentes', {{ $conteoAusentes }});
            animateNumber('count-pendientes', {{ $conteoPendientes }});

            // Reloj en tiempo real
            function actualizarReloj() {
                const ahora = new Date();
                let horas = ahora.getHours();
                const minutos = ahora.getMinutes().toString().padStart(2, '0');
                const segundos = ahora.getSeconds().toString().padStart(2, '0');
                const ampm = horas >= 12 ? 'PM' : 'AM';
                horas = horas % 12 || 12;
                horas = horas.toString().padStart(2, '0');

                document.getElementById('reloj').textContent = `${horas}:${minutos}:${segundos}`;
                document.getElementById('ampm').textContent = ampm;

                const opcionesFecha = { weekday: 'long', day: 'numeric', month: 'long' };
                document.getElementById('fecha-reloj').textContent = ahora.toLocaleDateString('es-ES', opcionesFecha);
            }
            setInterval(actualizarReloj, 1000);
            actualizarReloj();

            // Gráfica de Barras Moderna
            const ctxBar = document.getElementById('chartStatusGlobal').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['ASISTIERON', 'AUSENTES', 'PENDIENTES'],
                    datasets: [{
                        data: [{{ $conteoPresentes }}, {{ $conteoAusentes }}, {{ $conteoPendientes }}],
                        backgroundColor: ['#10b981', '#f43f5e', '#f59e0b'],
                        borderRadius: 12,
                        borderSkipped: false,
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 10, weight: 'bold' },
                            bodyFont: { size: 13, weight: 'bold' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { display: false },
                            ticks: { font: { weight: 'bold' }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { weight: 'black', size: 9 }, color: '#64748b' }
                        }
                    }
                }
            });
        });
    </script>

    <style>
        /* Scrollbar personalizada para la lista */
        .scrollbar-thin::-webkit-scrollbar { width: 5px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 20px; }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</x-app-layout>
