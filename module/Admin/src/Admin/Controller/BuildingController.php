<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Building,
    Admin\Form\BuildingForm;

class BuildingController extends ActionController
{
    protected $user;
    protected $building;
    
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }
    
    public function setBuilding(Building $building)
    {
        $this->building = $building;
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
        
        return array('buildings' => $this->building->fetchAll());
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
                'controller' => 'admin-building',
                'action'     => 'index',
            ));
        }
        
        $building = $this->building->get($id);
        if (empty($building)) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-building',
                'action'     => 'index',
            ));
        }
        
        return array('building' => $building);
    }
    
    public function editAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $form = new BuildingForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                if ($this->building->get($id)) {
                    $data = $form->getValues();
                    unset($data['id']);
                    
                    $this->building->update(
                        $data,
                        array('id' => $id)
                    );
                }
                
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-building',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', false);
            if (!$id) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-building',
                    'action'     => 'index',
                ));
            }
            
            $building = $this->building->get($id);
            if (empty($building)) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-building',
                    'action'     => 'index',
                ));
            }
            $form->populate($building);
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
            $this->building->delete($id);
        }
        
        return $this->redirect()->toRoute('default', array(
            'controller' => 'admin-building',
            'action'     => 'index',
        ));
    }
}
