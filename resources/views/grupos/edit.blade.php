@extends('layouts.app')
@section('title', 'Editar Grupo')

@section('content')
{{-- Usamos el estilo 'max-w-lg' (un solo bloque) para ser consistente con tu formulario de Crear --}}
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Grupo: <span class="text-[var(--blue-primary)]">{{ $grupo->nombre }}</span></h2>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('grupos.update', $grupo->id_grupo) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- CAMPO: ID Grupo (Manual) --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">ID Grupo (Manual)</label>
            {{-- Para editar, usamos old() primero, y si no hay, usamos el valor guardado del $grupo --}}
            <input type="text" 
                   name="id_grupo" 
                   value="{{ old('id_grupo', $grupo->id_grupo) }}" 
                   required 
                   maxlength="20" 
                   class="w-full border rounded px-3 py-2 @error('id_grupo') border-red-500 @enderror"
                   placeholder="Ej: G1-CALC1, G2-PROGRA">
            @error('id_grupo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO: Nombre --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nombre del Grupo</label>
            <input type="text" 
                   name="nombre" 
                   value="{{ old('nombre', $grupo->nombre) }}" 
                   required 
                   maxlength="30" 
                   class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                   placeholder="Ej: Grupo 1, Grupo A">
            @error('nombre')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO ELIMINADO: Capacidad --}}
        {{-- (Se borró el div de capacidad) --}}

        {{-- CAMPO ELIMINADO: Docente --}}
        {{-- (Se borró el div de docente, esto arregla el error de $docentes no definida) --}}

        {{-- CAMPO: Materia --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Materia</label>
            <select name="sigla" 
                    required 
                    class="w-full border rounded px-3 py-2 @error('sigla') border-red-500 @enderror">
                <option value="">Seleccione una materia</option>
                @foreach ($materias as $materia)
                    {{-- Lógica de "selected" para un formulario de edición --}}
                    <option value="{{ $materia->sigla }}" {{ (old('sigla', $grupo->sigla) == $materia->sigla) ? 'selected' : '' }}>
                        {{ $materia->nombre }} ({{ $materia->sigla }})
                    </option>
                @endforeach
            </select>
            @error('sigla')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO: Gestión Académica --}}
        <div class="mb-6">
            <label class="block mb-1 font-semibold">Gestión Académica</label>
            <select name="id_gestion" 
                    required 
                    class="w-full border rounded px-3 py-2 @error('id_gestion') border-red-500 @enderror">
                <option value="">Seleccione una gestión</option>
                @foreach ($gestiones as $gestion)
                    <option value="{{ $gestion->id_gestion }}" {{ (old('id_gestion', $grupo->id_gestion) == $gestion->id_gestion) ? 'selected' : '' }}>
                        {{ $gestion->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_gestion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones (del estilo de tu form de Crear) --}}
        <div class="flex justify-end space-x-3">
            <a href="{{ route('grupos.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection