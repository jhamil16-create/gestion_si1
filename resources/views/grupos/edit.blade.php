@extends('layouts.app')
@section('title', 'Editar Grupo')
@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Grupo</h2>

    <form action="{{ route('grupos.update', $grupo) }}" method="POST">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $grupo->nombre) }}" required maxlength="30"
                       class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror">
                @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Capacidad</label>
                <input type="number" name="capacidad" value="{{ old('capacidad', $grupo->capacidad) }}" required min="1"
                       class="w-full border rounded px-3 py-2 @error('capacidad') border-red-500 @enderror">
                @error('capacidad')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Docente</label>
                <select name="id_docente" required class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione</option>
                    @foreach ($docentes as $docente)
                        <option value="{{ $docente->id_docente }}" {{ (old('id_docente') ?? $grupo->id_docente) == $docente->id_docente ? 'selected' : '' }}>
                            {{ $docente->usuario->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_docente')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Materia</label>
                <select name="sigla" required class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione</option>
                    @foreach ($materias as $materia)
                        <option value="{{ $materia->sigla }}" {{ (old('sigla') ?? $grupo->sigla) == $materia->sigla ? 'selected' : '' }}>
                            {{ $materia->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('sigla')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Gestión Académica</label>
                <select name="id_gestion" required class="w-full border rounded px-3 py-2">
                    <option value="">Seleccione</option>
                    @foreach ($gestiones as $gestion)
                        <option value="{{ $gestion->id_gestion }}" {{ (old('id_gestion') ?? $grupo->id_gestion) == $gestion->id_gestion ? 'selected' : '' }}>
                            {{ $gestion->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_gestion')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection