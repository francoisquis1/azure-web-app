<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'CanchaYa - Reserva tu cancha')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --verde: #22c55e;
            --verde-osc: #16a34a;
            --bg: #0a0f1c;
            --bg2: #111827;
            --card: #1a2235;
            --borde: #2a3650;
            --txt: #e2e8f0;
            --txt2: #94a3b8;
        }
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg);
            color: var(--txt);
            line-height: 1.6;
            min-height: 100vh;
        }
        .navbar {
            background: rgba(17,24,39,0.85);
            backdrop-filter: blur(12px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--borde);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar .logo { font-size: 1.5rem; font-weight: 800; color: var(--verde); display:flex; align-items:center; gap:.4rem; }
        .navbar .logo span { color: var(--txt); }
        .navbar nav { display: flex; gap: .5rem; flex-wrap: wrap; }
        .navbar nav a {
            color: var(--txt2);
            text-decoration: none;
            padding: .5rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: .95rem;
            transition: all .2s;
        }
        .navbar nav a:hover { color: var(--txt); background: var(--card); }
        .navbar nav a.cta { background: var(--verde); color: #06210f; font-weight: 600; }
        .navbar nav a.cta:hover { background: var(--verde-osc); color:#fff; }

        .hero {
            background: linear-gradient(135deg, rgba(34,197,94,0.12), rgba(10,15,28,0)), 
                        url('https://images.unsplash.com/photo-1556056504-5c7696c4c28d?w=1600&q=80') center/cover;
            padding: 4rem 2rem;
            text-align: center;
            border-bottom: 1px solid var(--borde);
            position: relative;
        }
        .hero::after { content:''; position:absolute; inset:0; background:linear-gradient(to bottom, rgba(10,15,28,0.5), var(--bg)); }
        .hero-content { position: relative; z-index: 2; max-width: 700px; margin: 0 auto; }
        .hero h1 { font-size: 2.8rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.15; }
        .hero h1 .acento { color: var(--verde); }
        .hero p { font-size: 1.15rem; color: var(--txt2); margin-bottom: 2rem; }
        .hero .btn { font-size: 1.05rem; padding: .85rem 2rem; }

        .container { max-width: 1100px; margin: 2.5rem auto; padding: 0 1.5rem; }
        h1.titulo { margin-bottom: .5rem; font-size: 2rem; font-weight: 700; }
        .subtitulo { color: var(--txt2); margin-bottom: 2rem; }

        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; }
        .card {
            background: var(--card);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid var(--borde);
            transition: transform .25s, border-color .25s, box-shadow .25s;
            display: flex;
            flex-direction: column;
        }
        .card:hover { transform: translateY(-6px); border-color: var(--verde); box-shadow: 0 12px 30px rgba(0,0,0,0.4); }
        .card-img { width: 100%; height: 190px; object-fit: cover; background: var(--bg2); }
        .card-img-placeholder {
            width: 100%; height: 190px;
            background: linear-gradient(135deg, #1e293b, #334155);
            display: flex; align-items: center; justify-content: center;
            font-size: 3rem;
        }
        .card-body { padding: 1.3rem; flex: 1; display: flex; flex-direction: column; }
        .card-body h3 { color: var(--txt); margin-bottom: .4rem; font-size: 1.25rem; font-weight: 600; }
        .badge {
            display: inline-block;
            background: rgba(34,197,94,0.15);
            color: var(--verde);
            padding: .25rem .8rem;
            border-radius: 20px;
            font-size: .8rem;
            font-weight: 600;
            margin-bottom: .6rem;
            align-self: flex-start;
        }
        .precio { font-size: 1.6rem; font-weight: 700; color: var(--txt); margin: .5rem 0; }
        .precio small { font-size: .85rem; color: var(--txt2); font-weight: 400; }
        .card-desc { color: var(--txt2); font-size: .92rem; margin-bottom: 1.2rem; flex: 1; }

        .btn {
            display: inline-block;
            background: var(--verde);
            color: #06210f;
            padding: .7rem 1.3rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: .98rem;
            font-family: inherit;
            transition: all .2s;
            text-align: center;
        }
        .btn:hover { background: var(--verde-osc); color:#fff; transform: translateY(-1px); }
        .btn-sec { background: var(--card); color: var(--txt); border: 1px solid var(--borde); }
        .btn-sec:hover { background: var(--bg2); color: var(--txt); }
        .btn-rojo { background: #ef4444; color: #fff; }
        .btn-rojo:hover { background: #dc2626; }
        .btn-block { width: 100%; }

        .alerta {
            background: rgba(22,101,52,0.3);
            color: #dcfce7;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--verde);
            font-weight: 500;
        }
        .error {
            background: rgba(127,29,29,0.3);
            color: #fecaca;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #ef4444;
        }

        form.formulario { background: var(--card); padding: 2rem; border-radius: 16px; border: 1px solid var(--borde); max-width: 600px; }
        .campo { margin-bottom: 1.3rem; }
        .campo label { display: block; margin-bottom: .5rem; color: var(--txt); font-weight: 500; font-size: .95rem; }
        .campo input, .campo select, .campo textarea {
            width: 100%;
            padding: .8rem 1rem;
            background: var(--bg);
            border: 1px solid var(--borde);
            border-radius: 10px;
            color: var(--txt);
            font-size: 1rem;
            font-family: inherit;
            transition: border-color .2s;
        }
        .campo input:focus, .campo select:focus, .campo textarea:focus { outline: none; border-color: var(--verde); }
        .campo .ayuda { font-size: .82rem; color: var(--txt2); margin-top: .35rem; }
        .form-acciones { display: flex; gap: .8rem; margin-top: 1.5rem; }

        table { width: 100%; border-collapse: collapse; background: var(--card); border-radius: 16px; overflow: hidden; border: 1px solid var(--borde); }
        th, td { padding: 1rem 1.2rem; text-align: left; border-bottom: 1px solid var(--borde); }
        th { background: var(--bg2); color: var(--txt); font-weight: 600; font-size: .9rem; text-transform: uppercase; letter-spacing: .03em; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(255,255,255,0.02); }
        .estado { padding: .25rem .7rem; border-radius: 20px; font-size: .82rem; font-weight: 600; }
        .estado-confirmada { background: rgba(34,197,94,0.15); color: var(--verde); }
        .estado-cancelada { background: rgba(239,68,68,0.15); color: #f87171; }
        .estado-pendiente { background: rgba(234,179,8,0.15); color: #facc15; }

        .vacio { text-align: center; padding: 4rem 2rem; color: var(--txt2); background: var(--card); border-radius: 16px; border: 1px dashed var(--borde); }
        .vacio .icono { font-size: 3.5rem; margin-bottom: 1rem; }
        .vacio p { margin-bottom: 1.5rem; font-size: 1.05rem; }

        footer { text-align: center; padding: 2rem; color: var(--txt2); font-size: .9rem; border-top: 1px solid var(--borde); margin-top: 3rem; }

        @media (max-width: 600px) {
            .hero h1 { font-size: 2rem; }
            .navbar { padding: 1rem; }
            .form-acciones { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">⚽ Cancha<span>Ya</span></div>
        <nav>
            <a href="{{ route('canchas.index') }}">Canchas</a>
            <a href="{{ route('reservas.create') }}">Reservar</a>
            <a href="{{ route('reservas.index') }}">Mis Reservas</a>
            <a href="{{ route('canchas.create') }}" class="cta">+ Nueva cancha</a>
        </nav>
    </div>

    @yield('hero')

    <div class="container">
        @if(session('exito'))
            <div class="alerta">✅ {{ session('exito') }}</div>
        @endif

        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        @yield('contenido')
    </div>

    <footer>
        ⚽ CanchaYa — Reserva tu cancha de fútbol en segundos · Hecho con Laravel + Azure
    </footer>
</body>
</html>