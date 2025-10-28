<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $table = 'materia';    
    public $incrementing = false;    
    protected $keyType = 'string';    
    public $timestamps = false;
    protected $primaryKey = 'sigla';

    /**
     * Atributos que espera el modelo de Materia en la base de datos.
     */
    protected $fillable = [
        'sigla',
        'nombre',
    ];

    /**
     * Obtiene los grupos asociados a esta materia.
     */
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'sigla', 'sigla');
    }
}
