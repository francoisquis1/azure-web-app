<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Reservas de Canchas')</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f172a;
            color: #e2e8f0;
            line-height: 1.6;
        }
        .navbar {
            background: #1e293b;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #22c55e;
        }
        .navbar .logo { font-size: 1.4rem; font-weight: bold; color: #22c55e; }
        .navbar .logo span { color: #e2e8f0; }
        .navbar nav a {
            color: #cbd5e1;
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 500;
            transition: color .2s;
        }
        .navbar nav a:hover { color: #22c55e; }
        .container { max-width: 1000px; margin: 2rem auto; padding: 0 1.5rem; }
        h1 { margin-bottom: 1.5rem; color: #f1f5f9; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.2rem; }
        .card {
            background: #1e293b;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #334155;
            transition: transform .2s, border-color .2s;
        }
        .card:hover { transform: translateY(-4px); border-color: #22c55e; }
        .card h3 { color: #22c55e; margin-bottom: .5rem; }
        .badge {
            display: inline-block;
            background: #334155;
            color: #94a3b8;
            padding: .2rem .7rem;
            border-radius: 20px;
            font-size: .8rem;
            margin: .3rem 0;
        }
        .precio { font-size: 1.5rem; font-weight: bold; color: #f1f5f9; margin: .8rem 0; }
        .btn {
            display: inline-block;
            background: #22c55e;
            color: #0f172a;
            padding: .6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background .2s;
        }
        .btn:hover { background: #16a34a; }
        .btn-sec { background: #334155; color: #e2e8f0; }
        .btn-sec:hover { background: #475569; }
        .btn-rojo { background: #ef4444; color: #fff; }
        .btn-rojo:hover { background: #dc2626; }
        .alerta {
            background: #166534;
            color: #dcfce7;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #22c55e;
        }
        .error {
            background: #7f1d1d;
            color: #fecaca;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #ef4444;
        }
        form { background: #1e293b; padding: 2rem; border-radius: 12px; border: 1px solid #334155; }
        .campo { margin-bottom: 1.2rem; }
        .campo label { display: block; margin-bottom: .4rem; color: #cbd5e1; font-weight: 500; }
        .campo input, .campo select, .campo textarea {
            width: 100%;
            padding: .7rem;
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 8px;
            color: #e2e8f0;
            font-size: 1rem;
        }
        .campo input:focus, .campo select:focus { outline: none; border-color: #22c55e; }
        table { width: 100%; border-collapse: collapse; background: #1e293b; border-radius: 12px; overflow: hidden; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #334155; }
        th { background: #334155; color: #f1f5f9; }
        .estado-confirmada { color: #22c55e; font-weight: 600; }
        .estado-cancelada { color: #ef4444; font-weight: 600; }
        .vacio { text-align: center; padding: 3rem; color: #64748b; }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">⚽ Cancha<span>Ya</span></div>
        <nav>
            <a href="{{ route('canchas.index') }}">Canchas</a>
            <a href="{{ route('reservas.create') }}">Reservar</a>
            <a href="{{ route('reservas.index') }}">Mis Reservas</a>
            <a href="{{ route('canchas.create') }}">+ Cancha</a>
        </nav>
    </div>

    <div class="container">
        @if(session('exito'))
            <div class="alerta">{{ session('exito') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('contenido')
    </div>
</body>
</html>
