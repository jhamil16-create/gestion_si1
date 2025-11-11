@extends('layouts.app')

@section('title', $esAdmin ? "Horario de {$docente->usuario->nombre}" : 'Mi Horario')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- Encabezado --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">
                    @if($esAdmin)
                        Horario de {{ $docente->usuario->nombre }}
                    @else
                        Mi Horario
                    @endif
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    {{ $total_clases ?? 0 }} clases asignadas
                </p>
            </div>
            
            @if($esAdmin)
                <a href="{{ route('horarios.docentes') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors text-sm font-medium w-full sm:w-auto text-center">
                    Volver a Lista de Docentes
                </a>
            @endif
        </div>
    </div>

    {{-- Horario Semanal --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-calendar-alt text-blue-600 mr-2"></i>
                Horario Semanal
            </h3>
        </div>

        <div class="p-6">
            @if($total_clases > 0)
                {{-- Vista Desktop/Tablet --}}
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                                <th class="px-4 py-3 border-b font-semibold w-32">Hora</th>
                                @foreach($dias as $dia)
                                    <th class="px-4 py-3 border-b font-semibold text-center">
                                        {{ $dia }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @php
                                $horas = [
                                    '07:00', '07:45', '08:30', '09:15', '10:00', '10:45', '11:30', 
                                    '12:15', '13:00', '13:45', '14:30', '15:15', '16:00', '16:45',
                                    '17:30', '18:15', '19:00', '19:45', '20:30', '21:15', '22:00','22:45'
                                ];
                                
                                // Generar colores únicos para cada grupo
                                $coloresGrupos = [];
                                $coloresDisponibles = [
                                    'blue', 'green', 'purple', 'orange', 'red', 'teal', 
                                    'pink', 'indigo', 'yellow', 'cyan', 'lime', 'amber'
                                ];
                                
                                // Mapear cada grupo a un color
                                foreach($horario as $dia => $clases) {
                                    foreach($clases as $clase) {
                                        $claveGrupo = $clase['sigla'] . '-' . $clase['grupo'];
                                        if (!isset($coloresGrupos[$claveGrupo])) {
                                            $colorIndex = count($coloresGrupos) % count($coloresDisponibles);
                                            $coloresGrupos[$claveGrupo] = $coloresDisponibles[$colorIndex];
                                        }
                                    }
                                }
                            @endphp

                            @foreach($horas as $index => $hora)
                                @if($index < count($horas) - 1)
                                    @php
                                        $horaFin = $horas[$index + 1];
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 border-b text-gray-500 font-mono text-xs">
                                            {{ $hora }}<br>-<br>{{ $horaFin }}
                                        </td>

                                        @foreach($dias as $dia)
                                            <td class="px-2 py-2 border-b min-w-40">
                                                @php
                                                    $claseEnEsteBloque = null;
                                                    
                                                    foreach($horario[$dia] ?? [] as $clase) {
                                                        $horaInicioClase = \Carbon\Carbon::parse($clase['hora_inicio'])->format('H:i');
                                                        $horaFinClase = \Carbon\Carbon::parse($clase['hora_fin'])->format('H:i');
                                                        
                                                        // Verificar si esta clase ocupa este bloque específico
                                                        $horaInicioCarbon = \Carbon\Carbon::parse($clase['hora_inicio']);
                                                        $horaFinCarbon = \Carbon\Carbon::parse($clase['hora_fin']);
                                                        $horaActualCarbon = \Carbon\Carbon::parse($hora);
                                                        $horaFinActualCarbon = \Carbon\Carbon::parse($horaFin);
                                                        
                                                        // La clase ocupa este bloque si se superpone
                                                        if ($horaInicioCarbon < $horaFinActualCarbon && $horaFinCarbon > $horaActualCarbon) {
                                                            $claseEnEsteBloque = $clase;
                                                            break;
                                                        }
                                                    }
                                                @endphp

                                                @if($claseEnEsteBloque)
                                                    @php
                                                        $claveGrupo = $claseEnEsteBloque['sigla'] . '-' . $claseEnEsteBloque['grupo'];
                                                        $colorGrupo = $coloresGrupos[$claveGrupo] ?? 'blue';
                                                        
                                                        // Clases CSS para cada color
                                                        $clasesColor = [
                                                            'blue' => 'bg-blue-100 border-blue-300 text-blue-800',
                                                            'green' => 'bg-green-100 border-green-300 text-green-800',
                                                            'purple' => 'bg-purple-100 border-purple-300 text-purple-800',
                                                            'orange' => 'bg-orange-100 border-orange-300 text-orange-800',
                                                            'red' => 'bg-red-100 border-red-300 text-red-800',
                                                            'teal' => 'bg-teal-100 border-teal-300 text-teal-800',
                                                            'pink' => 'bg-pink-100 border-pink-300 text-pink-800',
                                                            'indigo' => 'bg-indigo-100 border-indigo-300 text-indigo-800',
                                                            'yellow' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                                                            'cyan' => 'bg-cyan-100 border-cyan-300 text-cyan-800',
                                                            'lime' => 'bg-lime-100 border-lime-300 text-lime-800',
                                                            'amber' => 'bg-amber-100 border-amber-300 text-amber-800',
                                                        ];
                                                    @endphp
                                                    <div class="rounded p-2 border mb-1 hover:opacity-90 transition-opacity {{ $clasesColor[$colorGrupo] }}">
                                                        <p class="font-semibold text-xs">{{ $claseEnEsteBloque['sigla'] }}</p>
                                                        <p class="text-xs opacity-80">{{ $claseEnEsteBloque['grupo'] }}</p>
                                                        <p class="text-xs opacity-70">Aula: {{ $claseEnEsteBloque['aula'] }}</p>
                                                        <p class="text-xs opacity-60 font-mono">
                                                            {{ \Carbon\Carbon::parse($claseEnEsteBloque['hora_inicio'])->format('H:i') }} - 
                                                            {{ \Carbon\Carbon::parse($claseEnEsteBloque['hora_fin'])->format('H:i') }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="text-center py-4">
                                                        <span class="text-gray-300 text-xs">-</span>
                                                    </div>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista Mobile --}}
                <div class="lg:hidden space-y-4">
                    @foreach($dias as $dia)
                        @if(count($horario[$dia] ?? []) > 0)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <h4 class="font-bold text-gray-800 text-lg mb-3 text-center">{{ $dia }}</h4>
                                
                                @foreach($horario[$dia] as $clase)
                                    @php
                                        // Calcular duración
                                        $horaInicio = \Carbon\Carbon::parse($clase['hora_inicio']);
                                        $horaFin = \Carbon\Carbon::parse($clase['hora_fin']);
                                        $duracionMinutos = $horaInicio->diffInMinutes($horaFin);
                                        $duracionBloques = ceil($duracionMinutos / 45);
                                        
                                        // Obtener color para este grupo
                                        $claveGrupo = $clase['sigla'] . '-' . $clase['grupo'];
                                        $colorGrupo = $coloresGrupos[$claveGrupo] ?? 'blue';
                                        
                                        $clasesColor = [
                                            'blue' => 'bg-blue-100 border-blue-300 text-blue-800',
                                            'green' => 'bg-green-100 border-green-300 text-green-800',
                                            'purple' => 'bg-purple-100 border-purple-300 text-purple-800',
                                            'orange' => 'bg-orange-100 border-orange-300 text-orange-800',
                                            'red' => 'bg-red-100 border-red-300 text-red-800',
                                            'teal' => 'bg-teal-100 border-teal-300 text-teal-800',
                                            'pink' => 'bg-pink-100 border-pink-300 text-pink-800',
                                            'indigo' => 'bg-indigo-100 border-indigo-300 text-indigo-800',
                                            'yellow' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                                            'cyan' => 'bg-cyan-100 border-cyan-300 text-cyan-800',
                                            'lime' => 'bg-lime-100 border-lime-300 text-lime-800',
                                            'amber' => 'bg-amber-100 border-amber-300 text-amber-800',
                                        ];
                                    @endphp
                                    <div class="mb-3 p-3 border rounded-lg hover:opacity-90 transition-opacity {{ $clasesColor[$colorGrupo] }}">
                                        <div class="flex justify-between items-start mb-2">
                                            <span class="font-mono text-sm bg-white bg-opacity-50 px-2 py-1 rounded">
                                                {{ $horaInicio->format('H:i') }} - {{ $horaFin->format('H:i') }}
                                            </span>
                                            <span class="text-xs bg-white bg-opacity-50 px-2 py-1 rounded">
                                                {{ $duracionBloques }} bloque{{ $duracionBloques > 1 ? 's' : '' }}
                                            </span>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="font-semibold">{{ $clase['sigla'] }}</p>
                                            <p class="text-sm opacity-80">{{ $clase['grupo'] }}</p>
                                            <p class="text-sm opacity-70">
                                                <i class="fas fa-door-open mr-1"></i>Aula: {{ $clase['aula'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Leyenda de colores --}}
                <div class="mt-6 bg-gray-50 rounded-lg p-4">
                    <h4 class="font-bold text-gray-800 text-sm mb-3">Leyenda de Grupos:</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($coloresGrupos as $grupo => $color)
                            @php
                                $clasesColor = [
                                    'blue' => 'bg-blue-100 border-blue-300 text-blue-800',
                                    'green' => 'bg-green-100 border-green-300 text-green-800',
                                    'purple' => 'bg-purple-100 border-purple-300 text-purple-800',
                                    'orange' => 'bg-orange-100 border-orange-300 text-orange-800',
                                    'red' => 'bg-red-100 border-red-300 text-red-800',
                                    'teal' => 'bg-teal-100 border-teal-300 text-teal-800',
                                    'pink' => 'bg-pink-100 border-pink-300 text-pink-800',
                                    'indigo' => 'bg-indigo-100 border-indigo-300 text-indigo-800',
                                    'yellow' => 'bg-yellow-100 border-yellow-300 text-yellow-800',
                                    'cyan' => 'bg-cyan-100 border-cyan-300 text-cyan-800',
                                    'lime' => 'bg-lime-100 border-lime-300 text-lime-800',
                                    'amber' => 'bg-amber-100 border-amber-300 text-amber-800',
                                ];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs {{ $clasesColor[$color] }}">
                                <span class="w-2 h-2 rounded-full bg-current opacity-70"></span>
                                {{ $grupo }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="px-3 py-10 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-calendar-times text-4xl mb-3 text-gray-400"></i>
                        <p class="text-lg font-medium mb-2">No hay clases asignadas</p>
                        <p class="text-sm text-gray-400">No se encontraron horarios para mostrar</p>
                        @if(isset($error))
                            <p class="text-xs text-red-500 mt-2">Error: {{ $error }}</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection