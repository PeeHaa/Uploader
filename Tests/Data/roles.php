<?php

$roles = [
    'nobody' => [
        'accesslevel' => 0,
    ],
    'guest' => [
        'accesslevel' => 1,
    ],
    'user' => [
        'accesslevel' => 50,
    ],
    'admin' => [
        'accesslevel' => 99,
    ],
];

return $roles;