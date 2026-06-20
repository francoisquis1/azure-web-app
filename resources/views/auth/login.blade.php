@extends('layout')

@section('titulo', 'Iniciar Sesión')

@section('contenido')
    <h1 class="titulo">Iniciar Sesión</h1>
    <p class="subtitulo">Accede como administrador para gestionar canchas y reservas</p>

    <form action="{{ route('login.post') }}" method="POST" class="formulario" style="max-width:420px;">
        @csrf
        <div class="campo">
            <label>Usuario</label>
            <input type="text" name="usuario" value="{{ old('usuario') }}" placeholder="admin123" required autofocus>
        </div>
        <div class="campo">
            <label>Contraseña</label>
            <input type="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="form-acciones">
            <button type="submit" class="btn btn-block">Entrar</button>
        </div>
        <p style="margin-top:1.2rem; color:var(--txt2); font-size:.88rem; text-align:center;">
            El acceso es opcional. Puedes reservar canchas sin iniciar sesión.
        </p>
    </form>
@endsection