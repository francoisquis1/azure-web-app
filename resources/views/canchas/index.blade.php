@extends('layout')

@section('titulo', 'Canchas Disponibles')

@section('contenido')
    <h1>Canchas Disponibles</h1>

    @if($canchas->isEmpty())
        <div class="vacio">
            <p>Todavía no hay canchas registradas.</p>
            <br>
            <a href="{{ route('canchas.create') }}" class="btn">Registrar la primera cancha</a>
        </div>
    @else
        <div class="grid">
            @foreach($canchas as $cancha)
                <div class="card">
                    <h3>{{ $cancha->nombre }}</h3>
                    <span class="badge">{{ $cancha->tipo }}</span>
                    <div class="precio">S/ {{ number_format($cancha->precio_hora, 2) }}<small style="font-size:.9rem; color:#64748b;"> /hora</small></div>
                    @if($cancha->descripcion)
                        <p style="color:#94a3b8; margin-bottom:1rem;">{{ $cancha->descripcion }}</p>
                    @endif
                    <a href="{{ route('reservas.create', ['cancha_id' => $cancha->_id]) }}" class="btn">Reservar</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
