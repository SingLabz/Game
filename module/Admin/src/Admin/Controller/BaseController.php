<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Base;

class BaseController extends ActionController
{
    protected $user;
    protected $base;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setBase(Base $base)
    {
        $this->base = $base;
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
