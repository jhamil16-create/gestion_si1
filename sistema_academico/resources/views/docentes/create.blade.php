@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Registrar Nuevo Docente</h1>
    </div>

    <form action="/docentes" method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" id="codigo" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="DOC001">
            </div>

            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="titulo" class="block text-sm font-medium text-gray-700">Título Académico</label>
                <select id="titulo" name="titulo" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="">Seleccione un título</option>
                    <option value="licenciado">Licenciado/a</option>
                    <option value="magister">Magister</option>
                    <option value="doctor">Doctor/a</option>
                    <option value="phd">Ph.D.</option>
                </select>
            </div>

            <div>
                <label for="departamento" class="block text-sm font-medium text-gray-700">Departamento</label>
                <select id="departamento" name="departamento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-ficct-blue focus:border-ficct-blue sm:text-sm">
                    <option value="">Seleccione un departamento</option>
                    <option value="informatica">Informática</option>
                    <option value="matematica">Matemática</option>
                    <option value="fisica">Física</option>
                </select>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                <input type="tel" name="telefono" id="telefono" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-2">
                <label for="especialidad" class="block text-sm font-medium text-gray-700">Especialidad</label>
                <textarea name="especialidad" id="especialidad" rows="3" class="mt-1 focus:ring-ficct-blue focus:border-ficct-blue block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="/docentes" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
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
        const titulo = document.getElementById('titulo').value;
        const departamento = document.getElementById('departamento').value;
        
        if (!codigo || !nombre || !titulo || !departamento) {
            alert('Por favor complete todos los campos obligatorios');
            return;
        }
        // hola xd
        // Como es solo frontend, redirigimos al listado
        window.location.href = '/docentes';
    });
</script>
@endsection