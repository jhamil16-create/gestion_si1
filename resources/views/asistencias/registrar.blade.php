@extends('layouts.app')

@section('title', 'Registrar Asistencia')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">
                    Registro de Asistencia Docente
                </h1>
            </div>

            {{-- Formulario de Registro --}}
            <form action="{{ route('asistencias.store') }}" method="POST" class="mt-6">
                @csrf
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Selección de Docente --}}
                    <div>
                        <label for="id_docente" class="block text-sm font-medium text-gray-700">
                            Docente
                        </label>
                        <select name="id_docente" 
                                id="id_docente" 
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Seleccione un docente</option>
                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id_docente }}">
                                    {{ $docente->usuario->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Fecha --}}
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">
                            Fecha
                        </label>
                        <input type="date" 
                               name="fecha" 
                               id="fecha"
                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               value="{{ date('Y-m-d') }}"
                               required>
                    </div>

                    {{-- Hora de Entrada --}}
                    <div>
                        <label for="hora_entrada" class="block text-sm font-medium text-gray-700">
                            Hora de Entrada
                        </label>
                        <input type="time" 
                               name="hora_entrada" 
                               id="hora_entrada"
                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    {{-- Hora de Salida --}}
                    <div>
                        <label for="hora_salida" class="block text-sm font-medium text-gray-700">
                            Hora de Salida
                        </label>
                        <input type="time" 
                               name="hora_salida" 
                               id="hora_salida"
                               class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    {{-- Estado --}}
                    <div class="md:col-span-2">
                        <label for="estado" class="block text-sm font-medium text-gray-700">
                            Estado
                        </label>
                        <select name="estado" 
                                id="estado"
                                class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="presente">Presente</option>
                            <option value="ausente">Ausente</option>
                            <option value="tardanza">Tardanza</option>
                        </select>
                    </div>
                </div>

                {{-- Botones --}}
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('asistencias.index') }}"
                       class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Registrar Asistencia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection