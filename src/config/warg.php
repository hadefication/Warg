<?php

return [

    'user' => App\User::class,

    'middleware' => 'auth',

    'redirect' => [
        'route' => null,
        'uri' => '/home'
    ]
    
];
