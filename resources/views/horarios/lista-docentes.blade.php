@extends('layouts.app')
@section('title', 'Consultar Horario de Docente')

@section('content')
<div class="max-w-7xl mx-auto space-y-4">

    {{-- Encabezado --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h2 class="text-xl font-bold text-gray-700">Consultar Horario de Docente</h2>
            <p class="text-sm text-gray-600 mt-1">Selecciona un docente para ver su horario detallado</p>
        </div>
    </div>

    {{-- Listado de Docentes --}}
    <div class="bg-white sm:rounded-lg shadow-xl">
        <div class="px-5 py-4 border-b">
            <h3 class="text-xl font-bold text-gray-700">
                <i class="fas fa-chalkboard-teacher text-blue-600 mr-2"></i>
                Listado de Docentes Registrados
            </h3>
        </div>

        <div class="p-6">
            {{-- Tabla de Docentes --}}
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left text-sm text-gray-600 uppercase tracking-wider">
                            <th class="px-4 py-3 border-b font-semibold">Docente</th>
                            <th class="px-4 py-3 border-b font-semibold">Email</th>
                            <th class="px-4 py-3 border-b text-center font-semibold">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($docentes as $docente)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border-b font-medium text-gray-800">
                                    {{ $docente->usuario->nombre ?? 'Nombre no disponible' }}
                                </td>
                                <td class="px-4 py-3 border-b text-gray-600">
                                    @if($docente->usuario->email ?? false)
                                        <i class="fas fa-envelope mr-1 text-gray-400"></i>
                                        {{ $docente->usuario->email }}
                                    @else
                                        <span class="text-gray-400">Sin email</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 border-b">
                                    <div class="flex justify-center">
                                        <a href="{{ route('horarios.docente', $docente->id_docente) }}"
                                           class="inline-flex items-center justify-center gap-1 px-3 py-1 text-xs rounded-md bg-yellow-500 text-white hover:bg-yellow-600 transition-colors"
                                           title="Ver horario del docente">
                                            <i class="fas fa-calendar-alt text-white/80"></i> Ver Horario
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-3 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-user-slash text-4xl mb-3 text-gray-400"></i>
                                        <p class="text-lg font-medium mb-2">No hay docentes registrados</p>
                                        <p class="text-sm text-gray-400">Agrega docentes desde el módulo de Gestión Académica</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            @if(isset($docentes) && method_exists($docentes, 'links'))
            <div class="px-5 py-4 border-t">
                {{ $docentes->links() }}
            </div>
            @endif
        </div>
    </div>

</div>
@endsection