@extends('layouts.app')
@section('title', 'Detalles de Materia')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    
    {{-- INICIO CORRECCIÓN: Cabecera responsiva con botones --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold">
            Materia: {{ $materia->nombre }}
        </h2>
        <div class="flex-shrink-0 w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            {{-- Asumimos que existen estas rutas --}}
            <a href="{{ route('materias.edit', $materia->sigla) }}" 
               class="w-full text-center bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('materias.index') }}" 
               class="w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>
    {{-- FIN CORRECCIÓN --}}

    {{-- Información de la Materia --}}
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información de la Materia</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">Sigla</p>
                <p class="font-semibold">{{ $materia->sigla }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre Completo</p>
                <p class="font-semibold">{{ $materia->nombre }}</p>
            </div>
        </div>
    </div>

    {{-- Grupos Asignados --}}
    @if ($materia->grupos && $materia->grupos->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Grupos Asignados</h3>
            
            {{-- INICIO CORRECCIÓN: 1. Tabla (Solo para Desktop) --}}
            <div class="overflow-x-auto hidden sm:block">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="border px-4 py-2">Nombre Grupo</th>
                            <th class="border px-4 py-2">Docentes</th>
                            <th class="border px-4 py-2">Capacidad</th>
                            <th class="border px-4 py-2">Gestión</th>
                            <th class="border px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materia->grupos as $grupo)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $grupo->nombre ?? '—' }}</td>
                                <td class="border px-4 py-2">
                                    {{-- Lógica N-N corregida --}}
                                    {{ $grupo->docentes->pluck('usuario.nombre')->join(', ') ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2">{{ $grupo->capacidad ?? 0 }} estudiantes</td>
                                <td class="border px-4 py-2">
                                    {{ optional($grupo->gestionAcademica)->nombre ?? 'N/A' }}
                                </td>
                                <td class="border px-4 py-2 text-center">
                                    <a href="{{ route('grupos.show', $grupo->id_grupo) }}" 
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                        Ver Grupo
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- FIN CORRECCIÓN: 1. Tabla --}}
            
            {{-- INICIO CORRECCIÓN: 2. Tarjetas (Solo para Móvil) --}}
            <div class="space-y-4 sm:hidden">
                @foreach($materia->grupos as $grupo)
                <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                    <div class="flex justify-between items-center mb-2 pb-2 border-b">
                        <span class="text-sm font-semibold text-gray-500 uppercase">Grupo</span>
                        <span class="font-medium text-gray-800 text-right">{{ $grupo->nombre ?? '—' }}</span>
                    </div>

                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Docentes</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{-- Lógica N-N corregida --}}
                            {{ $grupo->docentes->pluck('usuario.nombre')->join(', ') ?? 'N/A' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-semibold text-gray-500">Gestión</span>
                        <span class="text-sm text-gray-700 text-right">
                            {{ optional($grupo->gestionAcademica)->nombre ?? 'N/A' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mb-4">
                        <span class="text-sm font-semibold text-gray-500">Capacidad</span>
                        <span class="text-sm text-gray-700 text-right">{{ $grupo->capacidad ?? 0 }} estud.</span>
                    </div>
                    
                    <div class="flex flex-col items-center justify-center gap-2 border-t pt-3">
                         <a href="{{ route('grupos.show', $grupo->id_grupo) }}" 
                            class="w-full text-center bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                             Ver Grupo
                         </a>
                    </div>
                </div>
                @endforeach
            </div>
            {{-- FIN CORRECCIÓN: 2. Tarjetas --}}

        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">No hay grupos asignados a esta materia.</p>
        </div>
    @endif

    {{-- INICIO CORRECCIÓN: Botón de Eliminar (para consistencia) --}}
    <div class="mt-6 pt-6 border-t">
        <form action="{{ route('materias.destroy', $materia->sigla) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar esta materia? Esta acción solo se permite si no tiene grupos asociados.');">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Materia
            </button>
        </form>
    </div>
    {{-- FIN CORRECCIÓN --}}

</div>
@endsection