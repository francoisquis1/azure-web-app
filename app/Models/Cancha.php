<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Cancha extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'canchas';

    protected $fillable = [
        'nombre',
        'tipo',        // ej: "Fútbol 5", "Fútbol 7", "Fútbol 11"
        'precio_hora',
        'descripcion',
        'activa',
    ];

    protected $casts = [
        'precio_hora' => 'float',
        'activa'      => 'boolean',
    ];

    // Una cancha tiene muchas reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'cancha_id');
    }
}
