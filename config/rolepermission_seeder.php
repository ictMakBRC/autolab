<?php

use function Ramsey\Uuid\v1;

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => true,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'Admin' => [
            'create-reception-info',
            'review-reception-info',
            'accession-samples',
            'acknowledge-test-request',
            'enter-results',
            'review-results',
            'approve-results',
            'view-result-reports',
            'view-participant-info',
            'access-settings',
            'manage-users',
            'assign-test-requests',
        ],
    ],

    // 'permissions_map' => [
    //     'c' => 'create',
    //     'r' => 'read',
    //     'u' => 'update',
    //     'd' => 'delete',
    // ],
];