<?php

return [
    'base_url' => 'http://imob.test',
    'debug' => true,
    'mailer' => [
        'from' => [
            'name' => 'IMOB',
            'address' => 'imob@imob.com.br'
        ],
        'host' => '10.101.40.1',
        'port' => '25',
        'user' => '',
        'password' => '',
        'debug' => false
    ],
    'database' => [
        'host' => 'imob-database',
        'port' => 3306,
        'dbname' => 'imob',
        'user' => 'imob',
        'password' => 'imob123'
    ]
];
