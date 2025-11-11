@extends('layouts.app')

@section('title', 'Editar Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Editar Asistencia</h1>
        <a href="{{ route('asistencias.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
            Volver
        </a>
    </div>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        <strong>Por favor corrige los siguientes errores:</strong>
                    </p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-xl p-6">
        <form action="{{ route('asistencias.update', $asistencia->id_asistencia) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Docente --}}
                <div>
                    <label for="id_docente" class="block text-sm font-medium text-gray-700 mb-1">
                        Docente *
                    </label>
                    <select name="id_docente" 
                            id="id_docente" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id_docente }}" {{ $asistencia->id_docente == $docente->id_docente ? 'selected' : '' }}>
                                {{ $docente->usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha *
                    </label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha"
                           value="{{ old('fecha', $asistencia->fecha->format('Y-m-d')) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>

                {{-- Hora Entrada --}}
                <div>
                    <label for="hora_entrada" class="block text-sm font-medium text-gray-700 mb-1">
                        Hora de Entrada *
                    </label>
                    <input type="time" 
                           name="hora_entrada" 
                           id="hora_entrada"
                           value="{{ old('hora_entrada', $asistencia->hora_entrada) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>

                {{-- Hora Salida --}}
                <div>
                    <label for="hora_salida" class="block text-sm font-medium text-gray-700 mb-1">
                        Hora de Salida *
                    </label>
                    <input type="time" 
                           name="hora_salida" 
                           id="hora_salida"
                           value="{{ old('hora_salida', $asistencia->hora_salida) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>

                {{-- Estado - CORREGIDO --}}
                <div class="md:col-span-2">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado *
                    </label>
                    <select name="estado" 
                            id="estado"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                        <option value="">Seleccione un estado</option>
                        <option value="P" {{ old('estado', $asistencia->estado) == 'P' ? 'selected' : '' }}>Presente</option>
                        <option value="A" {{ old('estado', $asistencia->estado) == 'A' ? 'selected' : '' }}>Ausente</option>
                        <option value="T" {{ old('estado', $asistencia->estado) == 'T' ? 'selected' : '' }}>Tardanza</option>
                        <option value="L" {{ old('estado', $asistencia->estado) == 'L' ? 'selected' : '' }}>Licencia</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">
                        P = Presente, A = Ausente, T = Tardanza, L = Licencia
                    </p>
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('asistencias.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                    Cancelar
                </a>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Actualizar Asistencia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection