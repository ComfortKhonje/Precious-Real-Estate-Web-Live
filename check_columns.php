<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Schema;

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$columns = Schema::getColumnListing('properties');
echo json_encode($columns, JSON_PRETTY_PRINT);
