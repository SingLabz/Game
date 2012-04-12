<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Upgrade,
    Admin\Form\UpgradeForm;

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
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        return array('upgrades' => $this->upgrade->fetchAllWithJoin());
    }
    
    public function viewAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $id = $this->getRequest()->query()->get('id', false);
        if (!$id) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-upgrade',
                'action'     => 'index',
            ));
        }
        
        $upgrade = $this->upgrade->getWithJoin($id);
        if (empty($upgrade)) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-upgrade',
                'action'     => 'index',
            ));
        }
        
        return array('upgrade' => $upgrade);
    }
    
    public function editAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $form = new UpgradeForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                if ($this->upgrade->get($id)) {
                    $data = $form->getValues();
                    unset($data['id']);
                    
                    $this->upgrade->update(
                        $data,
                        array('id' => $id)
                    );
                }
                
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-upgrade',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', false);
            if (!$id) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-upgrade',
                    'action'     => 'index',
                ));
            }
            
            $upgrade = $this->upgrade->get($id);
            if (empty($upgrade)) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-upgrade',
                    'action'     => 'index',
                ));
            }
            $form->populate($upgrade);
        }
        return array('form' => $form);
    }
    
    public function deleteAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $id = $this->getRequest()->query()->get('id', false);
        if ($id) {
            $this->upgrade->delete($id);
        }
        
        return $this->redirect()->toRoute('default', array(
            'controller' => 'admin-upgrade',
            'action'     => 'index',
        ));
    }
}
