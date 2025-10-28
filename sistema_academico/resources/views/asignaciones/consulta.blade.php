@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Consulta de Carga Docente</h1>
    </div>

    <!-- Filtros -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
        <form class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="docente" class="block text-sm font-medium text-gray-700">Docente</label>
                <select id="docente" name="docente" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="">Todos los docentes</option>
                    <option value="1">Dr. Juan Pérez Montoya</option>
                    <option value="2">Msc. María García Luna</option>
                </select>
            </div>
            <div>
                <label for="periodo" class="block text-sm font-medium text-gray-700">Período</label>
                <select id="periodo" name="periodo" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="">Todos los períodos</option>
                    <option value="2025-1">I/2025</option>
                    <option value="2025-2">II/2025</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="button" onclick="filtrarCarga()" class="bg-ficct-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Resumen de Carga -->
    <div class="mb-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Resumen de Carga Docente</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500">Total Materias Asignadas</p>
                <p class="text-2xl font-bold text-gray-900">5</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500">Total Horas Semanales</p>
                <p class="text-2xl font-bold text-gray-900">20</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500">Grupos Asignados</p>
                <p class="text-2xl font-bold text-gray-900">3</p>
            </div>
        </div>
    </div>

    <!-- Detalle de Carga -->
    <div>
        <h2 class="text-lg font-medium text-gray-900 mb-4">Detalle de Materias Asignadas</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Período</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horario</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Ejemplo de carga 1 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dr. Juan Pérez Montoya</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">INF-100 Introducción a la Programación</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SA</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">I/2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Lun-Mie 07:45-09:15</td>
                    </tr>
                    <!-- Ejemplo de carga 2 -->
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Dr. Juan Pérez Montoya</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">INF-200 Estructuras de Datos I</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">SB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">I/2025</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Mar-Jue 09:30-11:00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function filtrarCarga() {
        const docente = document.getElementById('docente').value;
        const periodo = document.getElementById('periodo').value;
        
        // Como es solo frontend, mostramos un mensaje
        alert(`Filtrando carga para:\nDocente: ${docente || 'Todos'}\nPeríodo: ${periodo || 'Todos'}`);
    }
</script>
@endsection