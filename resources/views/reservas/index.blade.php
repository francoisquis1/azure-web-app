@extends('layout')

@section('titulo', 'Mis Reservas')

@section('contenido')
    <h1 class="titulo">Reservas Registradas</h1>
    <p class="subtitulo">Todas las reservas de canchas</p>

    @if($reservas->isEmpty())
        <div class="vacio">
            <div class="icono">📅</div>
            <p>No hay reservas todavía.</p>
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
                        <td>{{ $reserva->nombre_cliente }}<br><small style="color:var(--txt2);">{{ $reserva->telefono }}</small></td>
                        <td>{{ $reserva->fecha }}</td>
                        <td>{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                        <td><span class="estado estado-{{ $reserva->estado }}">{{ ucfirst($reserva->estado) }}</span></td>
                        <td>
                            @if($reserva->estado !== 'cancelada')
                                <form action="{{ route('reservas.cancelar', $reserva->_id) }}" method="POST" style="margin:0;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-rojo" style="padding:.4rem .9rem; font-size:.85rem;">Cancelar</button>
                                </form>
                            @else
                                <span style="color:var(--txt2);">—</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection