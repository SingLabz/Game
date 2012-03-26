<?php

namespace Admin\Controller;

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
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toUrl('/admin-user/login');
        }
        
        return array();
    }
    
    public function loginAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->post()->toArray();
            if (!empty($data['email']) && !empty($data['passw'])) {
                if ($this->user->login($data['email'], $data['passw'])) {
                    return $this->redirect()->toUrl('/admin-index');
                } else {
                    return array('error' => 'Wrong e-mail or password');
                }
            } else {
                return array('error' => 'E-mail or password missing');
            }
        }
        return array();
    }
}
