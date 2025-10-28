@extends('layouts.app')
@section('title', 'Detalles de Materia')
@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold">Materia: {{ $materia->nombre }}</h2>
        <a href="{{ route('materias.index') }}" class="text-blue-600 hover:underline">&larr; Volver</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <strong>Sigla:</strong> {{ $materia->sigla }}
        </div>
        <div>
            <strong>Nombre:</strong> {{ $materia->nombre }}
        </div>
    </div>

    @if ($materia->grupos->count())
        <h3 class="font-semibold mb-2">Grupos Asignados</h3>
        <ul class="list-disc pl-5">
            @foreach ($materia->grupos as $grupo)
                <li>{{ $grupo->nombre }} (Docente: {{ $grupo->docente->usuario->nombre ?? 'N/A' }})</li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No hay grupos asignados.</p>
    @endif
</div>
@endsection