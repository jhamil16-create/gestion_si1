@extends('layouts.app')
@section('title', 'Crear Grupo')

@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Crear Nuevo Grupo</h2>
    
    {{-- Bloque de errores (del estilo de tu form de Docente) --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grupos.store') }}" method="POST">
        @csrf
        
        {{-- CAMPO NUEVO: ID Grupo (Manual) --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ID Grupo (Manual)</label>
            <input type="text" 
                   name="id_grupo" 
                   value="{{ old('id_grupo') }}" 
                   required 
                   maxlength="20" 
                   class="w-full border rounded px-3 py-2 @error('id_grupo') border-red-500 @enderror"
                   placeholder="Ej: G1-CALC1, G2-PROGRA">
            <p class="text-gray-500 text-sm mt-1">ID único que tú defines.</p>
            @error('id_grupo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO: Nombre --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre del Grupo</label>
            <input type="text" 
                   name="nombre" 
                   value="{{ old('nombre') }}" 
                   required 
                   maxlength="30" 
                   class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                   placeholder="Ej: Grupo 1, Grupo A">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO ELIMINADO: Capacidad --}}

        {{-- CAMPO ELIMINADO: Docente --}}

        {{-- CAMPO: Materia --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Materia</label>
            <select name="sigla" 
                    required 
                    class="w-full border rounded px-3 py-2 @error('sigla') border-red-500 @enderror">
                <option value="">Seleccione una materia</option>
                @foreach ($materias as $materia)
                    <option value="{{ $materia->sigla }}" {{ old('sigla') == $materia->sigla ? 'selected' : '' }}>
                        {{ $materia->nombre }} ({{ $materia->sigla }})
                    </option>
                @endforeach
            </select>
            @error('sigla')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO: Gestión Académica (usamos mb-6 como en tu form de Docente) --}}
        <div class="mb-6">
            <label class="block mb-1 font-semibold">Gestión Académica</label>
            <select name="id_gestion" 
                    required 
                    class="w-full border rounded px-3 py-2 @error('id_gestion') border-red-500 @enderror">
                <option value="">Seleccione una gestión</option>
                @foreach ($gestiones as $gestion)
                    <option value="{{ $gestion->id_gestion }}" {{ old('id_gestion') == $gestion->id_gestion ? 'selected' : '' }}>
                        {{ $gestion->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_gestion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones (del estilo de tu form de Docente) --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection