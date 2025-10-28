<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionHorario extends Model
{
    use HasFactory;

    protected $table = 'asignacion_horario';
    protected $primaryKey = 'id_asignacion';
    public $timestamps = false;

    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_fin',
        'id_aula',
        'id_grupo',
    ];

    /**
     * Obtiene el aula para esta asignación.
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class, 'id_aula', 'id_aula');
    }

    /**
     * Obtiene el grupo para esta asignación.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo', 'id_grupo');
    }

    /**
     * Obtiene todos los registros de asistencia para este horario.
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_asignacion', 'id_asignacion');
    }
}
