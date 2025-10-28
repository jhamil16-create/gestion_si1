@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Registrar Nueva Materia</h1>
    </div>

    <form action="/materias" method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" id="codigo" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="INF-100">
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="semestre" class="block text-sm font-medium text-gray-700">Semestre</label>
                <select id="semestre" name="semestre" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="">Seleccione un semestre</option>
                    <option value="1">1er Semestre</option>
                    <option value="2">2do Semestre</option>
                    <option value="3">3er Semestre</option>
                    <option value="4">4to Semestre</option>
                    <option value="5">5to Semestre</option>
                    <option value="6">6to Semestre</option>
                    <option value="7">7mo Semestre</option>
                    <option value="8">8vo Semestre</option>
                    <option value="9">9no Semestre</option>
                    <option value="10">10mo Semestre</option>
                </select>
            </div>

            <div>
                <label for="creditos" class="block text-sm font-medium text-gray-700">Créditos</label>
                <input type="number" name="creditos" id="creditos" min="1" max="10" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="horas_teoria" class="block text-sm font-medium text-gray-700">Horas Teoría</label>
                <input type="number" name="horas_teoria" id="horas_teoria" min="0" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="horas_practica" class="block text-sm font-medium text-gray-700">Horas Práctica</label>
                <input type="number" name="horas_practica" id="horas_practica" min="0" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-2">
                <label for="prerequisitos" class="block text-sm font-medium text-gray-700">Prerequisitos</label>
                <select id="prerequisitos" name="prerequisitos[]" multiple class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="INF-100">INF-100 - Introducción a la Programación</option>
                    <option value="INF-110">INF-110 - Algoritmos y Programación</option>
                    <option value="MAT-100">MAT-100 - Cálculo I</option>
                </select>
                <p class="mt-1 text-sm text-gray-500">Mantenga presionado Ctrl (Cmd en Mac) para seleccionar múltiples materias</p>
            </div>

            <div class="col-span-2">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="/materias" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
                Cancelar
            </a>
            <button type="submit" class="bg-ficct-blue hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Guardar
            </button>
        </div>
    </form>
</div>

<script>
    // Validación del formulario
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const codigo = document.getElementById('codigo').value;
        const nombre = document.getElementById('nombre').value;
        const semestre = document.getElementById('semestre').value;
        const creditos = document.getElementById('creditos').value;
        
        if (!codigo || !nombre || !semestre || !creditos) {
            alert('Por favor complete todos los campos obligatorios');
            return;
        }
        
        // Validar formato del código
        const codigoRegex = /^[A-Z]{3}-\d{3}$/;
        if (!codigoRegex.test(codigo)) {
            alert('El código debe tener el formato XXX-000 (ejemplo: INF-100)');
            return;
        }
        
        // Como es solo frontend, redirigimos al listado
        window.location.href = '/materias';
    });

    // Calcular total de horas
    const horasTeoria = document.getElementById('horas_teoria');
    const horasPractica = document.getElementById('horas_practica');
    
    function actualizarTotalHoras() {
        const total = (parseInt(horasTeoria.value) || 0) + (parseInt(horasPractica.value) || 0);
        document.getElementById('creditos').value = Math.ceil(total / 20); // Ejemplo: 1 crédito por cada 20 horas
    }
    
    horasTeoria.addEventListener('change', actualizarTotalHoras);
    horasPractica.addEventListener('change', actualizarTotalHoras);
</script>
@endsection