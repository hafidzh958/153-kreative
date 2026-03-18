<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request1 = Illuminate\Http\Request::create('/admin/login', 'GET');
$response1 = $kernel->handle($request1);
echo "GET /admin/login => Status: " . $response1->getStatusCode() . "\n";

$request2 = Illuminate\Http\Request::create('/admin', 'GET');
$response2 = $kernel->handle($request2);
echo "GET /admin => Status: " . $response2->getStatusCode() . "\n";
if ($response2->getStatusCode() == 302) {
    echo "Redirect Location: " . $response2->headers->get('Location') . "\n";
}
