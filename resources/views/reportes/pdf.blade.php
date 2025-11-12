<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $titulo }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
            margin: 20px;
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .resumen-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 20px 0;
        }
        .resumen-card {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
        }
        .resumen-card.presente { background-color: #d4edda; }
        .resumen-card.ausente { background-color: #f8d7da; }
        .resumen-card.tardanza { background-color: #fff3cd; }
        .resumen-card.total { background-color: #d1ecf1; }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .estado-presente { color: #28a745; font-weight: bold; }
        .estado-ausente { color: #dc3545; font-weight: bold; }
        .estado-tardanza { color: #ffc107; font-weight: bold; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $titulo }}</h1>
        <p>Sistema de Gestión Académica</p>
    </div>

    @if($data['tipo'] == 'asistencia')
        <!-- REPORTE DE ASISTENCIA -->
        <div class="info-section">
            <h2>Información del Reporte</h2>
            <p><strong>Docente:</strong> {{ $data['docente'] }}</p>
            <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($data['fecha_inicio'])->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($data['fecha_fin'])->format('d/m/Y') }}</p>
            <p><strong>Generado el:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="resumen-grid">
            <div class="resumen-card total">
                <h3>Total Días</h3>
                <p class="numero">{{ $data['resumen']['total_dias'] }}</p>
            </div>
            <div class="resumen-card presente">
                <h3>Presentes</h3>
                <p class="numero">{{ $data['resumen']['presentes'] }}</p>
            </div>
            <div class="resumen-card ausente">
                <h3>Ausentes</h3>
                <p class="numero">{{ $data['resumen']['ausentes'] }}</p>
            </div>
            <div class="resumen-card tardanza">
                <h3>Tardanzas</h3>
                <p class="numero">{{ $data['resumen']['tardanzas'] }}</p>
            </div>
        </div>

        @if($data['detalle'] && $data['detalle']->count() > 0)
            <h2>Detalle de Asistencias</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Grupo</th>
                        <th>Aula</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['detalle'] as $asistencia)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $asistencia->grupo_nombre ?? 'N/A' }}</td>
                        <td>{{ $asistencia->aula_tipo ?? 'N/A' }}</td>
                        <td class="estado-{{ $asistencia->estado }}">
                            {{ ucfirst($asistencia->estado) }}
                        </td>
                        <td>{{ $asistencia->observaciones ?? 'Sin observaciones' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; margin: 40px 0;">
                <p style="color: #666; font-style: italic;">No hay registros de asistencia para el período seleccionado</p>
            </div>
        @endif

    @elseif($data['tipo'] == 'carga_horaria')
        <!-- REPORTE DE CARGA HORARIA -->
        <div class="info-section">
            <h2>Reporte de Carga Horaria</h2>
            <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($data['fecha_inicio'])->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($data['fecha_fin'])->format('d/m/Y') }}</p>
        </div>

        @if(isset($data['detalle']) && count($data['detalle']) > 0)
            @foreach($data['detalle'] as $carga)
            <div style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
                <h3>{{ $carga['docente'] }}</h3>
                <p><strong>Total de horas:</strong> {{ $carga['horas_totales'] }} horas</p>
                
                @if(!empty($carga['materias']))
                <h4>Distribución por materias:</h4>
                <ul>
                    @foreach($carga['materias'] as $materia => $horas)
                    <li>{{ $materia }}: {{ $horas }} horas</li>
                    @endforeach
                </ul>
                @endif
            </div>
            @endforeach
        @else
            <p>No hay datos de carga horaria para mostrar.</p>
        @endif

    @elseif($data['tipo'] == 'rendimiento')
        <!-- REPORTE DE RENDIMIENTO -->
        <div class="info-section">
            <h2>Reporte de Rendimiento</h2>
            <p><strong>Docente:</strong> {{ $data['docente'] }}</p>
            <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($data['fecha_inicio'])->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($data['fecha_fin'])->format('d/m/Y') }}</p>
        </div>

        <div class="resumen-grid">
            <div class="resumen-card">
                <h3>Asistencia</h3>
                <p class="numero">{{ number_format($data['porcentaje_asistencia'], 1) }}%</p>
            </div>
            <div class="resumen-card">
                <h3>Horas Programadas</h3>
                <p class="numero">{{ $data['horas_programadas'] }}</p>
            </div>
            <div class="resumen-card">
                <h3>Horas Impartidas</h3>
                <p class="numero">{{ number_format($data['horas_impartidas'], 1) }}</p>
            </div>
            <div class="resumen-card">
                <h3>Eficiencia</h3>
                <p class="numero">{{ number_format(($data['horas_impartidas'] / max(1, $data['horas_programadas'])) * 100, 1) }}%</p>
            </div>
        </div>

        <h3>Detalle de Asistencia</h3>
        <table class="table">
            <tr><td>Presentes:</td><td>{{ $data['asistencia']['presentes'] }}</td></tr>
            <tr><td>Ausentes:</td><td>{{ $data['asistencia']['ausentes'] }}</td></tr>
            <tr><td>Tardanzas:</td><td>{{ $data['asistencia']['tardanzas'] }}</td></tr>
            <tr><td>Total días:</td><td>{{ $data['asistencia']['total_dias'] }}</td></tr>
        </table>

    @endif

    <div class="footer">
        <p>Documento generado automáticamente por el Sistema de Gestión Académica</p>
    </div>
</body>
</html>