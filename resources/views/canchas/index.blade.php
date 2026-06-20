@extends('layout')

@section('titulo', 'CanchaYa - Canchas Disponibles')

@section('hero')
<div class="hero">
    <div class="hero-content">
        <h1>Reserva tu <span class="acento">cancha de fútbol</span> en segundos</h1>
        <p>Encuentra la cancha perfecta, elige tu horario y juega. Así de fácil.</p>
        <a href="{{ route('reservas.create') }}" class="btn">⚽ Reservar ahora</a>
    </div>
</div>
@endsection

@section('contenido')
    <h1 class="titulo">Canchas Disponibles</h1>
    <p class="subtitulo">Elige una cancha y reserva tu horario</p>

    @if($canchas->isEmpty())
        <div class="vacio">
            <div class="icono">🥅</div>
            <p>Todavía no hay canchas registradas.</p>
            <a href="{{ route('canchas.create') }}" class="btn">Registrar la primera cancha</a>
        </div>
    @else
        <div class="grid">
            @foreach($canchas as $cancha)
                <div class="card">
                    @if($cancha->imagen_url)
                        <img src="{{ $cancha->imagen_url }}" alt="{{ $cancha->nombre }}" class="card-img"
                             onerror="this.outerHTML='<div class=\'card-img-placeholder\'>⚽</div>'">
                    @else
                        <div class="card-img-placeholder">⚽</div>
                    @endif
                    <div class="card-body">
                        <span class="badge">{{ $cancha->tipo }}</span>
                        <h3>{{ $cancha->nombre }}</h3>
                        <div class="precio">S/ {{ number_format($cancha->precio_hora, 2) }}<small> /hora</small></div>
                        @if($cancha->descripcion)
                            <p class="card-desc">{{ $cancha->descripcion }}</p>
                        @else
                            <p class="card-desc"></p>
                        @endif
                        <a href="{{ route('reservas.create', ['cancha_id' => $cancha->_id]) }}" class="btn btn-block">Reservar esta cancha</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection