<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use Illuminate\Http\Request;

class CanchaController extends Controller
{
    // Página principal: muestra todas las canchas disponibles
    public function index()
    {
        $canchas = Cancha::where('activa', true)->get();
        return view('canchas.index', compact('canchas'));
    }

    // Formulario para crear una cancha nueva (panel admin sencillo)
    public function create()
    {
        return view('canchas.create');
    }

    // Guarda la cancha nueva en Cosmos DB
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => 'required|string|max:100',
            'tipo'        => 'required|string|max:50',
            'precio_hora' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $datos['activa'] = true;
        Cancha::create($datos);

        return redirect()->route('canchas.index')
            ->with('exito', 'Cancha registrada correctamente.');
    }
}
