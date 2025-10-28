@extends('layouts.app')
@section('title', 'Grupos')
@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Lista de Grupos</h2>
        <a href="{{ route('grupos.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus"></i> Nuevo Grupo
        </a>
    </div>

    <table class="min-w-full divide-y">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Nombre</th>
                <th class="px-4 py-2 text-left">Capacidad</th>
                <th class="px-4 py-2 text-left">Materia</th>
                <th class="px-4 py-2 text-left">Docente</th>
                <th class="px-4 py-2 text-left">Gestión</th>
                <th class="px-4 py-2 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($grupos as $grupo)
            <tr>
                <td class="px-4 py-2">{{ $grupo->nombre }}</td>
                <td class="px-4 py-2">{{ $grupo->capacidad }}</td>
                <td class="px-4 py-2">{{ $grupo->materia->nombre ?? $grupo->sigla }}</td>
                <td class="px-4 py-2">{{ $grupo->docente->usuario->nombre ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $grupo->gestionAcademica->nombre ?? 'N/A' }}</td>
                <td class="px-4 py-2 text-right">
                    <a href="{{ route('grupos.show', $grupo) }}" class="text-blue-600 hover:underline mr-2">Ver</a>
                    <a href="{{ route('grupos.edit', $grupo) }}" class="text-yellow-600 hover:underline mr-2">Editar</a>
                    <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar grupo?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="px-4 py-2 text-center text-gray-500">No hay grupos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection