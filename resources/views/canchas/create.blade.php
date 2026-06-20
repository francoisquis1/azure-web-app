@extends('layout')

@section('titulo', 'Nueva Cancha')

@section('contenido')
    <h1>Registrar Nueva Cancha</h1>

    <form action="{{ route('canchas.store') }}" method="POST">
        @csrf
        <div class="campo">
            <label>Nombre de la cancha</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" placeholder="Ej: Cancha El Golazo" required>
        </div>
        <div class="campo">
            <label>Tipo</label>
            <select name="tipo" required>
                <option value="Fútbol 5">Fútbol 5</option>
                <option value="Fútbol 7">Fútbol 7</option>
                <option value="Fútbol 11">Fútbol 11</option>
            </select>
        </div>
        <div class="campo">
            <label>Precio por hora (S/)</label>
            <input type="number" step="0.01" name="precio_hora" value="{{ old('precio_hora') }}" placeholder="50.00" required>
        </div>
        <div class="campo">
            <label>Descripción (opcional)</label>
            <textarea name="descripcion" rows="3" placeholder="Césped sintético, iluminación nocturna...">{{ old('descripcion') }}</textarea>
        </div>
        <button type="submit" class="btn">Guardar cancha</button>
        <a href="{{ route('canchas.index') }}" class="btn btn-sec">Cancelar</a>
    </form>
@endsection
