@extends('layouts.app')
@section('title', 'Nueva Aula')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Crear Aula</h2>
        <a href="{{ route('aulas.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
           Volver
        </a>
    </div>

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('aulas.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm text-gray-700 mb-1">Tipo <span class="text-red-600">*</span></label>
            <input type="text" name="tipo" value="{{ old('tipo') }}"
                   class="w-full border rounded px-3 py-2 @error('tipo') border-red-500 @enderror"
                   maxlength="30" placeholder="p. ej. Laboratorio, Teoría, Auditorio">
            @error('tipo')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm text-gray-700 mb-1">Capacidad <span class="text-red-600">*</span></label>
            <input type="number" name="capacidad" value="{{ old('capacidad') }}"
                   class="w-full border rounded px-3 py-2 @error('capacidad') border-red-500 @enderror"
                   min="1" step="1" placeholder="p. ej. 40">
            @error('capacidad')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
