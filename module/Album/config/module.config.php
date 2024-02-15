<?php

declare(strict_types=1);

namespace Album;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\MeddlController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            // knecht -> name is free to choose
            'knecht' => [
                'type' => Segment::class,
                'options' => [
                    // route is free to choose
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MeddlController::class,
                        /**
                         * In MeddlController exists a method that is called 'testAction'
                         * that gets triggered when hitting this route.
                         */
                        'action' => 'test',
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
];
