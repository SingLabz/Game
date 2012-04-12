<?php

return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'index' => 'Game\Controller\IndexController',
                'user' => 'Game\Controller\UserController',
                'error' => 'Game\Controller\ErrorController',
            ),
            'Game\Controller\UserController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User'
                ),
            ),
            'Game\Model\User' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\Unit' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\Building' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\Upgrade' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\Resource' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\Base' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Game\Model\System\Type' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Zend\Db\Adapter\Mysqli' => array(
                'parameters' => array(
                    'config' => array(
                        'host' => 'localhost',
                        'port' => '3306',
                        'username' => 'root',
                        'password' => '',
                        'dbname' => 'game',
                    ),
                ),
            ),
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker' => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),
            // Setup the PhpRenderer
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options' => array(
                        'script_paths' => array(
                            'game' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),
            // Setup for router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'default' => array(
                            'type' => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route' => '/[:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'Game\Controller\IndexController',
                                    'action' => 'index',
                                ),
                            ),
                        ),
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route' => '/',
                                'defaults' => array(
                                    'controller' => 'Game\Controller\IndexController',
                                    'action' => 'index',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            // Defining how the view scripts should be resolved by stacking up
            // a Zend\View\Resolver\TemplateMapResolver and a
            // Zend\View\Resolver\TemplatePathStack
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),
            // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map' => array(
                        'layout/default' => __DIR__ . '/../view/layout/default.phtml',
                        'layout/admin' => __DIR__ . '/../view/layout/admin.phtml',
                        'layout/game' => __DIR__ . '/../view/layout/game.phtml',
                        'layout/login' => __DIR__ . '/../view/layout/login.phtml',
                    ),
                ),
            ),
            // Defining where to look for views. This works with multiple paths,
            // very similar to include_path
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths' => array(
                        'game' => __DIR__ . '/../view',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/default',
                ),
            ),
            // Injecting the router into the url helper
            'Zend\View\Helper\Url' => array(
                'parameters' => array(
                    'router' => 'Zend\Mvc\Router\RouteStack',
                ),
            ),
            // Configuration for the doctype helper
            'Zend\View\Helper\Doctype' => array(
                'parameters' => array(
                    'doctype' => 'HTML5',
                ),
            ),
            // View script rendered in case of 404 exception
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions' => true,
                    'notFoundTemplate' => 'error/404',
                ),
            ),
            // View script rendered in case of other exceptions
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate' => 'error/index',
                ),
            ),
        ),
    ),
);

