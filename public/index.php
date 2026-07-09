<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Maintenance mode check
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

// App bootstrap kora hocche ei jaigay
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());