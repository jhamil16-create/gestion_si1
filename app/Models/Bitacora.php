<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $table = 'bitacora';
    protected $primaryKey = 'id_bitacora';
    
    const CREATED_AT = 'fecha_hora';
    // Deshabilita 'updated_at'
    const UPDATED_AT = null;

    protected $fillable = [
        'descripcion',
        'ip_origen',
        'id_usuario',
    ];
    
    /**
     * Conversión de tipos para los campos.
     */
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    /**
     * Obtiene el usuario que realizó la acción en la bitácora.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
