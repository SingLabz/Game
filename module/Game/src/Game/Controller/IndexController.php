<?php

namespace Game\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class IndexController extends ActionController
{  
    public function indexAction()
    {
        //$this->getLocator()->get('view')->layout()->setLayout('homepage');
        //return $this->redirect()->toRoute('foo-success');
        //return new ViewModel();
        return array();
    }
}
