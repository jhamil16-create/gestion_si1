@extends('layouts.app')
@section('title', 'Detalle de Docente')
@section('content')
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Docente: {{ $docente->usuario->nombre }}</h2>
        <div class="space-x-2">
            <a href="{{ route('docentes.edit', $docente->id_docente) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                Editar
            </a>
            <a href="{{ route('docentes.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Volver
            </a>
        </div>
    </div>

    <!-- Información del Docente -->
    <div class="bg-gray-50 rounded p-4 mb-6">
        <h3 class="text-lg font-semibold mb-3">Información Personal</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-600 text-sm">ID Docente</p>
                <p class="font-semibold">{{ $docente->id_docente }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">ID Usuario</p>
                <p class="font-semibold">{{ $docente->usuario->id_usuario }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Nombre Completo</p>
                <p class="font-semibold">{{ $docente->usuario->nombre }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Email</p>
                <p class="font-semibold">{{ $docente->usuario->email }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Teléfono</p>
                <p class="font-semibold">{{ $docente->usuario->telefono ?? 'No registrado' }}</p>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Fecha de Registro</p>
                <p class="font-semibold">{{ $docente->created_at->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Grupos que imparte -->
    @if($docente->grupos && $docente->grupos->count() > 0)
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Grupos que Imparte</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Nombre Grupo</th>
                            <th class="border px-4 py-2 text-left">Materia</th>
                            <th class="border px-4 py-2 text-left">Capacidad</th>
                            <th class="border px-4 py-2 text-left">Gestión</th>
                            <th class="border px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($docente->grupos as $grupo)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $grupo->nombre }}</td>
                                <td class="border px-4 py-2">
                                    {{ $grupo->materia->nombre ?? 'N/A' }}
                                    <span class="text-gray-500 text-sm">({{ $grupo->sigla }})</span>
                                </td>
                                <td class="border px-4 py-2">{{ $grupo->capacidad }} estudiantes</td>
                                <td class="border px-4 py-2">
                                    {{ $grupo->gestionAcademica->ano ?? 'N/A' }} - 
                                    {{ $grupo->gestionAcademica->semestre ?? 'N/A' }}
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
        </div>
    @else
        <div class="bg-blue-50 border border-blue-200 rounded p-4 text-center">
            <p class="text-blue-700">Este docente no tiene grupos asignados actualmente.</p>
        </div>
    @endif

    <!-- Botón de Eliminar -->
    <div class="mt-6 pt-6 border-t">
        <form action="{{ route('docentes.destroy', $docente->id_docente) }}" 
              method="POST" 
              onsubmit="return confirm('¿Estás seguro de eliminar este docente? Esta acción eliminará también su usuario asociado.');">
            @csrf
            @method('DELETE')
            <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Eliminar Docente
            </button>
        </form>
    </div>
</div>
@endsection