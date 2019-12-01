<?php

use Slim\App;

$mode='development';

$container = require __DIR__ . '/../app/bootstrap.php';

$app=$container[App::class];

require __DIR__ . '/../app/routing.php';

$app->run();


