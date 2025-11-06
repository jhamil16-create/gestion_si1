@extends('layouts.app')
@section('title', 'Asignar Docente a Grupo')

@section('content')
{{-- 
  Usamos x-data de Alpine.js para manejar el estado de los dropdowns
  - 'grupos' será la lista de grupos filtrados.
  - 'id_grupo_seleccionado' guardará la selección del 2do dropdown.
  - 'cargando' nos mostrará un texto mientras busca.
--}}
<div class="max-w-lg mx-auto bg-white rounded shadow p-6"
     x-data="{ grupos: [], id_grupo_seleccionado: '', cargando: false }">

    <h2 class="text-xl font-bold mb-4">Asignar Docente a Grupo</h2>
    
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    {{-- 
        Este @if(session('success')) es útil por si el usuario 
        asigna uno y quiere asignar otro seguido.
    --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('docente_grupo.store') }}" method="POST">
        @csrf
        
        {{-- 1. SELECCIONAR DOCENTE --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Docente</label>
            <select name="id_docente" required class="w-full border rounded px-3 py-2">
                <option value="">Seleccione un docente</option>
                @foreach ($docentes as $docente)
                    <option value="{{ $docente->id_docente }}" {{ old('id_docente') == $docente->id_docente ? 'selected' : '' }}>
                        {{ $docente->usuario->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_docente')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- 2. SELECCIONAR MATERIA (El filtro) --}}
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Materia</label>
            <select name="sigla" required class="w-full border rounded px-3 py-2"
                    {{-- 
                      Aquí está la magia de Alpine.js:
                      Cuando este <select> cambie (@change), ejecutará el fetch...
                    --}}
                    @change="
                        cargando = true;
                        grupos = [];
                        id_grupo_seleccionado = '';
                        fetch('{{ route('api.grupos_por_materia') }}?sigla=' + $event.target.value)
                            .then(response => response.json())
                            .then(data => {
                                grupos = data;
                                cargando = false;
                            });
                    ">
                <option value="">Primero seleccione una materia</option>
                @foreach ($materias as $materia)
                    <option value="{{ $materia->sigla }}" {{ old('sigla') == $materia->sigla ? 'selected' : '' }}>
                        {{ $materia->nombre }} ({{ $materia->sigla }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 3. SELECCIONAR GRUPO (El resultado del filtro) --}}
        <div class="mb-6">
            <label class="block mb-1 font-semibold">Grupo</label>
            <select name="id_grupo" required class="w-full border rounded px-3 py-2" 
                    x-model="id_grupo_seleccionado" :disabled="grupos.length === 0 && !cargando">
                
                {{-- Estado inicial --}}
                <template x-if="grupos.length === 0 && !cargando">
                    <option value="">Seleccione una materia primero</option>
                </template>

                {{-- Estado de carga --}}
                <template x-if="cargando">
                    <option value="">Cargando grupos...</option>
                </template>

                {{-- Estado con resultados --}}
                <template x-if="grupos.length > 0 && !cargando">
                    <option value="">Seleccione un grupo</option>
                </template>
                <template x-for="grupo in grupos" :key="grupo.id_grupo">
                    <option :value="grupo.id_grupo" x-text="grupo.nombre"></option>
                </template>
                
                {{-- Estado sin resultados --}}
                <template x-if="!cargando && grupos.length === 0 && document.querySelector('[name=sigla]').value !== ''">
                     <option value="">No hay grupos para esta materia</option>
                </template>
            </select>
            @error('id_grupo')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-3">
            {{-- Usamos url()->previous() para volver a donde sea que estábamos --}}
            <a href="{{ url()->previous() }}" class="px-4 py-2 border rounded hover:bg-gray-100">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Asignar Docente
            </button>
        </div>
    </form>
</div>
@endsection