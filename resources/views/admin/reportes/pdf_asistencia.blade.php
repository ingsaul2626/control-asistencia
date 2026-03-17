<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.5cm 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 9px; line-height: 1.2; color: #000; }
        .header-container { width: 100%; margin-bottom: 10px; }
        .logo-img { width: 100%; height: auto; max-height: 80px; }
        .title-box { text-align: center; font-size: 13px; font-weight: bold; margin: 10px 0; text-decoration: underline; }
        .unit-info { width: 100%; border-collapse: collapse; margin-bottom: 5px; }
        .unit-info td { border: 1px solid #000; padding: 3px; font-weight: bold; font-size: 8px; }
        .bg-gray { background-color: #ebebeb; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background-color: #ebebeb; border: 1px solid #000; padding: 4px; font-size: 8px; text-align: center; }
        .data-table td { border: 1px solid #000; padding: 3px; height: 22px; text-align: center; }
        .text-left { text-align: left !important; padding-left: 5px !important; }
        .footer-table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        .footer-table td { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .signature-line { margin-top: 25px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; }
    </style>
</head>
<body>

    <div class="header-container">
        <img src="{{ base_path('public/img/logo.jpg') }}" class="logo-img">
    </div>

    <div class="title-box">FORMATO DE CONTROL DE ASISTENCIA</div>

    <table class="unit-info">
        <tr>
            <td class="bg-gray" style="width: 70%;">UNIDAD: <span style="font-weight: normal;">OFICINA DE GESTIÓN ADMINISTRATIVA</span></td>
            <td class="bg-gray" style="width: 30%;">FECHA: <span style="font-weight: normal;">{{ \Carbon\Carbon::parse($fechaHoy)->format('d/m/Y') }}</span></td>
        </tr>
        <tr>
            <td colspan="2" class="bg-gray">DPTO: <span style="font-weight: normal;">UNIDAD DE INGENIERÍA E INFRAESTRUCTURA</span></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>N</th><th>NOMBRE Y APELLIDOS</th><th>CEDULA</th><th>TIPO</th><th>ENTRADA</th><th>SALIDA</th><th>FIRMA</th><th>OBSERVACIÓN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $index => $asistencia)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $asistencia->user->name ?? 'N/A' }}</td>
                <td>{{ $asistencia->user->cedula ?? 'S/C' }}</td>
                <td>{{ $asistencia->user->tipo_trabajador ?? 'N/A' }}</td>
                <td>{{ $asistencia->created_at ? $asistencia->created_at->format('h:i A') : '--' }}</td>
                <td>{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('h:i A') : '--' }}</td>
                <td>_________</td>
                <td>{{ Str::limit($asistencia->reporte_trabajador ?? 'N/A', 20) }}</td>
            </tr>
            @endforeach

            @for ($i = count($asistencias); $i < 15; $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>RECIBIDO POR:<div class="signature-line"></div><div style="text-align: center; font-size: 7px;">FIRMA Y SELLO</div></td>
            <td>FECHA DE RECEPCIÓN:<div class="signature-line" style="width: 50%;"></div></td>
        </tr>
    </table>

</body>
</html>
