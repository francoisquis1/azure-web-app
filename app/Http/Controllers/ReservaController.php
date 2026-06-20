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
        $reservas = Reserva::orderBy('fecha', 'desc')->get();
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
            'telefono'       => 'required|string|max:20',
            'fecha'          => 'required|date|after_or_equal:today',
            'hora_inicio'    => 'required|date_format:H:i',
            'hora_fin'       => 'required|date_format:H:i|after:hora_inicio',
        ]);

        // Verificar solapamiento en PHP (más confiable en Cosmos que un query complejo)
        $reservasMismoDia = Reserva::where('cancha_id', $datos['cancha_id'])
            ->where('fecha', $datos['fecha'])
            ->get();

        foreach ($reservasMismoDia as $r) {
            if ($r->estado === 'cancelada') {
                continue;
            }
            // ¿Se cruzan los horarios?
            if ($datos['hora_inicio'] < $r->hora_fin && $datos['hora_fin'] > $r->hora_inicio) {
                return back()->withInput()->withErrors([
                    'horario' => 'Ya existe una reserva en ese horario para esta cancha.',
                ]);
            }
        }

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