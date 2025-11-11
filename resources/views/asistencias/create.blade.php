@extends('layouts.app')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Registrar Asistencia</h1>
        <a href="{{ route('asistencias.index') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Volver
        </a>
    </div>

    {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-semibold text-red-800 mb-2">Por favor corrige los siguientes errores:</p>
                    <ul class="text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-xl p-6">
        <form action="{{ route('asistencias.store') }}" method="POST">
            @csrf

            <div class="space-y-6">
                {{-- Asignación de Horario --}}
                <div>
                    <label for="id_asignacion" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-blue-600 mr-2"></i>Asignación de Horario *
                    </label>
                    <select name="id_asignacion" 
                            id="id_asignacion"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('id_asignacion') ? 'border-red-500' : '' }}"
                            required>
                        <option value="">Seleccione una asignación</option>
                        @foreach($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id_asignacion }}" {{ old('id_asignacion') == $asignacion->id_asignacion ? 'selected' : '' }}>
                                {{ $asignacion->grupo->materia->nombre }} - Grupo {{ $asignacion->grupo->nombre }} ({{ $asignacion->dia }})
                            </option>
                        @endforeach
                    </select>
                    @error('id_asignacion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar text-blue-600 mr-2"></i>Fecha *
                    </label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha"
                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('fecha') ? 'border-red-500' : '' }}"
                           required>
                    @error('fecha')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flag text-blue-600 mr-2"></i>Estado *
                    </label>
                    <select name="estado" 
                            id="estado"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('estado') ? 'border-red-500' : '' }}"
                            required>
                        <option value="">Seleccione un estado</option>
                        <option value="P" {{ old('estado') == 'P' ? 'selected' : '' }}>Presente (P)</option>
                        <option value="F" {{ old('estado') == 'F' ? 'selected' : '' }}>Falta (F)</option>
                        <option value="L" {{ old('estado') == 'L' ? 'selected' : '' }}>Licencia (L)</option>
                    </select>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">
                        P = Presente | F = Falta | L = Licencia
                    </p>
                </div>

                {{-- Observaciones --}}
                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-note-sticky text-blue-600 mr-2"></i>Observaciones (Opcional)
                    </label>
                    <textarea name="observaciones" 
                              id="observaciones"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('observaciones') ? 'border-red-500' : '' }}"
                              placeholder="Agregar notas o comentarios sobre la asistencia">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-8 flex gap-3 justify-end">
                <a href="{{ route('asistencias.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-save"></i>
                    Registrar Asistencia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection