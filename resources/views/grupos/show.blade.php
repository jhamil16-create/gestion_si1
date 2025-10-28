@extends('layouts.app')
@section('title', 'Detalles del Grupo')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Grupo: {{ $grupo->nombre }}</h2>
        <a href="{{ route('grupos.index') }}" class="text-blue-600 hover:underline">&larr; Volver</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div><strong>Nombre:</strong> {{ $grupo->nombre }}</div>
        <div><strong>Capacidad:</strong> {{ $grupo->capacidad }}</div>
        <div><strong>Materia:</strong> {{ $grupo->materia->nombre ?? $grupo->sigla }}</div>
        <div><strong>Docente:</strong> {{ $grupo->docente->usuario->nombre ?? 'N/A' }}</div>
        <div><strong>Gestión:</strong> {{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</div>
    </div>

    <!-- Horarios asignados -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-2">
            <h3 class="font-semibold">Horarios Asignados</h3>
            <a href="{{ route('asignaciones.create', $grupo) }}" class="text-sm text-blue-600 hover:underline">
                <i class="fas fa-plus"></i> Agregar Horario
            </a>
        </div>
        @if ($grupo->asignacionesHorario->count())
            <ul class="divide-y">
                @foreach ($grupo->asignacionesHorario as $horario)
                    <li class="py-2 flex justify-between">
                        <span>{{ $horario->dia }} {{ $horario->hora_inicio }}–{{ $horario->hora_fin }}
                            (Aula: {{ $horario->aula->tipo ?? 'ID ' . $horario->id_aula }})
                        </span>
                        <div>
                            <a href="{{ route('asignaciones.edit', $horario) }}" class="text-yellow-600 hover:underline mr-2">Editar</a>
                            <form action="{{ route('asignaciones.destroy', $horario) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar horario?')">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No hay horarios asignados.</p>
        @endif
    </div>
</div>
@endsection