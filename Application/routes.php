<?php

$routes = [
    'index/frontpage' => [
        'requirements' => [
            'path' => '#^/?(json)?$#',
            'method' => 'get',
        ],
        'mapping' => [
            'json' => 0,
        ],
    ],
    'user/login' => [
        'requirements' => [
            'path'   => '#^(/login/?)$#',
            'method' => 'post',
            'permissions' => [
                'match' => 'guest',
            ],
        ],
    ],
    'user/login/popup' => [
        'requirements' => [
            'path'   => '#^(/login-popup/?)$#',
            'method' => 'get',
            'permissions' => [
                'match' => 'guest',
            ],
        ],
    ],
    'user/logout' => [
        'requirements' => [
            'path'   => '#^(/logout/.+/?)$#',
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
            'path'   => '#^(/settings\/)$#',
            'method' => 'get',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
    ],
    'upload' => [
        'requirements' => [
            'path' => '#^(/upload/.*/?)$#',
            'method' => 'post',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'filename' => 1,
        ],
    ],
    'user/uploads' => [
        'requirements' => [
            'path' => '#^(/your-files(/json)?/?)$#',
            'method' => 'get',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'json' => 1,
        ],
    ],
];