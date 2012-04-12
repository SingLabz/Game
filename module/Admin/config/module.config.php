<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'admin-index'       => 'Admin\Controller\IndexController',
                'admin-user'        => 'Admin\Controller\UserController',
                'admin-building'    => 'Admin\Controller\BuildingController',
                'admin-base'        => 'Admin\Controller\BaseController',
                'admin-unit'        => 'Admin\Controller\UnitController',
                'admin-upgrade'     => 'Admin\Controller\UpgradeController',
                'admin-resource'    => 'Admin\Controller\ResourceController',
            ), 
            'Admin\Form\UpgradeForm' => array(
                'parameters' => array(
                    'type' => 'Game\Model\System\Type',
                ),
            ),
            'Admin\Controller\IndexController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                ),
            ),
            'Admin\Controller\UserController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                ),
            ),
            'Admin\Controller\BuildingController' => array(
                'parameters' => array(
                    'user'      => 'Game\Model\User',
                    'building'  => 'Game\Model\Building',
                ),
            ),
            'Admin\Controller\BaseController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                    'base' => 'Game\Model\Base',
                ),
            ),
            'Admin\Controller\UnitController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                    'unit' => 'Game\Model\Unit',
                ),
            ),
            'Admin\Controller\UpgradeController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                    'upgrade' => 'Game\Model\Upgrade',
                ),
            ),
            'Admin\Controller\ResourceController' => array(
                'parameters' => array(
                    'user' => 'Game\Model\User',
                    'resource' => 'Game\Model\Resource',
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
