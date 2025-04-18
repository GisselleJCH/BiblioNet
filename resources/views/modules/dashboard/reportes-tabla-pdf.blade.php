<!DOCTYPE html>
<html>
<head>
    <title>Reportes de Biblioteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Reporte de Biblioteca</h1>
    <table>
        <thead>
            <tr>
                <th>Carnet</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Cédula</th>
                <th>Turno</th>
                <th>Sexo</th>
                <th>Área del Conocimiento</th>
                <th>Carrera</th>
                <th>Sede</th>
                <th>Tipo de Miembro</th>
                <th>Ingreso</th>
                <th>Número de Locker</th>
                <th>Sala de Atención</th>
                <th>Tipo de Servicio</th>
                <th>Signatura Topográfica</th>
                <th>Código Computadora</th>
                <th>Cantidad</th>
                <th>Atendido por</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportes as $reporte)
                <tr>
                    <td>{{ $reporte->carnet }}</td>
                    <td>{{ $reporte->nombres }}</td>
                    <td>{{ $reporte->apellidos }}</td>
                    <td>{{ $reporte->cedula }}</td>
                    <td>{{ $reporte->turno }}</td>
                    <td>{{ $reporte->sexo }}</td>
                    <td>{{ $reporte->area_conocimiento }}</td>
                    <td>{{ $reporte->carrera }}</td>
                    <td>{{ $reporte->sede }}</td>
                    <td>{{ $reporte->tipo_miembro }}</td>
                    <td>{{ $reporte->ingreso }}</td>
                    <td>{{ $reporte->numero_locker }}</td>
                    <td>{{ $reporte->sala_atencion }}</td>
                    <td>{{ $reporte->tipo_servicio }}</td>
                    <td>{{ $reporte->signatura_topografica }}</td>
                    <td>{{ $reporte->codigo_computadora }}</td>
                    <td>{{ $reporte->cantidad }}</td>
                    <td>{{ $reporte->atendido_por }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>