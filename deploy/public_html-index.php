<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__ . '/../precious-real-estate-web/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__ . '/../precious-real-estate-web/vendor/autoload.php';

$app = require_once __DIR__ . '/../precious-real-estate-web/bootstrap/app.php';

$app->handleRequest(Request::capture());
