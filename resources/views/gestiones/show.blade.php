@extends('layouts.app')
@section('title', 'Detalle de Gestión Académica')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Gestión Académica: {{ $gestion->ano }} - {{ $gestion->semestre }}</h2>
        <div class="space-x-2">
            <a href="{{ route('gestiones.edit', $gestion->id_gestion) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('gestiones.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>

    <!-- Información de la Gestión -->
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información General</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Gestión</p>
                <p class="font-semibold">{{ $gestion->id_gestion }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Año</p>
                <p class="font-semibold text-2xl text-blue-600">{{ $gestion->ano }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Semestre</p>
                <p class="font-semibold">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded">
                        {{ $gestion->semestre }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Fecha de Creación</p>
                <p class="font-semibold">{{ $gestion->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Grupos asociados a esta gestión -->
    @if($gestion->grupos && $gestion->grupos->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Grupos en esta Gestión ({{ $gestion->grupos->count() }})</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nombre Grupo</th>
                            <th class="border px-4 py-2 text-left">Materia</th>
                            <th class="border px-4 py-2 text-left">Docente</th>
                            <th class="border px-4 py-2 text-left">Capacidad</th>
                            <th class="border px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gestion->grupos as $grupo)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2 font-semibold">{{ $grupo->nombre }}</td>
                                <td class="border px-4 py-2">
                                    {{ $grupo->materia->nombre ?? 'N/A' }}
                                    <span class="text-gray-500 text-sm">({{ $grupo->sigla }})</span>
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $grupo->docente->usuario->nombre ?? 'Sin asignar' }}
                                </td>
                                <td class="border px-4 py-2">{{ $grupo->capacidad }} estudiantes</td>
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
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">No hay grupos registrados en esta gestión académica.</p>
        </div>
    @endif

    <!-- Estadísticas -->
    @if($gestion->grupos && $gestion->grupos->count() > 0)
        <div class="mt-6 bg-green-50 border border-green-200 rounded p-4">
            <h3 class="text-lg font-semibold mb-3 text-green-800">Estadísticas</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $gestion->grupos->count() }}</p>
                    <p class="text-gray-600 text-sm">Total Grupos</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $gestion->grupos->sum('capacidad') }}</p>
                    <p class="text-gray-600 text-sm">Capacidad Total</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-green-600">{{ $gestion->grupos->unique('sigla')->count() }}</p>
                    <p class="text-gray-600 text-sm">Materias Diferentes</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Botón de Eliminar -->
    <div class="mt-6 pt-6 border-t">
        <form action="{{ route('gestiones.destroy', $gestion->id_gestion) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar esta gestión? Esto podría afectar a los grupos asociados.');">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Gestión
            </button>
        </form>
    </div>
</div>
@endsection