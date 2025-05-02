<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Gráficos Biblioteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            text-align: center;
            margin: 20px;
        }
        h3 {
            color: #001C7D;
            margin-bottom: 10px;
            height: 24px;
        }
        img {
            width: 100%;
            max-width: 300px;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body>
    <h1>Reporte de Gráficos Biblioteca</h1>
        {{-- Estadísticas --}}
        <div class="stats">
            <p><strong>Estudiantes:</strong> {{ $totales['estudiantes'] }}</p>
            <p><strong>Docentes:</strong> {{ $totales['docentes'] }}</p>
            <p><strong>Servicios:</strong> {{ $totales['servicios'] }}</p>
        </div>
        {{-- Gráfico de Sexo --}}
        <img src="{{ $imagenes['graficoSexo'] }}">
        <h3>Gráfico de Sexo</h3>

        {{-- Gráfico de Tipo de Servicio --}}
        <img src="{{ $imagenes['graficoTipoServicio'] }}">
        <h3>Gráfico de Tipo de Servicio</h3>

        {{-- Gráfico de Área de Conocimiento --}}
        <img src="{{ $imagenes['graficoAreaConocimiento'] }}" style="width: 100%;">
        <h3>Gráfico de Área de Conocimiento</h3>

        {{-- Gráfico de Sala de Atención --}}   
        <img src="{{ $imagenes['graficoSalaAtencion'] }}" style="width: 100%;">
        <h3>Gráfico de Sala de Atención</h3>

        {{-- Gráfico de Carrera --}}
        <img src="{{ $imagenes['graficoCarrera'] }}" style="width: 100%;">
        <h3>Gráfico de Carrera</h3>

        {{-- Gráfico de Turno --}}
        <img src="{{ $imagenes['graficoTurno'] }}" style="width: 100%;">
        <h3>Gráfico de Turno</h3>

        {{-- Gráfico de Sede --}}
        <img src="{{ $imagenes['graficoSede'] }}" style="width: 100%;">
        <h3>Gráfico de Sede</h3>
</body>
</html>