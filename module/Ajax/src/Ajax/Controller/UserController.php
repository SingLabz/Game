<?php

namespace Ajax\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Mvc\Exception\InvalidArgumentException,
    Game\Model\User,
    Zend\View\Model\ViewModel;

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
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        $viewModel->setTemplate('default/index');
        return $viewModel;
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
