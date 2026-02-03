<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.5cm 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 9px; line-height: 1.2; color: #000; }

        /* Encabezado con Logo */
        .header-container { width: 100%; margin-bottom: 10px; }
        .logo2-img { width: 100%; height: auto; max-height: 100px; }

        .title-box {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin: 10px 0;
            text-decoration: underline;
        }

        /* Información de la Unidad */
        .unit-info { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .unit-info td { border: 1px solid #000; padding: 3px; font-weight: bold; font-size: 8px; }
        .bg-gray { background-color: #ebebeb; }

        /* Tabla Principal Estilo Formato Real */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            background-color: #ebebeb;
            border: 1px solid #000;
            padding: 4px;
            font-size: 8px;
            text-align: center;
        }
        .data-table td { border: 1px solid #000; padding: 4px; height: 22px; text-align: center; }
        .text-left { text-align: left !important; padding-left: 5px !important; }

        /* Firmas */
        .footer-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .footer-table td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .signature-line { margin-top: 35px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ public_path('img/logo2.jpg') }}" class="logo-img">
    </div>

    <div class="title-box">FORMATO DE CONTROL DE ASISTENCIA</div>

    <table class="unit-info">
        <tr>
            <td class="bg-gray" style="width: 70%;">UNIDAD DE ADSCRIPCION: <span style="font-weight: normal;">OFICINA DE GESTIÓN ADMINISTRATIVA</span></td>
            <td class="bg-gray" style="width: 30%;">FECHA: <span style="font-weight: normal;">{{ \Carbon\Carbon::parse($fechaHoy)->format('d/m/Y') }}</span></td>
        </tr>
        <tr>
            <td colspan="2" class="bg-gray">DPTO: <span style="font-weight: normal;">UNIDAD DE INGENIERÍA E INFRAESTRUCTURA</span></td>
        </tr>
        <tr>
            <td class="bg-gray">RESPONSABLE DE LA UNIDAD: <span style="font-weight: normal;">ING. GERARDO LÓPEZ</span></td>
            <td class="bg-gray">DIA: <span style="font-weight: normal; text-transform: uppercase;">{{ \Carbon\Carbon::parse($fechaHoy)->locale('es')->dayName }}</span></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">N</th>
                <th style="width: 25%;">NOMBRE Y APELLIDOS</th>
                <th style="width: 12%;">CEDULA</th>
                <th style="width: 15%;">TIPO DE TRABAJADOR</th>
                <th style="width: 8%;">HORA ENTRADA</th>
                <th style="width: 8%;">HORA SALIDA</th>
                <th style="width: 12%;">FIRMA</th>
                <th style="width: 17%;">OBSERVACION</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asistencias as $index => $asistencia)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $asistencia->user->name }}</td>
                <td>{{ $asistencia->user->cedula ?? 'S/C' }}</td>
                <td>{{ $asistencia->user->tipo_trabajador ?? 'ADM. / FIJO' }}</td>
                <td>{{ $asistencia->created_at->format('h:i A') }}</td>
                <td></td> <td></td> <td>{{ Str::limit($asistencia->reporte_trabajador, 25) }}</td>
            </tr>
            @empty
            @endforelse

            {{-- Completar hasta 15 filas para que el formato se vea igual al impreso --}}
            @for ($i = count($asistencias); $i < 15; $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="width: 50%; height: 60px;">
                RECIBIDO POR:
                <div class="signature-line"></div>
                <div style="text-align: center; font-size: 7px;">FIRMA Y SELLO</div>
            </td>
            <td style="width: 50%;">
                FECHA DE RECEPCIÓN:
                <div class="signature-line" style="margin-top: 35px; width: 50%;"></div>
            </td>
        </tr>
    </table>

</body>
</html>
