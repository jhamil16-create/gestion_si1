@extends('layouts.app')
@section('title', 'Bienvenido al Sistema Académico')

@section('content')
<div class="max-w-7xl mx-auto py-12">
    {{-- Título y Bienvenida --}}
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Bienvenido al Sistema Académico
        </h1>
        <p class="text-xl text-gray-600">
            Hola, {{ Auth::user()->nombre }}
        </p>
    </div>

    {{-- Accesos Rápidos --}}
    <div class="bg-white rounded-lg shadow">
        <div class="px-5 py-4 border-b">
            <h2 class="text-lg font-semibold">Accesos rápidos</h2>
        </div>

        <div class="p-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
            {{-- Botón Nuevo Docente --}}
            <a href="{{ route('docentes.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-blue-50 hover:border-blue-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-user-plus text-blue-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Nuevo Docente</span>
            </a>

            {{-- Botón Nueva Materia --}}
            <a href="{{ route('materias.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-green-50 hover:border-green-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-square-plus text-green-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Nueva Materia</span>
            </a>

            {{-- Botón Nueva Aula --}}
            <a href="{{ route('aulas.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-yellow-50 hover:border-yellow-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-person-booth text-yellow-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Nueva Aula</span>
            </a>

            {{-- Botón Nuevo Grupo --}}
            <a href="{{ route('grupos.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-purple-50 hover:border-purple-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-people-group text-purple-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Nuevo Grupo</span>
            </a>

            {{-- Botón Gestiones --}}
            <a href="{{ route('gestiones.index') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-red-50 hover:border-red-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-calendar-alt text-red-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Gestiones</span>
            </a>

            {{-- Botón Bitácora --}}
            <a href="{{ route('bitacoras.index') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-gray-200 rounded-lg
                      hover:bg-indigo-50 hover:border-indigo-200 transition-all duration-200 shadow-sm group">
                <i class="fa-solid fa-history text-indigo-500 group-hover:scale-110 transition-transform"></i>
                <span class="font-medium text-gray-700">Bitácora</span>
            </a>
        </div>
    </div>

</div>
@endsection
