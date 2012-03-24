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
        $viewModel = new ViewModel();
        $viewModel->setTerminal(true);
        $viewModel->setTemplate('default/index');
        
        try {
            $id = $this->getRequest()->query()->get('id', 0);
            if ($id === 0) {
                //var_dump($viewModel);die();
                throw new InvalidArgumentException('Valid param(s) missing',120);
            }
            $row = $this->user->get($id);
            $viewModel->setVariables(array('data' => array('result' => $row, 'error' => 0)));
            return $viewModel;
        } catch (InvalidArgumentException $e) {
            $viewModel->setVariables(array('data' => array('error' => $e->getCode(), 'msg' => $e->getMessage())));
            return $viewModel;
        }
        return $viewModel;
    }
}
