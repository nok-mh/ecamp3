<?php

return [

    'router' => [
        'routes' => [
            'e-camp-api.rest.doctrine.event-plugin.textarea' => [
                        'type' => 'Segment',
                        'options' => [
                    'route' => '/api/plugin/textarea[/:textarea_id]',
                            'defaults' => [
                                'controller' => \eCamp\Plugin\Textarea\Controller\TextareaController::class
                            ],
                        ],
                    ],
                ],
    ],

    'service_manager' => [
        'factories' => [
            \eCamp\Plugin\Textarea\Strategy::class => \eCamp\Plugin\Textarea\StrategyFactory::class
        ]
    ],

    'zf-rest' => [
        \eCamp\Plugin\Textarea\Controller\TextareaController::class => [
            'listener' => \eCamp\Plugin\Textarea\Service\TextareaService::class,
            'controller_class' => \eCamp\Plugin\Textarea\Controller\TextareaController::class,
            'route_name' => 'e-camp-api.rest.doctrine.event-plugin.textarea',
            'route_identifier_name' => 'textarea_id',
            'entity_identifier_name' => 'id',
            //'collection_name' => 'items',
            'entity_http_methods' => [
                0 => 'GET',
            ],
            'collection_http_methods' => [
                0 => 'GET',
            ],
            'collection_query_whitelist' => [],
            //'page_size' => 25,
            //'page_size_param' => null,
            'entity_class' => \eCamp\Plugin\Textarea\Entity\Textarea::class,
            'collection_class' => \eCamp\Plugin\Textarea\Entity\TextareaCollection::class,
            'service_name' => 'Textarea',
        ],
    ],

    'zf-hal' => [
        'metadata_map' => [
            \eCamp\Plugin\Textarea\Entity\Textarea::class => [
                'route_identifier_name' => 'textarea_id',
                'entity_identifier_name' => 'id',
                'route_name' => 'e-camp-api.rest.doctrine.event-plugin.textarea',
                'route_params' => [
                    'event_plugin_id' => function($object) {
                        return $object->getEventPlugin()->getId();
                    }
                ],
                'hydrator' => eCamp\Plugin\Textarea\Hydrator\TextareaHydrator::class,
                'max_depth' => 2
            ],
            \eCamp\Plugin\Textarea\Entity\TextareaCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'e-camp-api.rest.doctrine.event-plugin/textarea',
                'is_collection' => true,
                'max_depth' => 0
            ],
        ],
    ],

    'doctrine' => [
        'driver' => [
            'ecamp_plugin_textarea_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],

            'orm_default' => [
                'drivers' => [
                    'eCamp\Plugin\Textarea\Entity' => 'ecamp_plugin_textarea_entities'
                ]
            ],
        ],
    ],

];
