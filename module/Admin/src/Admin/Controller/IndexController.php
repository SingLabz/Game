<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User;

class IndexController extends ActionController
{
    protected $user;
    
    public function setUser(User $user)
    {
        $this->user = $user;
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
