<?php

namespace SitesAdmin;

return array(
    'controllers' => array(
        'invokables' => array(
            'AdminSitesController'         => 'SitesAdmin\Controller\AdminSitesController',
            'AdminSitesPagesController'    => 'SitesAdmin\Controller\AdminSitesPagesController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'adminsites' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sites-url[/:action][/page/:page][/order_by/:order_by][/:order][/:id]',
                    'constraints'  => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page'     => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order'    => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'AdminSitesController',
                        'action'     => 'index',
                    ),
                ),
            ),
            'adminsitespages' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin-sites-pages[/:action][/id/:id]',
                    'constraints'  => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AdminSitesPagesController',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'SitesAdmin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'psychic-reading-request-paginator-slider'   => __DIR__ . '/../view/layout/readingRequestsPaginator.phtml',
            'site-url-paginator-slider'                  => __DIR__ . '/../view/layout/siteUrlPaginator.phtml'
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ), 
    ),
    'module_layouts' => array(
        'SitesAdmin' => 'layout/mainsite'
    ), 
    
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    )
);
