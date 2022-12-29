<?php

use Symfony\Component\HttpFoundation\Response;

ignore_user_abort(true);

require __DIR__ . '/../vendor/autoload.php';

$response404 = new Response('404 Not found', Response::HTTP_NOT_FOUND);

$response404->send();
