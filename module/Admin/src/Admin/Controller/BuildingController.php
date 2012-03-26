<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Building;

class BuildingController extends ActionController
{
    protected $user;
    protected $building;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setBuilding(Building $building)
    {
        $this->building = $building;
        return $this;
    }
    
    public function indexAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toUrl('/admin-user/login');
        }
        
        return array();
    }
}
