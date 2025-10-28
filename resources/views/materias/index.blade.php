@extends('layouts.app')
@section('title', 'Materias')
@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Lista de Materias</h2>
        <a href="{{ route('materias.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus"></i> Nueva Materia
        </a>
    </div>

    <table class="min-w-full divide-y">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left">Sigla</th>
                <th class="px-4 py-2 text-left">Nombre</th>
                <th class="px-4 py-2 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse ($materias as $materia)
            <tr>
                <td class="px-4 py-2 font-mono">{{ $materia->sigla }}</td>
                <td class="px-4 py-2">{{ $materia->nombre }}</td>
                <td class="px-4 py-2 text-right">
                    <a href="{{ route('materias.show', $materia) }}" class="text-blue-600 hover:underline mr-2">Ver</a>
                    <a href="{{ route('materias.edit', $materia) }}" class="text-yellow-600 hover:underline mr-2">Editar</a>
                    <form action="{{ route('materias.destroy', $materia) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-4 py-2 text-center text-gray-500">No hay materias.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection