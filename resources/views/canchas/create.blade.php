@extends('layout')

@section('titulo', 'Nueva Cancha')

@section('contenido')
    <h1 class="titulo">Registrar Nueva Cancha</h1>
    <p class="subtitulo">Agrega una cancha al catálogo</p>

    <form action="{{ route('canchas.store') }}" method="POST" class="formulario">
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
            <label>URL de la imagen</label>
            <input type="url" name="imagen_url" value="{{ old('imagen_url') }}" placeholder="https://ejemplo.com/foto-cancha.jpg">
            <div class="ayuda">Pega el link de una foto de la cancha. Puedes copiar la dirección de una imagen de internet (clic derecho → Copiar dirección de imagen).</div>
        </div>
        <div class="campo">
            <label>Descripción (opcional)</label>
            <textarea name="descripcion" rows="3" placeholder="Césped sintético, iluminación nocturna...">{{ old('descripcion') }}</textarea>
        </div>
        <div class="form-acciones">
            <button type="submit" class="btn">Guardar cancha</button>
            <a href="{{ route('canchas.index') }}" class="btn btn-sec">Cancelar</a>
        </div>
    </form>
@endsection