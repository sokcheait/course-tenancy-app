<?php 

return [
    'permissions' => [

        'admin' => [
            'dashboards' => [
                'dashboard' => "View",
            ],
            'domains' => [
                'domains.index' => "View",
                'domains.create' => "create",
                'domains.edit' => "Edit",
                'domains.destroy' => "Destroy"
            ],
            'users' => [
                'users.index' => "View",
                'users.create' => "create",
                'users.edit' => "Edit",
                'users.destroy' => "Destroy"
            ],
            'roles' => [
                'roles.index' => "View",
                'roles.create' => "create",
                'roles.edit' => "Edit",
                'roles.destroy' => "Destroy"
            ],
            'countries' => [
                'countries.index' => "View",
            ],
            'states' => [
                'states.index' => "View",
            ],
        ],

        'client' => [
            'dashboards' => [
                'dashboard' => "View",
            ],
        ]

    ]
];