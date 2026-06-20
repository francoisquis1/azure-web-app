<?php

namespace Database\Seeders;

use App\Models\Cancha;
use Illuminate\Database\Seeder;

class CanchaSeeder extends Seeder
{
    public function run(): void
    {
        $canchas = [
            [
                'nombre' => 'Cancha El Golazo',
                'tipo' => 'Fútbol 5',
                'precio_hora' => 50.00,
                'descripcion' => 'Césped sintético de última generación, iluminación nocturna LED.',
                'imagen_url' => 'https://images.unsplash.com/photo-1556056504-5c7696c4c28d?w=800&q=80',
                'activa' => true,
            ],
            [
                'nombre' => 'Estadio La Bombonera',
                'tipo' => 'Fútbol 7',
                'precio_hora' => 80.00,
                'descripcion' => 'Cancha techada, vestidores completos y estacionamiento gratuito.',
                'imagen_url' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&q=80',
                'activa' => true,
            ],
            [
                'nombre' => 'Complejo Maracaná',
                'tipo' => 'Fútbol 11',
                'precio_hora' => 150.00,
                'descripcion' => 'Medidas oficiales FIFA, gradería para público y marcador electrónico.',
                'imagen_url' => 'https://images.unsplash.com/photo-1431324155629-1a6deb1dec8d?w=800&q=80',
                'activa' => true,
            ],
        ];

        foreach ($canchas as $cancha) {
            Cancha::create($cancha);
        }
    }
}