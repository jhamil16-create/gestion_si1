@extends('layouts.app')
@section('title', 'Planificar y Publicar Horarios')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Encabezado --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Planificar y Publicar Horarios</h1>
            <p class="text-sm text-gray-600 mt-1">Gestiona la visibilidad de los horarios por semestre</p>
        </div>
    </div>

    {{-- Mensajes de éxito --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Mensajes de error --}}
    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <p class="text-red-800 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    {{-- Card: Gestiones en Borrador --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b bg-gray-50">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-file-alt text-yellow-600 mr-2"></i>
                Gestiones en Borrador (Ocultos)
            </h3>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4">
                Estas gestiones están en estado <strong class="text-yellow-700">"borrador"</strong> y aún no son visibles para los docentes.
            </p>

            @if($gestionesBorrador->isEmpty())
                <div class="flex items-center justify-center py-8 text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-400"></i>
                        <p class="text-lg font-medium">No hay nuevas gestiones en borrador</p>
                    </div>
                </div>
            @else
                {{-- Vista Desktop --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 border-b font-semibold">Gestión</th>
                                <th class="px-4 py-3 border-b text-right font-semibold">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($gestionesBorrador as $gestion)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border-b font-medium text-gray-800 align-middle">
                                    {{ $gestion->nombre }}
                                </td>
                                <td class="px-4 py-3 border-b text-right align-middle">
                                    <form action="{{ route('horarios.publicar.gestion', $gestion) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('¿Estás seguro de que deseas publicar los horarios para {{ $gestion->nombre }}?');">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-xs">
                                            <i class="fas fa-check"></i>
                                            Publicar Ahora
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Vista Mobile --}}
                <div class="sm:hidden space-y-4">
                    @foreach ($gestionesBorrador as $gestion)
                    <div class="bg-white p-4 rounded-lg shadow border border-gray-200">
                        <div class="flex justify-between items-center mb-3 pb-3 border-b">
                            <span class="text-sm font-semibold text-gray-500 uppercase">Gestión</span>
                            <span class="font-medium text-gray-800">{{ $gestion->nombre }}</span>
                        </div>
                        
                        <form action="{{ route('horarios.publicar.gestion', $gestion) }}" 
                              method="POST" 
                              onsubmit="return confirm('¿Estás seguro de que deseas publicar los horarios para {{ $gestion->nombre }}?');">
                            @csrf
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors font-medium text-sm">
                                <i class="fas fa-check"></i>
                                Publicar Ahora
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- Card: Gestiones Publicadas --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b bg-gray-50">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-eye text-green-600 mr-2"></i>
                Gestiones Publicadas (Visibles)
            </h3>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4">
                Estas gestiones ya son visibles para docentes y estudiantes.
            </p>

            @forelse ($gestionesPublicadas as $gestion)
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 border border-gray-200 rounded-lg mb-3 hover:bg-gray-50 transition-colors gap-3">
                    <div class="flex items-center gap-3 flex-1">
                        <span class="font-medium text-gray-800">{{ $gestion->nombre }}</span>
                        <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle"></i>
                            Publicado
                        </span>
                    </div>
                    
                    {{-- Botón de Despublicar --}}
                    <form action="{{ route('horarios.despublicar.gestion', $gestion) }}" 
                          method="POST"
                          onsubmit="return confirm('¿Estás seguro de que deseas ocultar los horarios de {{ $gestion->nombre }}? Los docentes dejarán de verlos.');">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center gap-2 bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition-colors font-medium text-xs w-full sm:w-auto justify-center">
                            <i class="fas fa-eye-slash"></i>
                            Despublicar
                        </button>
                    </form>
                </div>
            @empty
                <div class="flex items-center justify-center py-8 text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-folder-open text-4xl mb-3 text-gray-400"></i>
                        <p class="text-lg font-medium">Aún no hay gestiones publicadas</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection