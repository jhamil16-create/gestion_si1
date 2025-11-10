@extends('layouts.app')
@section('title', 'Importar y Exportar Catálogos')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- Encabezado --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Importar y Exportar Catálogos</h2>
                <p class="text-sm text-gray-600 mt-1">Gestiona la carga masiva de datos desde aquí</p>
            </div>
        </div>
    </div>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-1"></i>
                <div class="flex-1">
                    <p class="text-red-800 font-semibold mb-2">¡Error! Hubo problemas con el archivo:</p>
                    <ul class="list-disc list-inside space-y-1 text-red-700 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Card: Gestión de Aulas --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-door-open text-blue-600 mr-2"></i>
                Gestión de Aulas
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Exportar --}}
                <div class="space-y-3">
                    <h5 class="text-lg font-semibold text-gray-800">Exportar</h5>
                    <p class="text-sm text-gray-600">
                        Descarga un archivo Excel (xlsx) con el listado completo de aulas.
                    </p>
                    <a href="{{ route('aulas.export') }}" 
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-excel"></i>
                        Exportar Aulas
                    </a>
                </div>

                {{-- Importar --}}
                <div class="space-y-3 md:border-l md:pl-6">
                    <h5 class="text-lg font-semibold text-gray-800">Importar</h5>
                    <p class="text-sm text-gray-600">
                        Sube un archivo (xlsx, csv) para crear o actualizar aulas masivamente.
                    </p>
                    
                    <form action="{{ route('aulas.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="archivo_aulas" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar archivo:
                            </label>
                            <input type="file" 
                                   name="archivo_aulas" 
                                   id="archivo_aulas" 
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition-colors font-medium text-sm">
                            <i class="fas fa-file-upload"></i>
                            Importar Aulas
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Card: Gestión de Materias --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-book text-purple-600 mr-2"></i>
                Gestión de Materias
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Exportar --}}
                <div class="space-y-3">
                    <h5 class="text-lg font-semibold text-gray-800">Exportar</h5>
                    <p class="text-sm text-gray-600">
                        Descarga un archivo Excel (xlsx) con el listado completo de materias.
                    </p>
                    <a href="{{ route('materias.export') }}" 
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-excel"></i>
                        Exportar Materias
                    </a>
                </div>

                {{-- Importar --}}
                <div class="space-y-3 md:border-l md:pl-6">
                    <h5 class="text-lg font-semibold text-gray-800">Importar</h5>
                    <p class="text-sm text-gray-600">
                        Sube un archivo (xlsx, csv) para crear o actualizar materias masivamente.
                    </p>
                    
                    <form action="{{ route('materias.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="archivo_materias" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar archivo:
                            </label>
                            <input type="file" 
                                   name="archivo_materias" 
                                   id="archivo_materias" 
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-purple-500 text-white px-4 py-2 rounded-md hover:bg-purple-600 transition-colors font-medium text-sm">
                            <i class="fas fa-file-upload"></i>
                            Importar Materias
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Card: Gestión de Docentes --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-chalkboard-teacher text-orange-600 mr-2"></i>
                Gestión de Docentes
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Exportar --}}
                <div class="space-y-3">
                    <h5 class="text-lg font-semibold text-gray-800">Exportar</h5>
                    <p class="text-sm text-gray-600">
                        Descarga un archivo Excel (xlsx) con el listado completo de docentes.
                    </p>
                    <a href="{{ route('docentes.export') }}" 
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-excel"></i>
                        Exportar Docentes
                    </a>
                </div>

                {{-- Importar --}}
                <div class="space-y-3 md:border-l md:pl-6">
                    <h5 class="text-lg font-semibold text-gray-800">Importar</h5>
                    <p class="text-sm text-gray-600">
                        Sube un archivo (xlsx, csv) para crear o actualizar docentes masivamente.
                    </p>
                    
                    <form action="{{ route('docentes.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="archivo_docentes" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar archivo:
                            </label>
                            <input type="file" 
                                   name="archivo_docentes" 
                                   id="archivo_docentes" 
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition-colors font-medium text-sm">
                            <i class="fas fa-file-upload"></i>
                            Importar Docentes
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    {{-- Card: Gestión de Grupos --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-users text-green-600 mr-2"></i>
                Gestión de Grupos
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Exportar --}}
                <div class="space-y-3">
                    <h5 class="text-lg font-semibold text-gray-800">Exportar</h5>
                    <p class="text-sm text-gray-600">
                        Descarga un archivo Excel (xlsx) con el listado completo de grupos.
                    </p>
                    <a href="{{ route('grupos.export') }}" 
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-excel"></i>
                        Exportar Grupos
                    </a>
                </div>

                {{-- Importar --}}
                <div class="space-y-3 md:border-l md:pl-6">
                    <h5 class="text-lg font-semibold text-gray-800">Importar</h5>
                    <p class="text-sm text-gray-600">
                        Sube un archivo (xlsx, csv) para crear o actualizar grupos masivamente.
                    </p>
                    
                    <form action="{{ route('grupos.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label for="archivo_grupos" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar archivo:
                            </label>
                            <input type="file" 
                                   name="archivo_grupos" 
                                   id="archivo_grupos" 
                                   required
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition-colors font-medium text-sm">
                            <i class="fas fa-file-upload"></i>
                            Importar Grupos
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection