@extends('layouts.app')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Registrar Asistencia</h1>
            <p class="text-gray-600 mt-2">Docente: <strong>{{ Auth::user()->nombre }}</strong></p>
        </div>
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

    {{-- Tarjeta del formulario --}}
    <div class="bg-white rounded-lg shadow-xl p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Complete los datos de asistencia</h2>
            <p class="text-gray-600 mt-1">Seleccione el grupo y horario correspondiente</p>
        </div>

        <form action="{{ route('asistencias.store') }}" method="POST">
            @csrf

            {{-- Campo oculto con el ID del docente --}}
            <input type="hidden" name="id_docente" value="{{ Auth::user()->docente->id_docente }}">

            <div class="space-y-6">
                {{-- Asignación de Horario --}}
                <div>
                    <label for="id_asignacion" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check text-blue-600 mr-2"></i>Grupo y Horario *
                    </label>
                    <select name="id_asignacion" 
                            id="id_asignacion"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('id_asignacion') ? 'border-red-500' : '' }}"
                            required>
                        <option value="">Seleccione un grupo y horario</option>
                        @foreach($asignaciones as $asignacion)
                            <option value="{{ $asignacion->id_asignacion }}" {{ old('id_asignacion') == $asignacion->id_asignacion ? 'selected' : '' }}>
                                {{ $asignacion->grupo->materia->nombre }} - 
                                Grupo {{ $asignacion->grupo->nombre }} - 
                                {{ $asignacion->dia }} 
                                ({{ \Carbon\Carbon::parse($asignacion->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($asignacion->hora_fin)->format('H:i') }})
                                @if($asignacion->aula)
                                    - Aula: {{ $asignacion->aula->tipo }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('id_asignacion')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Fecha --}}
                <div>
                    <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-day text-blue-600 mr-2"></i>Fecha de Asistencia *
                    </label>
                    <input type="date" 
                           name="fecha" 
                           id="fecha"
                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('fecha') ? 'border-red-500' : '' }}"
                           required>
                    @error('fecha')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-check text-blue-600 mr-2"></i>Estado de Asistencia *
                    </label>
                    <select name="estado" 
                            id="estado"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('estado') ? 'border-red-500' : '' }}"
                            required>
                        <option value="">Seleccione un estado</option>
                        <option value="P" {{ old('estado') == 'P' ? 'selected' : '' }} class="text-blue-600"> Presente (P)</option>
                        <option value="A" {{ old('estado') == 'A' ? 'selected' : '' }} class="text-blue-600"> Ausente (A)</option>
                        <option value="T" {{ old('estado') == 'T' ? 'selected' : '' }} class="text-blue-600"> Tardanza (T)</option>
                        <option value="L" {{ old('estado') == 'L' ? 'selected' : '' }} class="text-blue-600"> Licencia (L)</option>
                    </select>
                    @error('estado')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Horas (Opcional) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="hora_entrada" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sign-in-alt text-blue-600 mr-2"></i>Hora de Entrada
                        </label>
                        <input type="time" 
                               name="hora_entrada" 
                               id="hora_entrada"
                               value="{{ old('hora_entrada') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('hora_entrada') ? 'border-red-500' : '' }}"
                               placeholder="HH:MM">
                        @error('hora_entrada')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="hora_salida" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sign-out-alt text-blue-600 mr-2"></i>Hora de Salida
                        </label>
                        <input type="time" 
                               name="hora_salida" 
                               id="hora_salida"
                               value="{{ old('hora_salida') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('hora_salida') ? 'border-red-500' : '' }}"
                               placeholder="HH:MM">
                        @error('hora_salida')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- Observaciones --}}
                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-sticky-note text-blue-600 mr-2"></i>Observaciones (Opcional)
                    </label>
                    <textarea name="observaciones" 
                              id="observaciones"
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('observaciones') ? 'border-red-500' : '' }}"
                              placeholder="Agregar notas o comentarios sobre la asistencia (motivo de tardanza, licencia, etc.)">{{ old('observaciones') }}</textarea>
                    @error('observaciones')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex gap-3 justify-end">
                <a href="{{ route('asistencias.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                    <i class="fas fa-save"></i>
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

        // Establecer hora actual como sugerencia para entrada
        const ahora = new Date();
        const horaActual = ahora.toTimeString().substring(0, 5);
        
        const horaEntradaInput = document.getElementById('hora_entrada');
        if (!horaEntradaInput.value) {
            horaEntradaInput.value = horaActual;
        }

        // Agregar 2 horas para la hora de salida sugerida
        const horaSalida = new Date(ahora.getTime() + 2 * 60 * 60 * 1000);
        const horaSalidaStr = horaSalida.toTimeString().substring(0, 5);
        
        const horaSalidaInput = document.getElementById('hora_salida');
        if (!horaSalidaInput.value) {
            horaSalidaInput.value = horaSalidaStr;
        }

        // Cambiar color del select de estado según la selección
        const estadoSelect = document.getElementById('estado');
    });
</script>

@endsection