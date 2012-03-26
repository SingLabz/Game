<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Resource;

class ResourceController extends ActionController
{
    protected $user;
    protected $resource;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setResource(Resource $resource)
    {
        $this->resource = $resource;
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
