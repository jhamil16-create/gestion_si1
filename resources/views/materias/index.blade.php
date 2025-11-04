@extends('layouts.app')
@section('title', 'Materias')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Listado de Materias</h2>
            <a href="{{ route('materias.create') }}"
               class="bg-[var(--blue-primary)] text-white px-4 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nueva Materia
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <th class="px-4 py-3 border-b font-semibold">Sigla</th>
                        <th class="px-4 py-3 border-b font-semibold">Nombre</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse ($materias as $materia)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-mono font-medium text-gray-800">{{ $materia->sigla }}</td>
                            <td class="px-4 py-3 border-b">{{ $materia->nombre }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="{{ route('materias.show', $materia) }}"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-blue-500 text-white hover:bg-blue-600 transition-colors w-full sm:w-auto"
                                       title="Ver detalles">
                                        <i class="fas fa-eye text-white/80"></i> Ver
                                    </a>
                                    <a href="{{ route('materias.edit', $materia) }}"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto"
                                       title="Editar">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="{{ route('materias.destroy', $materia) }}" method="POST"
                                          class="w-full sm:w-auto"
                                          onsubmit="return confirm('¿Estás seguro de eliminar la materia {{ $materia->sigla }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full"
                                                title="Eliminar">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-10 text-center text-gray-500">
                                No hay materias registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection