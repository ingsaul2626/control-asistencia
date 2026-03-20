<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.5cm 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 9px; line-height: 1.2; color: #1e293b; }

        /* HEADER */
        .header-container { width: 100%; margin-bottom: 10px; border-bottom: 3px solid #f97316; padding-bottom: 5px; text-align: center; }

        /* Ajuste para que el logo ocupe el ancho y se vea correctamente */
        .RRSS-img {
            width: 100%;
            max-height: 100px;
            object-fit: contain;
        }

        /* TITULO */
        .title-box {
            text-align: center;
            font-size: 14px;
            font-weight: 900;
            margin: 15px 0;
            color: #f97316;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* INFO BOX */
        .unit-info { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .unit-info td {
            border: 1px solid #fed7aa;
            padding: 5px;
            font-weight: bold;
            font-size: 8px;
        }
        .bg-orange-light { background-color: #fff7ed; color: #c2410c; }
        .label { color: #f97316; text-transform: uppercase; font-size: 7px; margin-right: 5px; }

        /* DATA TABLE */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th {
            background-color: #f97316;
            color: #ffffff;
            border: 1px solid #ea580c;
            padding: 6px;
            font-size: 8px;
            text-align: center;
            text-transform: uppercase;
        }
        .data-table td {
            border: 1px solid #fed7aa;
            padding: 4px;
            height: 20px;
            text-align: center;
            color: #334155;
        }
        .text-left { text-align: left !important; padding-left: 8px !important; font-weight: bold; }
        .row-even { background-color: #ffffff; }
        .row-odd { background-color: #fffaf5; }

        /* FOOTER */
        .footer-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .footer-table td {
            border: 1px solid #fed7aa;
            padding: 10px;
            vertical-align: top;
            background-color: #fffaf5;
        }
        .signature-line {
            margin-top: 35px;
            border-top: 1.5px solid #f97316;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .footer-label { text-align: center; font-size: 7px; font-weight: bold; color: #f97316; margin-top: 4px; }
    </style>
</head>
<body>

    <div class="header-container">
        {{-- Usamos public_path para asegurar la ruta local en el servidor --}}
        <img src="{{ public_path('img/RRSS.jpg') }}" class="RRSS-img">
    </div>

    <div class="title-box">Formato de Control de Asistencia</div>

    <table class="unit-info">
        <tr>
            <td class="bg-orange-light" style="width: 70%;">
                <span class="label">UNIDAD:</span>
                <span style="font-weight: normal; color: #000;">OFICINA DE GESTIÓN ADMINISTRATIVA</span>
            </td>
            <td class="bg-orange-light" style="width: 30%;">
                <span class="label">FECHA:</span>
                <span style="font-weight: normal; color: #000;">{{ \Carbon\Carbon::parse($fechaHoy)->format('d/m/Y') }}</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="bg-orange-light">
                <span class="label">DPTO:</span>
                <span style="font-weight: normal; color: #000;">UNIDAD DE INGENIERÍA E INFRAESTRUCTURA</span>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">N°</th>
                <th style="width: 25%;">Nombre y Apellidos</th>
                <th style="width: 10%;">Cédula</th>
                <th style="width: 12%;">Tipo</th>
                <th style="width: 10%;">Entrada</th>
                <th style="width: 10%;">Salida</th>
                <th style="width: 15%;">Firma</th>
                <th style="width: 15%;">Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asistencias as $index => $asistencia)
            <tr class="{{ $index % 2 == 0 ? 'row-even' : 'row-odd' }}">
                <td>{{ $index + 1 }}</td>
                <td class="text-left">{{ $asistencia->user->name ?? 'N/A' }}</td>
                <td>{{ $asistencia->user->cedula ?? 'S/C' }}</td>
                <td style="font-size: 7px;">{{ $asistencia->user->tipo_trabajador ?? 'N/A' }}</td>
                <td style="color: #f97316; font-weight: bold;">{{ $asistencia->created_at ? $asistencia->created_at->format('h:i A') : '--' }}</td>
                <td style="color: #f97316; font-weight: bold;">{{ $asistencia->hora_salida ? \Carbon\Carbon::parse($asistencia->hora_salida)->format('h:i A') : '--' }}</td>
                <td style="color: #cbd5e1;">________________</td>
                <td style="font-size: 7px;">{{ Str::limit($asistencia->reporte_trabajador ?? 'N/A', 25) }}</td>
            </tr>
            @endforeach

            {{-- Filas vacías para completar el formato hasta 14 filas --}}
            @for ($i = count($asistencias); $i < 14; $i++)
            <tr class="{{ $i % 2 == 0 ? 'row-even' : 'row-odd' }}">
                <td>{{ $i + 1 }}</td>
                <td></td><td></td><td></td><td></td><td></td><td></td><td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td style="width: 50%;">
                <span class="label" style="display: block; margin-bottom: 10px;">RECIBIDO POR:</span>
                <div class="signature-line"></div>
                <div class="footer-label">FIRMA Y SELLO DE LA UNIDAD</div>
            </td>
            <td style="width: 50%;">
                <span class="label" style="display: block; margin-bottom: 10px;">FECHA DE RECEPCIÓN:</span>
                <div class="signature-line" style="width: 60%;"></div>
                <div class="footer-label">DÍA / MES / AÑO</div>
            </td>
        </tr>
    </table>

</body>
</html>
