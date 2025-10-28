@extends('layouts.app')
@section('title', 'Editar Aula')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Editar Aula #{{ $aula->id_aula }}</h2>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('aulas.update', $aula->id_aula) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Capacidad</label>
            <input type="number" 
                   name="capacidad" 
                   value="{{ old('capacidad', $aula->capacidad) }}" 
                   required 
                   min="1" 
                   class="w-full border rounded px-3 py-2">
        </div>

        <div class="mb-6">
            <label class="block mb-1 font-semibold">Tipo</label>
            <input type="text" 
                   name="tipo" 
                   value="{{ old('tipo', $aula->tipo) }}" 
                   required 
                   maxlength="30" 
                   class="w-full border rounded px-3 py-2"
                   placeholder="Ej: Laboratorio, Aula Normal, Auditorio">
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('aulas.index') }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection