<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset('css/estilos-fijos.css') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo1.png') }}">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>

        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

         @if ($errors->any())
    <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div class="bg-red-600 border-l-4 border-red-900 text-white p-4 shadow-lg rounded-r-lg flex items-center" role="alert">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="font-bold text-lg">Error en el Registro</p>
                <p class="text-sm opacity-90">Por favor, revisa los campos marcados en rojo abajo.</p>
            </div>
        </div>
    </div>
@endif

@if (session('success'))
    <div id="alert-success" class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div style="background-color: #059669 !important; border-left: 8px solid #064e3b !important; color: white !important; padding: 20px !important; border-radius: 8px !important; display: flex !important; justify-content: space-between !important; align-items: center !important; shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
            <div style="display: flex; align-items: center;">
                <svg style="width: 30px; height: 30px; margin-right: 15px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <p style="font-weight: 900 !important; font-size: 1.1rem !important; margin: 0 !important; color: white !important;">
                        ¡OPERACIÓN EXITOSA!
                    </p>
                    <p style="font-size: 0.95rem !important; margin: 0 !important; color: #ecfdf5 !important; opacity: 1 !important;">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 24px; font-weight: bold; cursor: pointer; padding: 0 10px;">
                &times;
            </button>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const el = document.getElementById('alert-success');
            if(el) el.style.display = 'none';
        }, 5000);
    </script>
@endif


@if (session('delete'))
    <div id="alert-delete" class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8">
        <div style="background-color: #ef4444 !important; border-left: 8px solid #991b1b !important; color: white !important; padding: 15px !important; border-radius: 8px !important; display: flex !important; justify-content: space-between !important; align-items: center !important;">
            <div style="display: flex; align-items: center;">
                <span style="font-size: 1.5rem; margin-right: 12px;">🗑️</span>
                <div>
                    <p style="font-weight: 900 !important; margin: 0 !important;">¡REGISTRO ELIMINADO!</p>
                    <p style="font-size: 0.9rem !important; margin: 0 !important; opacity: 0.9;">{{ session('delete') }}</p>
                </div>
            </div>
            <button onclick="this.parentElement.parentElement.style.display='none'" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
    </div>
    <script>
        setTimeout(() => { document.getElementById('alert-delete').style.display = 'none'; }, 5000);
    </script>
@endif
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>

<script>
$(document).ready(function() {
    $('#tabla-trabajadores').DataTable({
        "language": {
            "search": "Buscar trabajador:",
            "zeroRecords": "No se encontraron resultados",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ empleados",
            "paginate": {
                "next": "Sig",
                "previous": "Ant"
            }
        },
        "pageLength": 10,
        "dom": '<"flex justify-between items-center mb-4"f>rt<"flex justify-between items-center mt-4"ip>',
    });

    // Estilo extra al buscador con Tailwind vía JS
    $('.dataTables_filter input').addClass('ml-2 px-4 py-2 border border-gray-200 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all');
});
</script>
