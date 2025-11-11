@extends('layouts.app')

@section('title', 'Reportes Académicos')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    <div class="bg-white sm:rounded-lg shadow-xl">
        {{-- CABECERA RESPONSIVA --}}
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Reportes Académicos</h2>
                <p class="mt-1 text-sm text-gray-600">Genera reportes de asistencia, carga horaria y rendimiento</p>
            </div>
        </div>

        {{-- FORMULARIO DE GENERACIÓN --}}
        <div class="px-5 py-6">
            <form action="{{ route('reportes.generar') }}" method="POST" x-data="{ tipoReporte: 'asistencia' }">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tipo de Reporte --}}
                    <div class="md:col-span-2">
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Reporte
                        </label>
                        <select name="tipo" 
                                id="tipo"
                                x-model="tipoReporte"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
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
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="md:col-span-2">
                        <label for="id_docente" class="block text-sm font-semibold text-gray-700 mb-2">
                            Docente
                        </label>
                        <select name="id_docente" 
                                id="id_docente"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
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

                    {{-- Fecha Inicio --}}
                    <div>
                        <label for="fecha_inicio" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha Inicio
                        </label>
                        <input type="date" 
                               name="fecha_inicio" 
                               id="fecha_inicio"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                               required>
                    </div>

                    {{-- Fecha Fin --}}
                    <div>
                        <label for="fecha_fin" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fecha Fin
                        </label>
                        <input type="date" 
                               name="fecha_fin" 
                               id="fecha_fin"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                               required>
                    </div>

                    {{-- Formato --}}
                    <div class="md:col-span-2">
                        <label for="formato" class="block text-sm font-semibold text-gray-700 mb-2">
                            Formato de Salida
                        </label>
                        <select name="formato" 
                                id="formato"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                required>
                            <option value="web">Ver en navegador</option>
                            <option value="pdf">Descargar PDF</option>
                        </select>
                    </div>
                </div>

                {{-- Botón de Generación --}}
                <div class="mt-6">
                    <button type="submit"
                            class="w-full bg-[var(--blue-primary)] text-white px-4 py-3 rounded-md hover:bg-[var(--blue-hover)] transition-colors font-medium">
                        <i class="fas fa-file-pdf mr-2"></i>
                        Generar Reporte
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- INFORMACIÓN DE TIPOS DE REPORTES --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        {{-- Card de Reporte de Asistencia --}}
        <div class="bg-white sm:rounded-lg shadow-xl p-5">
            <div class="flex items-center mb-3">
                <div class="bg-blue-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    Reporte de Asistencia
                </h3>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                Muestra el registro detallado de asistencias, tardanzas y ausencias de un docente específico en un período determinado.
            </p>
        </div>

        {{-- Card de Carga Horaria --}}
        <div class="bg-white sm:rounded-lg shadow-xl p-5">
            <div class="flex items-center mb-3">
                <div class="bg-green-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-clock text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    Reporte de Carga Horaria
                </h3>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                Presenta un resumen de las horas asignadas a cada docente, distribuidas por materias y grupos.
            </p>
        </div>

        {{-- Card de Rendimiento --}}
        <div class="bg-white sm:rounded-lg shadow-xl p-5">
            <div class="flex items-center mb-3">
                <div class="bg-purple-100 p-3 rounded-lg mr-3">
                    <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800">
                    Reporte de Rendimiento
                </h3>
            </div>
            <p class="text-sm text-gray-600 leading-relaxed">
                Análisis combinado de asistencia y carga horaria, mostrando indicadores de cumplimiento y efectividad.
            </p>
        </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

</div>
@endsection