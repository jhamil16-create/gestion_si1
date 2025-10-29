@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="bg-white rounded-lg shadow">
        <div class="px-5 py-4 border-b">
            <h2 class="text-lg font-semibold">Accesos rápidos</h2>
        </div>

        <div class="p-5 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('docentes.create') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-user-plus"></i>
                <span>Nuevo Docente</span>
            </a>

            <a href="{{ route('materias.create') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-square-plus"></i>
                <span>Nueva Materia</span>
            </a>

            <a href="{{ route('aulas.create') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-person-booth"></i>
                <span>Nueva Aula</span>
            </a>

            <a href="{{ route('grupos.create') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-people-group"></i>
                <span>Nuevo Grupo</span>
            </a>

            <a href="{{ route('gestiones.index') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-calendar-alt"></i>
                <span>Gestiones</span>
            </a>

            <a href="{{ route('bitacoras.index') }}"
               class="flex items-center gap-2 justify-center bg-white border rounded-lg py-3 px-3 hover:bg-gray-50 transition text-sm">
                <i class="fa-solid fa-history"></i>
                <span>Bitácora</span>
            </a>
        </div>
    </div>

</div>
@endsection
