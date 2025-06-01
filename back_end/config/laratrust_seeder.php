<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'profile' => 'r,u',
            'users' => 'c,r,u,d',
            'order' => 'c,r,u,d',
            'paymentcollection' => 'c,r,u,d',
            'expense' => 'c,r,u,d',
        ],
        'user' => [
            'profile' => 'r,u',
            'users' => 'r',
            'order' => 'c,r,u,d',
            'paymentcollection' => 'r',
            'expense' => 'c,r,u,d',
        ],


    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],
];
