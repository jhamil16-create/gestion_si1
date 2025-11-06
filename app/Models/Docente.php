<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docente';
    protected $primaryKey = 'id_docente';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * CORRECCIÓN:
     * Un docente ahora puede pertenecer a MUCHOS grupos
     * a través de la tabla 'docente_grupo'.
     */
    public function grupos()
    {
        return $this->belongsToMany(
            Grupo::class,       // Modelo con el que se relaciona
            'docente_grupo',    // Nombre de la tabla pivote
            'id_docente',       // Llave foránea de Docente (este modelo)
            'id_grupo'          // Llave foránea de Grupo (el otro modelo)
        );
    }
}