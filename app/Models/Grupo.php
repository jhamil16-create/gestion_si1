<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupo';
    protected $primaryKey = 'id_grupo';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'capacidad',
        'id_docente',
        'sigla',
        'id_gestion',
    ];

    /**
     * Obtiene el docente que imparte este grupo.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'id_docente');
    }

    /**
     * Obtiene la materia a la que pertenece este grupo.
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'sigla', 'sigla');
    }

    /**
     * Obtiene la gestión académica a la que pertenece este grupo.
     */
    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'id_gestion', 'id_gestion');
    }

    /**
     * Obtiene los horarios asignados a este grupo.
     */
    public function asignacionesHorario()
    {
        return $this->hasMany(AsignacionHorario::class, 'id_grupo', 'id_grupo');
    }
}
