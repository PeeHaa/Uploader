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
            'path'   => '#^(/login-popup/?)(/json)?$#',
            'method' => 'get',
            'permissions' => [
                'match' => 'guest',
            ],
        ],
        'mapping' => [
            'json' => 1,
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
    'user/uploads/file/edit' => [
        'requirements' => [
            'path' => '#^(/your-files/(\d+)/edit(/json)?/?)$#',
            'method' => 'get',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'id'   => 1,
            'json' => 3,
        ],
    ],
    'user/uploads/file/edit/update' => [
        'requirements' => [
            'path' => '#^(/your-files/(\d+)/edit(/json)?/?)$#',
            'method' => 'post',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'id'   => 1,
            'json' => 3,
        ],
    ],
    'user/uploads/file/delete' => [
        'requirements' => [
            'path' => '#^(/your-files/(\d+)/delete/(.*)(/json)?/?)$#',
            'method' => 'post',
            'permissions' => [
                'minimum' => 'user',
            ],
        ],
        'mapping' => [
            'id'         => 1,
            'csrf-token' => 3,
            'json'       => 4,
        ],
    ],
];