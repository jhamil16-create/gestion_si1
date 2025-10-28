@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Asignación de Materias</h1>
        <button onclick="mostrarFormularioAsignacion()" class="bg-ficct-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Nueva Asignación
        </button>
    </div>

    <!-- Formulario de Asignación (oculto por defecto) -->
    <div id="formularioAsignacion" class="hidden mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Nueva Asignación</h2>
        <form class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="docente" class="block text-sm font-medium text-gray-700">Docente</label>
                    <select id="docente" name="docente" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                        <option value="">Seleccione un docente</option>
                        <option value="1">Dr. Juan Pérez Montoya</option>
                        <option value="2">Msc. María García Luna</option>
                    </select>
                </div>
                <div>
                    <label for="materia" class="block text-sm font-medium text-gray-700">Materia</label>
                    <select id="materia" name="materia" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                        <option value="">Seleccione una materia</option>
                        <option value="1">INF-100 Introducción a la Programación</option>
                        <option value="2">INF-200 Estructuras de Datos I</option>
                    </select>
                </div>
                <div>
                    <label for="grupo" class="block text-sm font-medium text-gray-700">Grupo</label>
                    <select id="grupo" name="grupo" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                        <option value="">Seleccione un grupo</option>
                        <option value="SA">SA</option>
                        <option value="SB">SB</option>
                        <option value="SC">SC</option>
                    </select>
                </div>
                <div>
                    <label for="periodo" class="block text-sm font-medium text-gray-700">Período</label>
                    <select id="periodo" name="periodo" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                        <option value="">Seleccione un período</option>
                        <option value="2025-1">I/2025</option>
                        <option value="2025-2">II/2025</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="ocultarFormularioAsignacion()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                    Cancelar
                </button>
                <button type="button" onclick="guardarAsignacion()" class="bg-ficct-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <!-- Asignación de ejemplo 1 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dr. Juan Pérez Montoya</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">INF-100 Introducción a la Programación</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SA</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">I/2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
                <!-- Asignación de ejemplo 2 -->
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Msc. María García Luna</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">INF-200 Estructuras de Datos I</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SB</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">I/2025</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button class="text-red-600 hover:text-red-900">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    function mostrarFormularioAsignacion() {
        document.getElementById('formularioAsignacion').classList.remove('hidden');
    }

    function ocultarFormularioAsignacion() {
        document.getElementById('formularioAsignacion').classList.add('hidden');
    }

    function guardarAsignacion() {
        const docente = document.getElementById('docente').value;
        const materia = document.getElementById('materia').value;
        const grupo = document.getElementById('grupo').value;
        const periodo = document.getElementById('periodo').value;

        if (!docente || !materia || !grupo || !periodo) {
            alert('Por favor complete todos los campos');
            return;
        }

        // Como es solo frontend, simplemente ocultamos el formulario
        ocultarFormularioAsignacion();
        alert('Asignación guardada correctamente');
    }
</script>
@endsection