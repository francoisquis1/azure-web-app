<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'mongodb'),

    'connections' => [

        'mongodb' => [
            'driver'   => 'mongodb',
            'dsn'      => env('MONGODB_URI'),
            'database' => env('MONGODB_DATABASE', 'reservas'),
        ],

        // SQLite local opcional (para sesiones/cache si lo necesitas en pruebas)
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'   => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

    ],

    'migrations' => 'migrations',

];
