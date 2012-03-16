<?php
return array(
    'di'                    => array(
        'instance' => array(
            'alias' => array(
                'admin-index' => 'Admin\Controller\IndexController',
            ), 
            // Setup the PhpRenderer
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options'  => array(
                        'script_paths' => array(
                            'admin' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
