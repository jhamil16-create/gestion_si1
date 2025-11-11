@extends('layouts.app')

@section('title', 'Registro de Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Registro de Asistencia
        </h1>

        @if(Auth::user()->isAdmin())
            <a href="{{ route('asistencias.create') }}" 
               class="mt-4 sm:mt-0 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                Registrar Nueva Asistencia
            </a>
        @endif
    </div>

    {{-- Mostrar errores de validación --}}
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

    {{-- Formulario de registro --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Registro de Asistencia Docente</h2>
        
        <form action="{{ route('asistencias.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Docente --}}
                <div>
                    <label for="id_docente" class="block text-sm font-medium text-gray-700 mb-2">
                        Docente *
                    </label>
                    <select name="id_docente" 
                            id="id_docente"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id_docente }}" 
                                    {{ old('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                                {{ $docente->usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_docente')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                        Fecha *
                    </label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha" 
                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('fecha')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora de Entrada --}}
                <div>
                    <label for="hora_entrada" class="block text-sm font-medium text-gray-700 mb-2">
                        Hora de Entrada
                    </label>
                    <input type="time" 
                           name="hora_entrada" 
                           id="hora_entrada" 
                           value="{{ old('hora_entrada') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('hora_entrada')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora de Salida --}}
                <div>
                    <label for="hora_salida" class="block text-sm font-medium text-gray-700 mb-2">
                        Hora de Salida
                    </label>
                    <input type="time" 
                           name="hora_salida" 
                           id="hora_salida" 
                           value="{{ old('hora_salida') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    @error('hora_salida')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado - CORREGIDO para usar 1 carácter --}}
                <div class="md:col-span-2">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        Estado *
                    </label>
                    <select name="estado" 
                            id="estado"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <option value="">Seleccione un estado</option>
                        <option value="P" {{ old('estado') == 'P' ? 'selected' : '' }}>Presente</option>
                        <option value="A" {{ old('estado') == 'A' ? 'selected' : '' }}>Ausente</option>
                        <option value="T" {{ old('estado') == 'T' ? 'selected' : '' }}>Tardanza</option>
                        <option value="L" {{ old('estado') == 'L' ? 'selected' : '' }}>Licencia</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
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
                    Registrar Asistencia
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Establecer fecha actual por defecto
    document.addEventListener('DOMContentLoaded', function() {
        const fechaInput = document.getElementById('fecha');
        if (!fechaInput.value) {
            fechaInput.value = new Date().toISOString().split('T')[0];
        }
    });
</script>
@endsection