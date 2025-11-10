@extends('layouts.app')
@section('title', 'Mi Carga Semestral')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- Encabezado --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-700">Reporte de Carga Semestral</h2>
            <p class="text-sm text-gray-600 mt-1">Este es el resumen de la carga horaria para el docente</p>
        </div>
        <div class="px-5 py-4 bg-blue-50 border-t">
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white">
                    <i class="fas fa-user-tie text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ $docente->usuario->nombre ?? 'Docente no encontrado' }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-id-card mr-1"></i>
                        ID: {{ $docente->id_docente }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tarjetas de Resumen --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Total Horas Semanales --}}
        <div class="bg-white sm:rounded-lg shadow-xl border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Total Horas Semanales
                        </h5>
                        <p class="text-3xl font-bold text-gray-800">{{ abs($totalHorasSemana) }}</p>
                        <p class="text-gray-500 text-sm mt-2">
                            <i class="fas fa-clock mr-1"></i>
                            Horas por semana
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-business-time text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Grupos Asignados --}}
        <div class="bg-white sm:rounded-lg shadow-xl border border-gray-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-2">
                            Total Grupos Asignados
                        </h5>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalGrupos }}</p>
                        <p class="text-gray-500 text-sm mt-2">
                            <i class="fas fa-users mr-1"></i>
                            Grupos activos
                        </p>
                    </div>
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Detalle --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-list-ul text-blue-600 mr-2"></i>
                Detalle de Carga (Solo de Gestiones Publicadas)
            </h3>
        </div>

        <div class="p-6">
            @if(count($cargaDetallada) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                                <th class="px-4 py-3 border-b font-semibold">Materia</th>
                                <th class="px-4 py-3 border-b font-semibold">Grupo</th>
                                <th class="px-4 py-3 border-b font-semibold">Gestión</th>
                                <th class="px-4 py-3 border-b text-center font-semibold">Horas/Semana</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($cargaDetallada as $carga)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 border-b">
                                        <div class="font-medium text-gray-800">{{ $carga['materia_nombre'] }}</div>
                                        <div class="text-xs text-gray-500 font-mono">{{ $carga['materia_sigla'] }}</div>
                                    </td>
                                    <td class="px-4 py-3 border-b text-gray-600">{{ $carga['grupo_nombre'] }}</td>
                                    <td class="px-4 py-3 border-b text-gray-600">{{ $carga['gestion_nombre'] }}</td>
                                    <td class="px-4 py-3 border-b">
                                        <div class="flex justify-center">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-md bg-green-100 text-green-800 font-semibold">
                                                <i class="fas fa-clock"></i>
                                                {{ abs($carga['horas_semana']) }} hrs
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-3 py-10 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center">
                        <i class="fas fa-inbox text-4xl mb-3 text-gray-400"></i>
                        <p class="text-lg font-medium mb-2">Sin carga asignada</p>
                        <p class="text-sm text-gray-400">Este docente no tiene carga asignada en las gestiones publicadas actualmente</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection