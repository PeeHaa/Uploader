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
            'permissions' => [
                'match' => 'guest',
            ],
        ],
    ],
    'user/login/popup' => [
        'requirements' => [
            'path'   => '/^(\/?login-popup\/?)$/',
            'method' => 'get',
            'permissions' => [
                'match' => 'guest',
            ],
        ],
    ],
    'user/logout' => [
        'requirements' => [
            'path'   => '/^(\/?logout\/.+\/?)$/',
            'method' => 'get',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'csrf-token' => 1,
        ],
    ],
    'user/settings' => [
        'requirements' => [
            'path'   => '/^(\/?settings\/?)$/',
            'method' => 'get',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
    ],
    'upload' => [
        'requirements' => [
            'path' => '/^(\/?upload\/?)/',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
    ],
];