@extends('layouts.app')
@section('title', 'Nueva Aula')

@section('content')
<div class="max-w-xl mx-auto bg-white rounded-lg shadow-xl p-6 sm:p-8">

    {{-- INICIO CORRECCIÓN:
         Se quitan los bloques @if($errors->any()) y @if(session('error'))
         para evitar los mensajes duplicados que viste en tus imágenes.
         Tu 'layouts.app' se debe encargar de mostrar estos mensajes.
    --}}
    
    <form action="{{ route('aulas.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- CAMPO 'id_aula' --}}
        <div>
            <label for="id_aula" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fas fa-hashtag w-5 mr-1 text-gray-400"></i>
                ID de Aula (Código Numérico) <span class="text-red-600">*</span>
            </label>
            <input type="number" name="id_aula" id="id_aula" value="{{ old('id_aula') }}"
                   class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 @error('id_aula') border-red-500 @enderror"
                   placeholder="p. ej. 23611" required>
            @error('id_aula')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPO 'tipo' --}}
        <div>
            <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-1">
                <i class="fas fa-tag w-5 mr-1 text-gray-400"></i>
                Tipo <span class="text-red-600">*</span>
            </label>
            <input type="text" name="tipo" id="tipo" value="{{ old('tipo') }}"
                   class="w-full border-gray-300 rounded-md shadow-sm px-3 py-2 @error('tipo') border-red-500 @enderror"
                   maxlength="30" placeholder="p. ej. Laboratorio, Teoría, Auditorio" required>
            @error('tipo')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- BOTONES --}}
        <div class="pt-6 mt-6 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-end gap-3">
            <a href="{{ route('aulas.index') }}"
               class="bg-white border border-gray-300 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-50 text-sm font-medium transition-colors w-full sm:w-auto text-center">
                Cancelar
            </a>
            <button type="submit"
                    class="bg-[var(--blue-primary)] text-white px-5 py-2 rounded-md hover:bg-[var(--blue-hover)] text-sm font-medium transition-colors w-full sm:w-auto">
                Guardar Aula
            </button>
        </div>
    </form>
</div>
@endsection