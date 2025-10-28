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
}
