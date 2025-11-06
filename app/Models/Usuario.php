<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'email',
        'password',
        'nombre',
        'telefono'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // IMPORTANTE: Cargar relaciones automáticamente
    protected $with = ['administrador', 'docente'];

    // --- RELACIONES ---

    public function docente()
    {
        return $this->hasOne(Docente::class, 'id_usuario', 'id_usuario');
    }

    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'id_usuario', 'id_usuario');
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_usuario', 'id_usuario');
    }

    // --- MÉTODOS OPTIMIZADOS ---

    /**
     * Verifica si el usuario es un Administrador.
     */
    public function isAdmin(): bool
    {
        // Como usamos $with, la relación ya está cargada
        return $this->administrador !== null;
    }

    /**
     * Verifica si el usuario es un Docente.
     */
    public function isDocente(): bool
    {
        return $this->docente !== null;
    }
}