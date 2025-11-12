@extends('layouts.app')

@section('title', $titulo)

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $titulo }}</h1>
        
        @if($data['tipo'] == 'asistencia')
            <!-- Vista para reporte de asistencia -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Docente: {{ $data['docente'] }}</h2>
                <p class="text-gray-600">Período: {{ $data['fecha_inicio'] }} al {{ $data['fecha_fin'] }}</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-600">Total Días</p>
                    <p class="text-2xl font-bold text-blue-800">{{ $data['resumen']['total_dias'] }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm text-green-600">Presentes</p>
                    <p class="text-2xl font-bold text-green-800">{{ $data['resumen']['presentes'] }}</p>
                </div>
                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-sm text-red-600">Ausentes</p>
                    <p class="text-2xl font-bold text-red-800">{{ $data['resumen']['ausentes'] }}</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <p class="text-sm text-yellow-600">Tardanzas</p>
                    <p class="text-2xl font-bold text-yellow-800">{{ $data['resumen']['tardanzas'] }}</p>
                </div>
            </div>

            <!-- Tabla de detalle -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-4 border">Fecha</th>
                            <th class="py-2 px-4 border">Estado</th>
                            <th class="py-2 px-4 border">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['detalle'] as $asistencia)
                        <tr>
                            <td class="py-2 px-4 border">{{ $asistencia->fecha }}</td>
                            <td class="py-2 px-4 border">
                                <span class="px-2 py-1 rounded-full text-xs 
                                    {{ $asistencia->estado == 'presente' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $asistencia->estado == 'ausente' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $asistencia->estado == 'tardanza' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($asistencia->estado) }}
                                </span>
                            </td>
                            <td class="py-2 px-4 border">{{ $asistencia->observaciones ?? 'Ninguna' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @elseif($data['tipo'] == 'carga_horaria')
            <!-- Vista para reporte de carga horaria -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Período: {{ $data['fecha_inicio'] }} al {{ $data['fecha_fin'] }}</h2>
            </div>
            
            @foreach($data['detalle'] as $carga)
            <div class="mb-6 border rounded-lg p-4">
                <h3 class="font-semibold text-lg">{{ $carga['docente'] }}</h3>
                <p class="text-gray-600">Total horas: {{ $carga['horas_totales'] }}</p>
                
                @if(!empty($carga['materias']))
                <div class="mt-2">
                    <h4 class="font-medium">Distribución por materias:</h4>
                    <ul class="list-disc list-inside ml-4">
                        @foreach($carga['materias'] as $materia => $horas)
                        <li>{{ $materia }}: {{ $horas }} horas</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            @endforeach

        @elseif($data['tipo'] == 'rendimiento')
            <!-- Vista para reporte de rendimiento -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold">Docente: {{ $data['docente'] }}</h2>
                <p class="text-gray-600">Período: {{ $data['fecha_inicio'] }} al {{ $data['fecha_fin'] }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Estadísticas de asistencia -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold text-lg mb-3">Asistencia</h3>
                    <div class="space-y-2">
                        <p>Porcentaje: <span class="font-bold">{{ number_format($data['porcentaje_asistencia'], 2) }}%</span></p>
                        <p>Presentes: {{ $data['asistencia']['presentes'] }}</p>
                        <p>Ausentes: {{ $data['asistencia']['ausentes'] }}</p>
                        <p>Tardanzas: {{ $data['asistencia']['tardanzas'] }}</p>
                    </div>
                </div>
                
                <!-- Estadísticas de carga horaria -->
                <div class="bg-white border rounded-lg p-4">
                    <h3 class="font-semibold text-lg mb-3">Carga Horaria</h3>
                    <div class="space-y-2">
                        <p>Horas programadas: <span class="font-bold">{{ $data['horas_programadas'] }}</span></p>
                        <p>Horas impartidas: <span class="font-bold">{{ number_format($data['horas_impartidas'], 2) }}</span></p>
                        <p>Eficiencia: <span class="font-bold">{{ number_format(($data['horas_impartidas'] / max(1, $data['horas_programadas'])) * 100, 2) }}%</span></p>
                    </div>
                </div>
            </div>

            <!-- Materias -->
            @if(!empty($data['materias']))
            <div class="mt-6">
                <h3 class="font-semibold text-lg mb-3">Distribución por Materias</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($data['materias'] as $sigla => $materia)
                    <div class="border rounded-lg p-3">
                        <h4 class="font-medium">{{ $materia['nombre'] }}</h4>
                        <p class="text-sm text-gray-600">Horas: {{ $materia['horas_programadas'] }}</p>
                        <p class="text-sm text-gray-600">Grupos: {{ $materia['grupos'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection