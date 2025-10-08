<?php

// Load Composer autoload
require __DIR__ . '/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Tangkap request
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Kirim response
$response->send();
$kernel->terminate($request, $response);
