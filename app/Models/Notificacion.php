<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'titulo',
        'mensaje',
        'tipo',
        'destinatario',
        'leida',
        'fecha_envio',
        'id_usuario'
    ];

    protected $casts = [
        'leida' => 'boolean',
        'fecha_envio' => 'datetime'
    ];

    /**
     * Obtiene el usuario que creó la notificación.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Scope para filtrar notificaciones no leídas.
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    /**
     * Scope para filtrar por tipo de destinatario.
     */
    public function scopeParaDestinatario($query, $tipo)
    {
        return $query->where('destinatario', $tipo);
    }

    /**
     * Scope para obtener notificaciones recientes.
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('fecha_envio', '>=', now()->subDays($dias));
    }
}