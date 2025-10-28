@extends('layouts.app')
@section('title', 'Detalle de Aula')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Aula #{{ $aula->id_aula }}</h2>
        <div class="space-x-2">
            <a href="{{ route('aulas.edit', $aula->id_aula) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('aulas.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>

    <!-- Información del Aula -->
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información General</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Capacidad</p>
                <p class="font-semibold">{{ $aula->capacidad }} personas</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Tipo</p>
                <p class="font-semibold">{{ $aula->tipo }}</p>
            </div>
        </div>
    </div>

    <!-- Asignaciones de Horario asociadas -->
    @if($aula->asignacionesHorario && $aula->asignacionesHorario->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Horarios Asignados</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Grupo</th>
                            <th class="border px-4 py-2 text-left">Materia</th>
                            <th class="border px-4 py-2 text-left">Día</th>
                            <th class="border px-4 py-2 text-left">Hora Inicio</th>
                            <th class="border px-4 py-2 text-left">Hora Fin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aula->asignacionesHorario as $asignacion)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">
                                    {{ $asignacion->grupo->nombre ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $asignacion->grupo->materia->nombre ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">{{ $asignacion->dia_semana }}</td>
                                <td class="border px-4 py-2">{{ $asignacion->hora_inicio }}</td>
                                <td class="border px-4 py-2">{{ $asignacion->hora_fin }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">Esta aula no tiene horarios asignados actualmente.</p>
        </div>
    @endif

    <!-- Botón de Eliminar -->
    <div class="mt-6 pt-6 border-t">
        <form action="{{ route('aulas.destroy', $aula->id_aula) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar esta aula? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Aula
            </button>
        </form>
    </div>
</div>
@endsection