<?php
return array(
    'di'                    => array(
        'instance' => array(
            'alias' => array(
                'admin-index'   => 'Admin\Controller\IndexController',
                'admin-user'    => 'Admin\Controller\UserController',
            ), 
            'Admin\Controller\IndexController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User'
                ),
            ),
            'Admin\Controller\UserController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User'
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths' => array(
                        'admin' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
