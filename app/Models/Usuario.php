<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'usuario';

    /**
     * La llave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_usuario';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'nombre',
        'telefono'
    ];

    /**
     * Los atributos que deben ocultarse para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        // 'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    // --- RELACIONES ---

    /**
     * Obtiene el registro 'docente' asociado con el usuario.
     * (Un usuario PUEDE SER un docente)
     */
    public function docente()
    {
        return $this->hasOne(Docente::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene el registro 'administrador' asociado con el usuario.
     * (Un usuario PUEDE SER un administrador)
     */
    public function administrador()
    {
        return $this->hasOne(Administrador::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtiene los registros de bitácora del usuario.
     */
    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_usuario', 'id_usuario');
    }

    // --- MÉTODOS HELPER (La nueva forma de revisar roles) ---

    /**
     * Verifica si el usuario es un Administrador.
     */
    public function isAdmin(): bool
    {
        // Revisa si la relación 'administrador' existe y no es nula.
        return $this->administrador()->exists();
    }

    /**
     * Verifica si el usuario es un Docente.
     */
    public function isDocente(): bool
    {
        // Revisa si la relación 'docente' existe y no es nula.
        return $this->docente()->exists();
    }
}
