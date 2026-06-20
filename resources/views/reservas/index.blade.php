@extends('layout')

@section('titulo', 'Reservas')

@section('contenido')
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
        <div>
            <h1 class="titulo">Reservas Registradas</h1>
            <p class="subtitulo" style="margin-bottom:0;">
                @if(session('auth_rol') === 'admin')
                    Todas las reservas con datos de contacto
                @else
                    Horarios ocupados de las canchas
                @endif
            </p>
        </div>
        @if(session('auth_rol') === 'admin' && !$reservas->isEmpty())
            <div style="display:flex; gap:.6rem;">
                <a href="{{ route('reservas.csv') }}" class="btn btn-sec">⬇ CSV</a>
                <a href="{{ route('reservas.excel') }}" class="btn btn-sec">⬇ Excel</a>
            </div>
        @endif
    </div>
    <div style="margin-bottom:1.5rem;"></div>

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
                    @if(session('auth_rol') === 'admin')
                        <th>Cliente</th>
                        <th>Contacto</th>
                    @endif
                    <th>Fecha</th>
                    <th>Horario</th>
                    <th>Estado</th>
                    @if(session('auth_rol') === 'admin')
                        <th>Acción</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                    <tr>
                        <td>{{ $reserva->cancha_nombre }}</td>
                        @if(session('auth_rol') === 'admin')
                            <td>{{ $reserva->nombre_cliente }}</td>
                            <td>
                                <small style="color:var(--txt2);">{{ $reserva->email ?? '' }}</small><br>
                                <small style="color:var(--txt2);">{{ $reserva->telefono }}</small>
                            </td>
                        @endif
                        <td>{{ $reserva->fecha }}</td>
                        <td>{{ $reserva->hora_inicio }} - {{ $reserva->hora_fin }}</td>
                        <td><span class="estado estado-{{ $reserva->estado }}">{{ ucfirst($reserva->estado) }}</span></td>
                        @if(session('auth_rol') === 'admin')
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
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection