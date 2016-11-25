<?php

require_once __DIR__ . '/../autoload.php';

use ScayTrase\Demo\Forms\AppKernel;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

Debug::enable();

$kernel = new AppKernel('dev', true);

$request  = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
