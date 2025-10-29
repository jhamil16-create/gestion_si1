@extends('layouts.app')
@section('title', 'Nueva Gestión')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Crear Gestión Académica</h2>
        <a href="{{ route('gestiones.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
           Volver
        </a>
    </div>

    {{-- Flashes --}}
    @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
    @endif

    <form action="{{ route('gestiones.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm text-gray-700 mb-1">Nombre <span class="text-red-600">*</span></label>
            <input type="text" name="nombre" value="{{ old('nombre') }}"
                   class="w-full border rounded px-3 py-2 @error('nombre') border-red-500 @enderror"
                   placeholder="p. ej. 2025-1" maxlength="30">
            @error('nombre')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">Fecha Inicio <span class="text-red-600">*</span></label>
                <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                       class="w-full border rounded px-3 py-2 @error('fecha_inicio') border-red-500 @enderror">
                @error('fecha_inicio')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Fecha Fin <span class="text-red-600">*</span></label>
                <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}"
                       class="w-full border rounded px-3 py-2 @error('fecha_fin') border-red-500 @enderror">
                @error('fecha_fin')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
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
