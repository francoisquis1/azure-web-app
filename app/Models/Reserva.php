<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Reserva extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reservas';

    protected $fillable = [
        'cancha_id',
        'nombre_cliente',
        'telefono',
        'fecha',         // formato Y-m-d
        'hora_inicio',   // formato H:i
        'hora_fin',      // formato H:i
        'estado',        // "confirmada" | "pendiente" | "cancelada"
    ];

    // Cada reserva pertenece a una cancha
    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'cancha_id');
    }
}
