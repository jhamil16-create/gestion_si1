@extends('layouts.app')
@section('title', 'Crear Aula')
@section('content')
<div class="max-w-lg mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Crear Nueva Aula</h2>
    <form action="{{ route('aulas.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block mb-1">Capacidad</label>
            <input type="number" name="capacidad" required min="1" class="w-full border rounded px-3 py-2">
        </div>
        <div class="mb-6">
            <label class="block mb-1">Tipo</label>
            <input type="text" name="tipo" required maxlength="30" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex justify-end space-x-3">
            <a href="{{ route('aulas.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection