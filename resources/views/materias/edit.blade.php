@extends('layouts.app')
@section('title', 'Editar Materia')
@section('content')
<div class="max-w-2xl mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Materia</h2>

    <form action="{{ route('materias.update', $materia) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Sigla</label>
            <input type="text" name="sigla" value="{{ old('sigla', $materia->sigla) }}" required maxlength="10"
                   class="w-full border rounded px-3 py-2 @error('sigla') border-red-500 @enderror">
            @error('sigla')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $materia->nombre) }}" required maxlength="100"
                   class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror">
            @error('nombre')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('materias.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Actualizar</button>
        </div>
    </form>
</div>
@endsection