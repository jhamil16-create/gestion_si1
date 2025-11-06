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

    /**
     * CORRECCIÓN 1:
     * Le decimos a Laravel que la PK ('id_grupo') NO es un número
     * que se auto-incrementa, sino un String.
     */
    public $incrementing = false;
    protected $keyType = 'string';


    /**
     * CORRECCIÓN 2:
     * Se quita 'id_docente' porque esa columna ya no existe en la tabla 'grupo'.
     */
    // DESPUÉS (Corregido)
    protected $fillable = [
        'id_grupo',  // <--- ¡AGREGA ESTA LÍNEA!
        'nombre',
        'sigla',
        'id_gestion',
    ];

    /**
     * CORRECCIÓN 3 y 4:
     * Renombramos 'docente' a 'docentes' (plural).
     * Un grupo ahora tiene MUCHOS docentes.
     */
    public function docentes()
    {
        return $this->belongsToMany(
            Docente::class,     // Modelo con el que se relaciona
            'docente_grupo',    // Nombre de la tabla pivote
            'id_grupo',         // Llave foránea de Grupo (este modelo)
            'id_docente'        // Llave foránea de Docente (el otro modelo)
        );
    }

    // --- El resto de tus relaciones están perfectas ---

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'sigla', 'sigla');
    }

    public function gestionAcademica()
    {
        return $this->belongsTo(GestionAcademica::class, 'id_gestion', 'id_gestion');
    }

    public function asignacionesHorario()
    {
        return $this->hasMany(AsignacionHorario::class, 'id_grupo', 'id_grupo');
    }
}