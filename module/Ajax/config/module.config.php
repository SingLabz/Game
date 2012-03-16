<?php
return array(
    'di'                    => array(
        'instance' => array(
            'alias' => array(
                'auser' => 'Ajax\Controller\IndexController',
            ),
            /*'Album\Controller\AlbumController' => array(
                'parameters' => array(
                    'album' => 'Album\Model\Album'
                ),
            ),
            'Album\Model\Album' => array(
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
                        'dbname' => 'zf2',
                    ),
                ),
            ),*/
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
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
