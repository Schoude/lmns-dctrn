<?php

declare(strict_types=1);

namespace Album;

use Laminas\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\AlbumController::class => Controller\Factory\AlbumControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\AlbumManager::class => Service\Factory\AlbumManagerFactory::class,
        ]
    ],
    'router' => [
        'routes' => [
            'album' => [
                'type' => Segment::class,
                'options' => [
                    // route is free to choose
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],
    'doctrine' => [
        'driver' => [
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            __NAMESPACE__ . '_driver' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ],
            ],

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => [
                'drivers' => [
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ],
            ],
        ],
    ],
];
