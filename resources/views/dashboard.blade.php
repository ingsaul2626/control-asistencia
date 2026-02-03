
<x-app-layout>
    <div class="flex flex-col items-center justify-center py-10">
    <div class="bg-white p-2 rounded-xl shadow-xl border border-gray-100 text-center w-full max-w-md">
        <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider text-xs mb-1">Hora Local</h3>
        <div class="flex items-baseline justify-center">
            <span id="reloj" class="text-2xl font-bold text-gray-800 font-mono mt-2">
                12:00:00
            </span>
            <span id="ampm" class="ml-2 text-2xl font-bold text-blue-600 uppercase">
                AM
            </span>
        </div>

        <div id="fecha-reloj" class="mt-4 text-gray-500 font-medium capitalize">
            Cargando fecha...
        </div>
    </div>
</div>

<div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-gray-400">
                    <div class="text-sm font-medium text-gray-500 uppercase">Total Plantilla</div>
                    <div id="count-total" class="text-3xl font-bold text-gray-800">{{ $totalEmpleados }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-green-600 uppercase">Asistentes Hoy</div>
                    <div id="count-presentes" class="text-3xl font-bold text-gray-800">{{ $conteoPresentes }}</div>
                    <div class="text-xs text-gray-400 mt-2">{{ $porcentajeAsistencias }}% de asistencia total</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-red-600 uppercase">Sin Asistir</div>
                   <div id="count-ausentes" class="text-3xl font-bold text-gray-800">{{ $conteoAusentes }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h3 class="font-bold text-gray-700 mb-4">Resumen Visual</h3>
                    <div class="flex justify-center">
                        <div class="relative w-48 h-48">
                            <svg class="w-full h-full" viewBox="0 0 36 36">
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-gray-100" stroke-width="3"></circle>
                                <circle cx="18" cy="18" r="16" fill="none" class="stroke-current text-blue-500" stroke-width="3"
                                    stroke-dasharray="{{ $porcentajeAsistencias }} 100" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-2xl font-bold text-blue-600">{{ $porcentajeAsistencias }}%</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-center text-sm text-gray-500 mt-4 italic">Porcentaje de cumplimiento de la jornada hoy</p>
                </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="font-bold text-gray-700 mb-4 uppercase text-xs tracking-widest">Distribución de Plantilla</h3>
    <canvas id="chartStatusGlobal"></canvas>
</div>
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b bg-gray-50">
                        <h3 class="font-bold text-gray-700">Trabajadores sin Asistir</h3>
                    </div>
                    <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                        @forelse($empleadosAusentes as $empleado)
                            <div class="p-4 flex justify-between items-center hover:bg-red-50 transition">
                                <div>
                                    <p class="font-bold text-gray-800">{{ $empleado->nombre }} {{ $empleado->apellido }}</p>
                                    <p class="text-xs text-gray-500 uppercase tracking-widest">{{ $empleado->cargo ?? 'Empleado' }}</p>
                                </div>
                                <span class="px-3 py-1 bg-red-100 text-red-600 text-xs font-bold rounded-full">AUSENTE</span>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-400">
                                <p>🎉 ¡Todos los trabajadores han asistido hoy!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const porcentaje = {{ $porcentajeAsistencias }};
        const circulo = document.querySelector('circle.text-blue-500');

        if (circulo) {

            circulo.style.transition = 'stroke-dasharray 1.5s ease-in-out';
            circulo.setAttribute('stroke-dasharray', `${porcentaje} 100`);
        }

        const animateNumber = (elementId, finalValue) => {
            const element = document.getElementById(elementId);
            if (!element) return;

            let startValue = 0;
            const duration = 1000; // 1 segundo
            const stepTime = 20;
            const increment = finalValue / (duration / stepTime);

            const timer = setInterval(() => {
                startValue += increment;
                if (startValue >= finalValue) {
                    element.textContent = finalValue;
                    clearInterval(timer);
                } else {
                    element.textContent = Math.floor(startValue);
                }
            }, stepTime);
        };


        animateNumber('count-total', {{ $totalEmpleados }});
        animateNumber('count-presentes', {{ $conteoPresentes }});
        animateNumber('count-ausentes', {{ $conteoAusentes }});
    });
</script>

<script>
    function actualizarReloj() {
        const ahora = new Date();

        let horas = ahora.getHours();
        let minutos = ahora.getMinutes().toString().padStart(2, '0');
        let segundos = ahora.getSeconds().toString().padStart(2, '0');

        // Determinar AM o PM
        const ampm = horas >= 12 ? 'PM' : 'AM';

        // Convertir a formato 12 horas
        horas = horas % 12;
        horas = horas ? horas : 12; // Si es 0, poner 12
        horas = horas.toString().padStart(2, '0');

        // Inyectar en el HTML
        document.getElementById('reloj').textContent = `${horas}:${minutos}:${segundos}`;
        document.getElementById('ampm').textContent = ampm;

        // Formatear Fecha (Ej: miércoles, 28 de enero)
        const opcionesFecha = { weekday: 'long', day: 'numeric', month: 'long' };
        document.getElementById('fecha-reloj').textContent = ahora.toLocaleDateString('es-ES', opcionesFecha);
    }

    // Actualizar cada segundo
    setInterval(actualizarReloj, 1000);
    actualizarReloj();

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // GRAFICA 1: BARRAS (Nueva)
        const ctxBar = document.getElementById('chartStatusGlobal').getContext('2d');
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Asistieron', 'Ausentes', 'Pendientes'],
                datasets: [{
                    label: 'Cantidad',
                    data: [{{ $conteoPresentes }}, {{ $conteoAusentes }}, {{ $conteoPendientes }}],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        // GRAFICA 2: CIRCULAR (Tu resumen visual existente)
        // ... (Tu código actual del círculo SVG se alimenta de $porcentajeAsistencias)
    });
</script>
</x-app-layout>
