@extends('layouts.app')
@section('title', 'Editar Gestión Académica')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Gestión: {{ $gestion->ano }} - {{ $gestion->semestre }}</h2>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gestiones.update', $gestion->id_gestion) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Año</label>
            <input type="number" 
                   name="ano" 
                   value="{{ old('ano', $gestion->ano) }}" 
                   required 
                   min="2000" 
                   max="2100"
                   class="w-full border rounded px-3 py-2"
                   placeholder="Ej: 2024">
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold">Semestre</label>
            <select name="semestre" required class="w-full border rounded px-3 py-2">
                <option value="">Selecciona un semestre</option>
                <option value="1" {{ old('semestre', $gestion->semestre) == '1' ? 'selected' : '' }}>1 - Primer Semestre</option>
                <option value="2" {{ old('semestre', $gestion->semestre) == '2' ? 'selected' : '' }}>2 - Segundo Semestre</option>
                <option value="Verano" {{ old('semestre', $gestion->semestre) == 'Verano' ? 'selected' : '' }}>Verano</option>
            </select>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('gestiones.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection