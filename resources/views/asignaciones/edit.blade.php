@extends('layouts.app')
@section('title', 'Editar Horario')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Horario del Grupo: <span class="text-blue-600">{{ $grupo->nombre }}</span></h2>

    <form action="{{ route('asignaciones.update', $asignacione) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Día</label>
            <input type="text" name="dia" value="{{ old('dia', $asignacione->dia) }}" required maxlength="10"
                   class="w-full border rounded px-3 py-2 @error('dia') border-red-500 @enderror">
            @error('dia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Hora Inicio</label>
                <input type="time" name="hora_inicio" value="{{ old('hora_inicio', $asignacione->hora_inicio) }}" required
                       class="w-full border rounded px-3 py-2 @error('hora_inicio') border-red-500 @enderror">
                @error('hora_inicio')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Hora Fin</label>
                <input type="time" name="hora_fin" value="{{ old('hora_fin', $asignacione->hora_fin) }}" required
                       class="w-full border rounded px-3 py-2 @error('hora_fin') border-red-500 @enderror">
                @error('hora_fin')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Aula</label>
            <select name="id_aula" required class="w-full border rounded px-3 py-2">
                <option value="">Seleccione un aula</option>
                @foreach ($aulas as $aula)
                    <option value="{{ $aula->id_aula }}" {{ (old('id_aula') ?? $asignacione->id_aula) == $aula->id_aula ? 'selected' : '' }}>
                        {{ $aula->tipo }} (Capacidad: {{ $aula->capacidad }})
                    </option>
                @endforeach
            </select>
            @error('id_aula')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('grupos.show', $grupo) }}" class="px-4 py-2 border rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar Horario</button>
        </div>
    </form>
</div>
@endsection