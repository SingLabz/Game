<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Upgrade;

class UpgradeController extends ActionController
{
    protected $user;
    protected $upgrade;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setUpgrade(Upgrade $upgrade)
    {
        $this->upgrade = $upgrade;
        return $this;
    }
    
    public function indexAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toUrl('/admin-user/login');
        }
        
        return array('upgrades' => $this->upgrade->fetchAllWithJoin());
    }
}
