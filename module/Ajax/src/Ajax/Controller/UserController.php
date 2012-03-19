<?php

namespace Ajax\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Mvc\Exception\InvalidArgumentException,
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
        return array('data' => array('error' => 1, 'msg' => 'This is index action. Not used for anything.'));
    }
    
    public function getAction()
    {
        try {
            $id = $this->getRequest()->query()->get('id', 0);
            if ($id === 0) {
                throw new InvalidArgumentException('Valid param(s) missing',120);
            }
            $row = $this->user->get($id);
        } catch (Exception $e) {
            return array('data' => array('error' => $e->getCode(), 'msg' => $e->getMessage()));
        }
        return array('data' => array('result' => $row, 'error' => 0));
    }
}
