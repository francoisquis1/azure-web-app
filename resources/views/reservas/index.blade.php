@extends('layout')

@section('titulo', 'Reservas')

@section('contenido')
    <h1>Reservas Registradas</h1>

    @if($reservas->isEmpty())
        <div class="vacio">
            <p>No hay reservas todavía.</p>
            <br>
            <a href="{{ route('reservas.create') }}" class="btn">Hacer una reserva</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Cancha</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->cancha_nombre }}</td>
                        <td>{{ $reserva->nombre_cliente }}<br><small style="color:#64748b;">{{ $reserva->telefono }}</small></td>
                        <td>{{ $reserva->fecha }}</td>
                        <td>{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                        <td>
                            <span class="estado-{{ $reserva->estado }}">{{ ucfirst($reserva->estado) }}</span>
                        </td>
                        <td>
                            @if($reserva->estado !== 'cancelada')
                                <form action="{{ route('reservas.cancelar', $reserva->_id) }}" method="POST" style="background:none; padding:0; border:none;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-rojo" style="padding:.4rem .8rem; font-size:.85rem;">Cancelar</button>
                                </form>
                            @else
                                <span style="color:#64748b;">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
