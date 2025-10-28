@extends('layouts.app')

@section('content')
<div x-data="{ usuario: null }" x-init="usuario = JSON.parse(localStorage.getItem('usuario') || sessionStorage.getItem('usuario') || '{}')">
    <!-- Dashboard para Administrador -->
    <template x-if="usuario.rol === 'admin'">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Panel de Administración</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Usuarios -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-ficct-blue rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Total Usuarios</h3>
                            <p class="text-2xl font-semibold text-gray-700">150</p>
                        </div>
                    </div>
                </div>

                <!-- Card Docentes -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-ficct-blue rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Total Docentes</h3>
                            <p class="text-2xl font-semibold text-gray-700">45</p>
                        </div>
                    </div>
                </div>

                <!-- Card Materias -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-ficct-blue rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="ml-5">
                            <h3 class="text-lg font-medium text-gray-900">Total Materias</h3>
                            <p class="text-2xl font-semibold text-gray-700">78</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico o tabla de resumen -->
            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Resumen de Asignaciones</h2>
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materias Asignadas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Juan Pérez</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">María García</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">16</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Carlos López</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pendiente
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>

    <!-- Dashboard para Docente -->
    <template x-if="usuario.rol === 'docente'">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Mi Panel de Docente</h1>

            <!-- Información del Docente -->
            <div class="mb-8">
                <div class="flex items-center mb-6">
                    <div class="w-20 h-20 bg-ficct-blue rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        <span x-text="usuario.nombre[0]"></span>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-xl font-bold text-gray-900" x-text="usuario.nombre"></h2>
                        <p class="text-gray-600" x-text="usuario.email"></p>
                        <p class="text-gray-600">Registro: <span x-text="usuario.registro"></span></p>
                    </div>
                </div>
            </div>

            <!-- Resumen de Carga Horaria -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Mi Carga Horaria</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Materias Asignadas</p>
                        <p class="text-2xl font-bold text-gray-900">3</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Total Horas</p>
                        <p class="text-2xl font-bold text-gray-900">12</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Grupos</p>
                        <p class="text-2xl font-bold text-gray-900">3</p>
                    </div>
                </div>
            </div>

            <!-- Listado de Materias -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <h3 class="text-lg font-medium text-gray-900 p-6 bg-gray-50 border-b">Mis Materias Asignadas</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aula</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Introducción a la Programación</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lun-Mie 07:45-09:15</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lab-1</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Estructuras de Datos I</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SB</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mar-Jue 09:30-11:00</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lab-2</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Programación Web</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SC</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mar-Jue 11:15-12:45</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lab-3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </template>
</div>
@endsection