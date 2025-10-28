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

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'id_usuario',
        // Aquí irían otros campos específicos de docente si los tuviera
    ];

    /**
     * Obtiene el 'usuario' base al que pertenece este docente.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene los grupos asignados a este docente.
     */
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_docente', 'id_docente');
    }
}
