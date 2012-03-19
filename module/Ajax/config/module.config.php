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
            // Setup the PhpRenderer
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options'  => array(
                        'script_paths' => array(
                            'ajax' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),
        ),
    )
);
