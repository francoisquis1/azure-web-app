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

        unset($datos['duracion']);
        $datos['estado'] = 'confirmada';
        Reserva::create($datos);

        return redirect()->route('reservas.index')
            ->with('exito', '¡Reserva confirmada!');
    }

    // Cancelar una reserva (solo admin)
    public function cancelar($id)
    {
        $reserva = Reserva::findOrFail($id);
        $reserva->estado = 'cancelada';
        $reserva->save();

        return redirect()->route('reservas.index')
            ->with('exito', 'Reserva cancelada.');
    }

    // Devuelve las reservas con el nombre de cancha resuelto (helper para exportar)
    private function reservasParaExportar()
    {
        $reservas = Reserva::all()->sortByDesc('fecha')->values();
        $filas = [];
        foreach ($reservas as $r) {
            $cancha = optional(Cancha::find($r->cancha_id))->nombre ?? 'Cancha eliminada';
            $filas[] = [
                'Cancha'      => $cancha,
                'Cliente'     => $r->nombre_cliente,
                'Email'       => $r->email ?? '',
                'Telefono'    => $r->telefono,
                'Fecha'       => $r->fecha,
                'HoraInicio'  => $r->hora_inicio,
                'HoraFin'     => $r->hora_fin,
                'Estado'      => $r->estado,
            ];
        }
        return $filas;
    }

    // Exportar a CSV (solo admin)
    public function exportarCsv()
    {
        $filas = $this->reservasParaExportar();
        $nombreArchivo = 'reservas_' . date('Y-m-d') . '.csv';

        $callback = function () use ($filas) {
            $salida = fopen('php://output', 'w');
            // BOM para que Excel abra bien los acentos
            fprintf($salida, chr(0xEF).chr(0xBB).chr(0xBF));
            if (!empty($filas)) {
                fputcsv($salida, array_keys($filas[0]));
                foreach ($filas as $fila) {
                    fputcsv($salida, $fila);
                }
            } else {
                fputcsv($salida, ['No hay reservas']);
            }
            fclose($salida);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
        ]);
    }

    // Exportar a Excel (solo admin)
    public function exportarExcel()
    {
        $filas = $this->reservasParaExportar();
        $nombreArchivo = 'reservas_' . date('Y-m-d') . '.xls';

        $html  = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><head><meta charset="UTF-8"></head><body>';
        $html .= '<table border="1">';
        if (!empty($filas)) {
            $html .= '<tr>';
            foreach (array_keys($filas[0]) as $col) {
                $html .= '<th>' . htmlspecialchars($col) . '</th>';
            }
            $html .= '</tr>';
            foreach ($filas as $fila) {
                $html .= '<tr>';
                foreach ($fila as $valor) {
                    $html .= '<td>' . htmlspecialchars($valor) . '</td>';
                }
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td>No hay reservas</td></tr>';
        }
        $html .= '</table></body></html>';

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
        ]);
    }
}