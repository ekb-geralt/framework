<?php
return [
    'components' => [
        'db' => [
            'className' => \components\Database::class,
            'params' => include 'dbParams.php',
        ],
        'session' => [
            'className' => \components\Session::class,
        ],
        'flashMessages' => [
            'className' => \components\FlashMessages::class,
        ],
        'user' => [
            'className' => \components\User::class,
        ],
        'request' => [
            'className' => \components\Request::class,
        ],
        'urlManager' => [
            'className' => \components\UrlManager::class,
        ],
    ],
];