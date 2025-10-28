@extends('layouts.app')
@section('title', 'Administradores')
@section('content')
<div class="max-w-6xl mx-auto bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Lista de Administradores</h2>
        <a href="{{ route('administradores.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nuevo Administrador
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2 text-left">ID</th>
                    <th class="border px-4 py-2 text-left">Nombre</th>
                    <th class="border px-4 py-2 text-left">Email</th>
                    <th class="border px-4 py-2 text-left">Teléfono</th>
                    <th class="border px-4 py-2 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($administradores as $administrador)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $administrador->id_administrador }}</td>
                        <td class="border px-4 py-2">{{ $administrador->usuario->nombre }}</td>
                        <td class="border px-4 py-2">{{ $administrador->usuario->email }}</td>
                        <td class="border px-4 py-2">{{ $administrador->usuario->telefono ?? 'N/A' }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('administradores.show', $administrador->id_administrador) }}" 
                                   class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                    Ver
                                </a>
                                <a href="{{ route('administradores.edit', $administrador->id_administrador) }}" 
                                   class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                                    Editar
                                </a>
                                <form action="{{ route('administradores.destroy', $administrador->id_administrador) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('¿Estás seguro de eliminar este administrador?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border px-4 py-8 text-center text-gray-500">
                            No hay administradores registrados. <a href="{{ route('administradores.create') }}" class="text-blue-600 underline">Crear uno nuevo</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection