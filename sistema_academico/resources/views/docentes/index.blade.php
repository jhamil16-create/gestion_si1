@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Docentes</h1>
        <a href="/docentes/create" class="bg-ficct-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nuevo Docente
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Departamento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Docente de ejemplo 1 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">DOC001</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dr. Juan Pérez Montoya</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Doctor en Ciencias de la Computación</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Informática</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                        <button class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
                <!-- Docente de ejemplo 2 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">DOC002</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Msc. María García Luna</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Magister en Ingeniería de Software</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Informática</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</button>
                        <button class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4 flex items-center justify-between">
        <div class="flex-1 flex justify-between sm:hidden">
            <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Anterior
            </button>
            <button class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Siguiente
            </button>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Mostrando <span class="font-medium">1</span> a <span class="font-medium">2</span> de <span class="font-medium">2</span> resultados
                </p>
            </div>
            <div>
                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                    <button class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        Anterior
                    </button>
                    <button class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                        1
                    </button>
                    <button class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        Siguiente
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection