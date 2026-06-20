@extends('layout')

@section('titulo', 'Reservar Cancha')

@section('contenido')
    <h1 class="titulo">Reservar una Cancha</h1>
    <p class="subtitulo">Completa los datos de tu reserva</p>

    @if($canchas->isEmpty())
        <div class="vacio">
            <div class="icono">🥅</div>
            <p>No hay canchas disponibles para reservar.</p>
        </div>
    @else
        <form action="{{ route('reservas.store') }}" method="POST" class="formulario">
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
                <input type="text" name="nombre_cliente" value="{{ old('nombre_cliente') }}" placeholder="Juan Pérez" required>
            </div>
            <div class="campo">
                <label>Correo (Gmail)</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="tucorreo@gmail.com" required>
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
                <select name="hora_inicio" required>
                    <option value="">-- Selecciona la hora --</option>
                    @for($h = 14; $h < 24; $h++)
                        @foreach(['00', '30'] as $m)
                            @php $hora = sprintf('%02d:%s', $h, $m); @endphp
                            <option value="{{ $hora }}" {{ old('hora_inicio') == $hora ? 'selected' : '' }}>{{ $hora }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>
            <div class="campo">
                <label>Duración</label>
                <select name="duracion" required>
                    <option value="30"  {{ old('duracion') == '30'  ? 'selected' : '' }}>30 minutos</option>
                    <option value="60"  {{ old('duracion', '60') == '60'  ? 'selected' : '' }}>1 hora</option>
                    <option value="90"  {{ old('duracion') == '90'  ? 'selected' : '' }}>1 hora 30 min</option>
                    <option value="120" {{ old('duracion') == '120' ? 'selected' : '' }}>2 horas</option>
                    <option value="150" {{ old('duracion') == '150' ? 'selected' : '' }}>2 horas 30 min</option>
                    <option value="180" {{ old('duracion') == '180' ? 'selected' : '' }}>3 horas</option>
                </select>
            </div>
            <div class="form-acciones">
                <button type="submit" class="btn">Confirmar reserva</button>
                <a href="{{ route('canchas.index') }}" class="btn btn-sec">Cancelar</a>
            </div>
        </form>
    @endif
@endsection