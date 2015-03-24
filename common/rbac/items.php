<?php
return [
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'children' => [
            'permissions_crud',
            'permissions_view',
            'users_crud',
            'users_view',
            'roles_crud',
            'roles_view',
            'admin_access',
            'user',
        ],
    ],
    'permissions_crud' => [
        'type' => 2,
        'description' => 'CRUD Прав доступа',
    ],
    'permissions_view' => [
        'type' => 2,
        'description' => 'Просмотр прав доступа',
    ],
    'users_crud' => [
        'type' => 2,
        'description' => 'Просмотр списка всех пользователей',
    ],
    'users_view' => [
        'type' => 2,
        'description' => 'Просмотр списка всех пользователей',
    ],
    'roles_crud' => [
        'type' => 2,
        'description' => 'CRUD Ролей',
    ],
    'roles_view' => [
        'type' => 2,
        'description' => 'Просмотр ролей',
    ],
    'user' => [
        'type' => 1,
        'description' => 'Пользователь',
    ],
    'admin_access' => [
        'type' => 2,
        'description' => 'Доступ в админку',
    ],
];
