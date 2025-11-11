<?php

if (!function_exists('getEstadoTexto')) {
    /**
     * Convierte código de estado a texto legible
     */
    function getEstadoTexto($codigo)
    {
        $estados = [
            'P' => 'Presente',
            'A' => 'Ausente',
            'T' => 'Tardanza',
            'L' => 'Licencia',
        ];
        
        return $estados[$codigo] ?? 'Desconocido';
    }
}

if (!function_exists('getEstadoColor')) {
    /**
     * Devuelve las clases Tailwind para colorear el estado
     */
    function getEstadoColor($codigo)
    {
        $colores = [
            'P' => 'bg-green-100 text-green-800',
            'A' => 'bg-red-100 text-red-800',
            'T' => 'bg-yellow-100 text-yellow-800',
            'L' => 'bg-blue-100 text-blue-800',
        ];
        
        return $colores[$codigo] ?? 'bg-gray-100 text-gray-800';
    }
}