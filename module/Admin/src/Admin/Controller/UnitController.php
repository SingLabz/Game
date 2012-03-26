<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Unit;

class UnitController extends ActionController
{
    protected $user;
    protected $unit;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
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
