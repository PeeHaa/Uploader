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
            'path' => '#^(/upload(/.*)?/?)$#',
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
    'download/user' => [
        'requirements' => [
            'path' => '#^(/download/(.*)/(\d+)(/.*)?/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'id' => 2,
        ],
    ],
    'download/id' => [
        'requirements' => [
            'path' => '#^(/download/(\d+)(/.*)?/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'id' => 1,
        ],
    ],
    'download/password/verify/password' => [
        'requirements' => [
            'path' => '#^(/download/verify/(\d+)(/password)(/json)?/?)$#',
            'method' => 'post',
        ],
        'mapping' => [
            'id' => 2,
            'json' => 4,
        ],
    ],
    'download/password/verify/login' => [
        'requirements' => [
            'path' => '#^(/download/verify/(\d+)(/login)(/json)?/?)$#',
            'method' => 'post',
        ],
        'mapping' => [
            'id' => 2,
            'json' => 4,
        ],
    ],
    'download/file' => [
        'requirements' => [
            'path' => '#^(/download-file/(\d+)/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'id' => 1,
        ],
    ],
    'pages/about' => [
        'requirements' => [
            'path' => '#^(/about(/json)?/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'json' => 1,
        ],
    ],
    'pages/tos' => [
        'requirements' => [
            'path' => '#^(/terms-of-service(/json)?/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'json' => 1,
        ],
    ],
    'pages/privacy' => [
        'requirements' => [
            'path' => '#^(/privacy(/json)?/?)$#',
            'method' => 'get',
        ],
        'mapping' => [
            'json' => 1,
        ],
    ],
];