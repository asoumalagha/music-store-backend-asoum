<?php

declare(strict_types=1);


return [
    'displayErrorDetails' => false,
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../../log/app.log',
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'prod',
    ]
];
