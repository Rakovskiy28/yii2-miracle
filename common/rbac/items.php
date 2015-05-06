<?php
return [
    'admin' => [
        'type' => 1,
        'description' => 'Администратор',
        'ruleName' => 'Author',
        'children' => [
            'permissions_crud',
            'permissions_view',
            'users_crud',
            'roles_crud',
            'roles_view',
            'admin_access',
            'rules_crud',
            'rules_view',
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
        'description' => 'CRUD Пользователей',
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
        'ruleName' => 'Author',
    ],
    'admin_access' => [
        'type' => 2,
        'description' => 'Доступ в админку',
    ],
    'rules_crud' => [
        'type' => 2,
        'description' => 'CRUD правил доступа',
    ],
    'rules_view' => [
        'type' => 2,
        'description' => 'Просмотр правил доступа',
    ],
];
