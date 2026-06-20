@extends('layout')

@section('titulo', 'Reservar Cancha')

@section('contenido')
    <h1>Reservar una Cancha</h1>

    @if($canchas->isEmpty())
        <div class="vacio">
            <p>No hay canchas disponibles para reservar.</p>
            <br>
            <a href="{{ route('canchas.create') }}" class="btn">Registrar una cancha primero</a>
        </div>
    @else
        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf
            <div class="campo">
                <label>Cancha</label>
                <select name="cancha_id" required>
                    <option value="">-- Selecciona una cancha --</option>
                    @foreach($canchas as $cancha)
                        <option value="{{ $cancha->_id }}"
                            {{ (old('cancha_id', $canchaSeleccionada) == $cancha->_id) ? 'selected' : '' }}>
                            {{ $cancha->nombre }} ({{ $cancha->tipo }}) - S/ {{ number_format($cancha->precio_hora, 2) }}/h
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="campo">
                <label>Tu nombre</label>
                <input type="text" name="nombre_cliente" value="{{ old('nombre_cliente') }}" required>
            </div>
            <div class="campo">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="999 888 777" required>
            </div>
            <div class="campo">
                <label>Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" required>
            </div>
            <div class="campo">
                <label>Hora de inicio</label>
                <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}" required>
            </div>
            <div class="campo">
                <label>Hora de fin</label>
                <input type="time" name="hora_fin" value="{{ old('hora_fin') }}" required>
            </div>
            <button type="submit" class="btn">Confirmar reserva</button>
            <a href="{{ route('canchas.index') }}" class="btn btn-sec">Cancelar</a>
        </form>
    @endif
@endsection
