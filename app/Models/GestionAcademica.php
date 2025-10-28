<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionAcademica extends Model
{
    use HasFactory;

    protected $table = 'gestion_academica';
    protected $primaryKey = 'id_gestion';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
    ];

    /**
     * Conversión de tipos para los campos.
     */
    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Obtiene los grupos de esta gestión académica.
     */
    public function grupos()
    {
        return $this->hasMany(Grupo::class, 'id_gestion', 'id_gestion');
    }
}
