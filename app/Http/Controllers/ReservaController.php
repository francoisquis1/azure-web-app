<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    // Lista todas las reservas
    public function index()
    {
        // Cosmos DB requiere índice para orderBy, por eso ordenamos en PHP
        $reservas = Reserva::all()->sortByDesc('fecha')->values();
        foreach ($reservas as $reserva) {
            $reserva->cancha_nombre = optional(
                Cancha::find($reserva->cancha_id)
            )->nombre ?? 'Cancha eliminada';
        }
        return view('reservas.index', compact('reservas'));
    }

    // Formulario para reservar
    public function create(Request $request)
    {
        $canchas = Cancha::where('activa', true)->get();
        $canchaSeleccionada = $request->query('cancha_id');
        return view('reservas.create', compact('canchas', 'canchaSeleccionada'));
    }

    // Guarda la reserva validando que no choque con otra
    public function store(Request $request)
    {
        $datos = $request->validate([
            'cancha_id'      => 'required|string',
            'nombre_cliente' => 'required|string|max:100',
            'email'          => 'required|email|max:150',
            'telefono'       => 'required|string|max:20',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora_inicio'    => 'required|date_format:H:i',
            'duracion'       => 'required|integer|min:30|max:240',
        ]);

        // Calcular la hora de fin sumando la duración (en minutos)
        $inicio = \DateTime::createFromFormat('H:i', $datos['hora_inicio']);
        $fin = (clone $inicio)->modify('+' . $datos['duracion'] . ' minutes');
        $datos['hora_fin'] = $fin->format('H:i');

        // Verificar solapamiento en PHP (más confiable en Cosmos)
        $reservasMismoDia = Reserva::where('cancha_id', $datos['cancha_id'])
            ->where('fecha', $datos['fecha'])
            ->get();

        foreach ($reservasMismoDia as $r) {
            if ($r->estado === 'cancelada') {
                continue;
            }
            if ($datos['hora_inicio'] < $r->hora_fin && $datos['hora_fin'] > $r->hora_inicio) {
                return back()->withInput()->withErrors([
                    'horario' => 'Ya existe una reserva en ese horario para esta cancha.',
                ]);
            }
        }

        // Quitamos 'duracion' porque no es un campo de la reserva
        unset($datos['duracion']);
        $datos['estado'] = 'confirmada';
        Reserva::create($datos);

        return redirect()->route('reservas.index')
            ->with('exito', '¡Reserva confirmada!');
    }

    // Cancelar una reserva
    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect()->route('reservas.index')
            ->with('exito', 'Reserva cancelada.');
    }
}