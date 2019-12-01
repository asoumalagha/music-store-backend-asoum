<?php

declare(strict_types=1);


date_default_timezone_set('Europe/Budapest');

require __DIR__ . '/../vendor/autoload.php';

$container = require __DIR__ . '/../app/container.php';

if ($mode === 'development') {
    $container['config'] = require __DIR__ . '/../app/config/dev.php';
} elseif ($mode === 'production') {
    $container['config'] = require __DIR__ . '/../app/config/prod.php';
} else {
    throw new Exception('Something is went wrong with enviroment setup.');
}

return $container;


