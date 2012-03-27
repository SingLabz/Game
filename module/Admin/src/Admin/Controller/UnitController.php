<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Unit,
    Admin\Form\UnitForm;

class UnitController extends ActionController
{
    protected $user;
    protected $unit;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
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
        
        return array('units' => $this->unit->fetchAll());
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
                'controller' => 'admin-unit',
                'action'     => 'index',
            ));
        }
        
        $unit = $this->unit->get($id);
        if (empty($unit)) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-unit',
                'action'     => 'index',
            ));
        }
        
        return array('unit' => $unit);
    }
    
    public function editAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $form = new UnitForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                if ($this->unit->get($id)) {
                    $data = $form->getValues();
                    unset($data['id']);
                    
                    $this->unit->update(
                        $data,
                        array('id' => $id)
                    );
                }
                
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-unit',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', false);
            if (!$id) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-unit',
                    'action'     => 'index',
                ));
            }
            
            $unit = $this->unit->get($id);
            if (empty($unit)) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-unit',
                    'action'     => 'index',
                ));
            }
            $form->populate($unit);
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
            $this->unit->delete($id);
        }
        
        return $this->redirect()->toRoute('default', array(
            'controller' => 'admin-unit',
            'action'     => 'index',
        ));
    }
}
