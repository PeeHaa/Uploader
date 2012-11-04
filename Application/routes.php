<?php

$routes = [
    'index' => [
        'requirements' => [
            'path' => '/^\/?$/',
            'method' => 'get',
        ],
    ],
    'user/login' => [
        'requirements' => [
            'path'   => '/^(\/?login\/?)$/',
            'method' => 'post',
        ],
    ],
    'user/login/popup' => [
        'requirements' => [
            'path'   => '/^(\/?login-popup\/?)$/',
            'method' => 'get',
        ],
    ],
    'user/logout' => [
        'requirements' => [
            'path'   => '/^(\/?logout\/.+\/?)$/',
            'method' => 'get',
        ],
        'mapping' => [
            'csrf-token' => 1,
        ],
    ],
    'upload' => [
        'requirements' => [
            'path' => '/^(\/?upload\/)/',
        ],
    ],
];