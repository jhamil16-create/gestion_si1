@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-700">Gestión de Usuarios y Roles</h2>
            <a href="#"
               class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 text-sm font-medium transition-colors w-full sm:w-auto text-center">
                <i class="fas fa-plus mr-1"></i>
                Nuevo Usuario
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                        <th class="px-4 py-3 border-b font-semibold">Nombre</th>
                        <th class="px-4 py-3 border-b font-semibold">Email</th>
                        <th class="px-4 py-3 border-b font-semibold">Rol</th>
                        <th class="px-4 py-3 border-b text-center font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-medium text-gray-800">{{ $usuario->nombre }}</td>
                            <td class="px-4 py-3 border-b text-gray-600">{{ $usuario->email }}</td>
                            <td class="px-4 py-3 border-b">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $usuario->administrador ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $usuario->administrador ? 'Administrador' : ($usuario->docente ? 'Docente' : 'Sin rol') }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    <a href="#"
                                       class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors w-full sm:w-auto"
                                       title="Editar usuario">
                                        <i class="fas fa-pen text-white/80"></i> Editar
                                    </a>
                                    <form action="#" method="POST"
                                          class="w-full sm:w-auto"
                                          onsubmit="return confirm('¿Estás seguro de eliminar al usuario {{ $usuario->nombre }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors w-full"
                                                title="Eliminar usuario">
                                            <i class="fas fa-trash text-white/80"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-10 text-center text-gray-500">
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if(isset($usuarios) && method_exists($usuarios, 'links'))
        <div class="px-5 py-4 border-t">
            {{ $usuarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection