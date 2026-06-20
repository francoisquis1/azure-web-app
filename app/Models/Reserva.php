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
        'email',
        'telefono',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'cancha_id');
    }
}