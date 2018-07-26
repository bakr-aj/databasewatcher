<?php

return [
    'storage_disk' => [
        'driver' => 'local',
        'root' => storage_path(),
    ],

    'logging_channel' =>  [
        'driver' => 'daily',
        'path' => storage_path('logs/query/laravel.query'),
        'days' => 7,
    ]
];