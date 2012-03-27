<?php

namespace Game\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User;

class UserController extends ActionController
{
    protected $user;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function indexAction()
    {
        return array(
            'users' => $this->user->fetchAll()->toArray(),
        );
    }
   
}
