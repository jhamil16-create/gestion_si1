<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencia';
    protected $primaryKey = 'id_asistencia';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'estado',
        'observaciones',
        'id_asignacion',
        'hora_entrada',    // ← AGREGAR ESTO
        'hora_salida',     // ← AGREGAR ESTO
    ];

    /**
     * Conversión de tipos para los campos.
     */
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Obtiene la asignación de horario a la que pertenece esta asistencia.
     */
    public function asignacionHorario()
    {
        return $this->belongsTo(AsignacionHorario::class, 'id_asignacion', 'id_asignacion');
    }

    /**
     * Convierte el código de estado a texto legible
     */
    public function getEstadoTextAttribute()
    {
        $estados = [
            'P' => 'Presente',
            'A' => 'Ausente',      // Cambiado de 'F' a 'A'
            'T' => 'Tardanza',     // AGREGADO
            'L' => 'Licencia',
        ];
        
        return $estados[$this->estado] ?? 'Desconocido';
    }

    /**
     * Devuelve el color del estado para mostrar en badge
     */
    public function getEstadoColorAttribute()
    {
        $colores = [
            'P' => 'bg-green-100 text-green-800',
            'A' => 'bg-red-100 text-red-800',      // Cambiado de 'F' a 'A'
            'T' => 'bg-yellow-100 text-yellow-800', // AGREGADO
            'L' => 'bg-blue-100 text-blue-800',
        ];
        
        return $colores[$this->estado] ?? 'bg-gray-100 text-gray-800';
    }
}