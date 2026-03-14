<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Registrar el autoloader de Composer
require __DIR__.'/../vendor/autoload.php';

// Inicializar la aplicación
$app = require_once __DIR__.'/../bootstrap/app.php';

// Obtener el Kernel HTTP de la instancia de la aplicación
$kernel = $app->make(Kernel::class);

// Manejar la petición a través del Kernel
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
