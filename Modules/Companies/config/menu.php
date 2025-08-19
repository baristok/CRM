<?php


return [
    'title' => 'companies.title',
    'icon' => 'fa fa-building',
    'route' => 'companies.index',
    'permission' => 'companies.index',
    'order' => 2,
    'permission' => 'companies.index',
    'parent' => 'apps',
    'child' => [
        [
            'title' => 'companies.title',
            'icon' => 'fa fa-building',
            'route' => 'companies.index',
            'permission' => 'companies.index',
            'permission' => 'companies.index',
            'parent' => 'companies',
        ],
        [
            'title' => 'contacts.title',
            'icon' => 'fa fa-users',
            'route' => 'contacts.index',
            'permission' => 'contacts.index',
            'parent' => 'companies',
        ]

        
    ]
];
