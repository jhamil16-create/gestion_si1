<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aula';
    protected $primaryKey = 'id_aula';
    public $timestamps = false;

    protected $fillable = [
        'capacidad',
        'tipo',
    ];

    /**
     * Obtiene todas las asignaciones de horario para un aula.
     */
    public function asignacionesHorario()
    {
        return $this->hasMany(AsignacionHorario::class, 'id_aula', 'id_aula');
    }
}
