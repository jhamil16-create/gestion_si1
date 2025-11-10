@extends('layouts.app')

@section('title', isset($asistencia) ? 'Editar Asistencia' : 'Registrar Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            {{ isset($asistencia) ? 'Editar Asistencia' : 'Registrar Asistencia' }}
        </h1>
        <a href="{{ route('asistencias.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
            Volver
        </a>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-lg shadow-xl p-6">
        <form action="{{ isset($asistencia) ? route('asistencias.update', $asistencia) : route('asistencias.store') }}" 
              method="POST">
            @csrf
            @if(isset($asistencia))
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Selección de Docente --}}
                <div>
                    <label for="id_docente" class="block text-sm font-medium text-gray-700 mb-1">
                        Docente
                    </label>
                    <select name="id_docente" 
                            id="id_docente" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('id_docente') border-red-500 @enderror"
                            required>
                        <option value="">Seleccione un docente</option>
                        @foreach($docentes as $docente)
                            <option value="{{ $docente->id_docente }}"
                                {{ (old('id_docente', $asistencia->id_docente ?? '') == $docente->id_docente) ? 'selected' : '' }}>
                                {{ $docente->usuario->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_docente')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha
                    </label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha"
                           value="{{ old('fecha', isset($asistencia) ? $asistencia->fecha->format('Y-m-d') : '') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('fecha') border-red-500 @enderror"
                           required>
                    @error('fecha')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora Entrada --}}
                <div>
                    <label for="hora_entrada" class="block text-sm font-medium text-gray-700 mb-1">
                        Hora de Entrada
                    </label>
                    <input type="time" 
                           name="hora_entrada" 
                           id="hora_entrada"
                           value="{{ old('hora_entrada', $asistencia->hora_entrada ?? '') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('hora_entrada') border-red-500 @enderror"
                           required>
                    @error('hora_entrada')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hora Salida --}}
                <div>
                    <label for="hora_salida" class="block text-sm font-medium text-gray-700 mb-1">
                        Hora de Salida
                    </label>
                    <input type="time" 
                           name="hora_salida" 
                           id="hora_salida"
                           value="{{ old('hora_salida', $asistencia->hora_salida ?? '') }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('hora_salida') border-red-500 @enderror"
                           required>
                    @error('hora_salida')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div class="md:col-span-2">
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado
                    </label>
                    <select name="estado" 
                            id="estado"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('estado') border-red-500 @enderror"
                            required>
                        <option value="presente" {{ (old('estado', $asistencia->estado ?? '') === 'presente') ? 'selected' : '' }}>
                            Presente
                        </option>
                        <option value="ausente" {{ (old('estado', $asistencia->estado ?? '') === 'ausente') ? 'selected' : '' }}>
                            Ausente
                        </option>
                        <option value="tardanza" {{ (old('estado', $asistencia->estado ?? '') === 'tardanza') ? 'selected' : '' }}>
                            Tardanza
                        </option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" 
                        onclick="window.history.back()"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    {{ isset($asistencia) ? 'Actualizar' : 'Registrar' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection