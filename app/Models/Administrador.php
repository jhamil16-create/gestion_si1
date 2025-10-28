<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administrador';
    protected $primaryKey = 'id_administrador';

    public $timestamps = false;

    /**
     * Atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'id_usuario',
        // Aquí irían otros campos específicos de admin si los tuvieras
        // Pero no los hay por el modelo de papi jhamil
    ];

    /**
     * Obtiene el 'usuario' base al que pertenece este administrador.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
