<?php


declare(strict_types=1);


return [
    'displayErrorDetails' => true,
    'logger' => [
        'name' => 'app',
        'path' => __DIR__ . '/../../log/app.log',
    ],
    'db' => [
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'dbname' => 'music_store_asoum',
    ]
];
