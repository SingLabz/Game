<?php
return array(
    //'layout'                => 'layout/json.phtml',
    'di'                    => array(
        'instance' => array(
            'alias' => array(
                'ajax-user' => 'Ajax\Controller\UserController',
            ),  
            'Ajax\Controller\UserController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User'
                ),
            ),
            'Game\Model\User' => array(
                'parameters' => array(
                    'config' => 'Zend\Db\Adapter\Mysqli'
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths' => array(
                        'ajax' => __DIR__ . '/../view',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/json',
                ),
            ),

        ),
    )
);
