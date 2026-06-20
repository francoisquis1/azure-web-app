<?php

namespace Database\Seeders;

use App\Models\Cancha;
use Illuminate\Database\Seeder;

class CanchaSeeder extends Seeder
{
    public function run(): void
    {
        $canchas = [
            ['nombre' => 'Cancha El Golazo',   'tipo' => 'Fútbol 5',  'precio_hora' => 50.00, 'descripcion' => 'Césped sintético, iluminación nocturna.', 'activa' => true],
            ['nombre' => 'Estadio La Bombonera','tipo' => 'Fútbol 7',  'precio_hora' => 80.00, 'descripcion' => 'Techada, vestidores y estacionamiento.',   'activa' => true],
            ['nombre' => 'Complejo Maracaná',   'tipo' => 'Fútbol 11', 'precio_hora' => 150.00,'descripcion' => 'Medidas oficiales, gradería para público.', 'activa' => true],
        ];

        foreach ($canchas as $cancha) {
            Cancha::create($cancha);
        }
    }
}
