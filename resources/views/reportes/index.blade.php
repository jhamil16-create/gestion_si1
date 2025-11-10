@extends('layouts.app')

@section('title', 'Reportes Académicos')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Encabezado --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Reportes Académicos
        </h1>
    </div>

    {{-- Formulario de Generación de Reportes --}}
    <div class="bg-white rounded-lg shadow-xl p-6">
        <form action="{{ route('reportes.generar') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Tipo de Reporte --}}
                <div class="md:col-span-2">
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">
                        Tipo de Reporte
                    </label>
                    <select name="tipo" 
                            id="tipo"
                            x-model="tipoReporte"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                        <option value="asistencia">Reporte de Asistencia</option>
                        <option value="carga_horaria">Reporte de Carga Horaria</option>
                        <option value="rendimiento">Reporte de Rendimiento</option>
                    </select>
                </div>

                {{-- Docente (solo para reportes específicos) --}}
                <div x-show="tipoReporte !== 'carga_horaria'" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    <label for="id_docente" class="block text-sm font-medium text-gray-700 mb-1">
                        Docente
                    </label>
                    <select name="id_docente" 
                            id="id_docente"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            x-bind:required="tipoReporte !== 'carga_horaria'">
                        @if(Auth::user()->isAdmin())
                            <option value="">Seleccione un docente</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id_docente }}">
                                    {{ $docente->usuario->nombre }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ Auth::user()->docente->id_docente }}">
                                {{ Auth::user()->nombre }}
                            </option>
                        @endif
                    </select>
                </div>

                {{-- Rango de Fechas --}}
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha Inicio
                    </label>
                    <input type="date" 
                           name="fecha_inicio" 
                           id="fecha_inicio"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>

                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha Fin
                    </label>
                    <input type="date" 
                           name="fecha_fin" 
                           id="fecha_fin"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           required>
                </div>

                {{-- Formato --}}
                <div class="md:col-span-2">
                    <label for="formato" class="block text-sm font-medium text-gray-700 mb-1">
                        Formato de Salida
                    </label>
                    <select name="formato" 
                            id="formato"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            required>
                        <option value="web">Ver en navegador</option>
                        <option value="pdf">Descargar PDF</option>
                    </select>
                </div>
            </div>

            {{-- Botón de Generación --}}
            <div class="mt-6">
                <button type="submit"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                    Generar Reporte
                </button>
            </div>
        </form>
    </div>

    {{-- Información Adicional --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card de Reporte de Asistencia --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-xl font-semibold text-gray-800 mb-2">
                Reporte de Asistencia
            </div>
            <p class="text-gray-600">
                Muestra el registro detallado de asistencias, tardanzas y ausencias de un docente específico en un período determinado.
            </p>
        </div>

        {{-- Card de Carga Horaria --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-xl font-semibold text-gray-800 mb-2">
                Reporte de Carga Horaria
            </div>
            <p class="text-gray-600">
                Presenta un resumen de las horas asignadas a cada docente, distribuidas por materias y grupos.
            </p>
        </div>

        {{-- Card de Rendimiento --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-xl font-semibold text-gray-800 mb-2">
                Reporte de Rendimiento
            </div>
            <p class="text-gray-600">
                Análisis combinado de asistencia y carga horaria, mostrando indicadores de cumplimiento y efectividad.
            </p>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('reporteForm', () => ({
            tipoReporte: 'asistencia',
        }))
    })
</script>
@endpush

@endsection