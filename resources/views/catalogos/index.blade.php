@extends('layouts.app')
@section('title', 'Importar y Exportar Catálogos')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <h2 class="text-xl font-bold mb-4">Importar y Exportar Catálogos</h2>
    <p class="text-gray-600 mb-6">Gestiona la carga masiva de datos desde aquí</p>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            <p class="font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <p class="font-semibold mb-2">¡Error! Hubo problemas con el archivo:</p>
            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Gestión de Aulas --}}
    <div class="mb-6 border-b pb-6">
        <h3 class="text-lg font-semibold mb-4">Gestión de Aulas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Exportar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Exportar</h5>
                <p class="text-sm text-gray-600">
                    Descarga un archivo Excel (xlsx) con el listado completo de aulas.
                </p>
                <a href="{{ route('aulas.export') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors font-medium text-sm">
                    <i class="fas fa-file-excel"></i>
                    Exportar Aulas
                </a>
            </div>

            {{-- Importar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Importar</h5>
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
                               class="block w-full text-sm text-gray-500 border rounded px-3 py-2">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-upload"></i>
                        Importar Aulas
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Gestión de Materias --}}
    <div class="mb-6 border-b pb-6">
        <h3 class="text-lg font-semibold mb-4">Gestión de Materias</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Exportar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Exportar</h5>
                <p class="text-sm text-gray-600">
                    Descarga un archivo Excel (xlsx) con el listado completo de materias.
                </p>
                <a href="{{ route('materias.export') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors font-medium text-sm">
                    <i class="fas fa-file-excel"></i>
                    Exportar Materias
                </a>
            </div>

            {{-- Importar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Importar</h5>
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
                               class="block w-full text-sm text-gray-500 border rounded px-3 py-2">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-upload"></i>
                        Importar Materias
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Gestión de Docentes --}}
    <div class="mb-6 border-b pb-6">
        <h3 class="text-lg font-semibold mb-4">Gestión de Docentes</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Exportar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Exportar</h5>
                <p class="text-sm text-gray-600">
                    Descarga un archivo Excel (xlsx) con el listado completo de docentes.
                </p>
                <a href="{{ route('docentes.export') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors font-medium text-sm">
                    <i class="fas fa-file-excel"></i>
                    Exportar Docentes
                </a>
            </div>

            {{-- Importar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Importar</h5>
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
                               class="block w-full text-sm text-gray-500 border rounded px-3 py-2">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-upload"></i>
                        Importar Docentes
                    </button>
                </form>
            </div>

        </div>
    </div>

    {{-- Gestión de Grupos --}}
    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-4">Gestión de Grupos</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- Exportar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Exportar</h5>
                <p class="text-sm text-gray-600">
                    Descarga un archivo Excel (xlsx) con el listado completo de grupos.
                </p>
                <a href="{{ route('grupos.export') }}" 
                   class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors font-medium text-sm">
                    <i class="fas fa-file-excel"></i>
                    Exportar Grupos
                </a>
            </div>

            {{-- Importar --}}
            <div class="space-y-3">
                <h5 class="font-semibold">Importar</h5>
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
                               class="block w-full text-sm text-gray-500 border rounded px-3 py-2">
                    </div>
                    <button type="submit" 
                            class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors font-medium text-sm">
                        <i class="fas fa-file-upload"></i>
                        Importar Grupos
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection