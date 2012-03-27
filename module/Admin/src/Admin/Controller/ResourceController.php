<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Game\Model\Resource,
    Admin\Form\ResourceForm;

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
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        return array('resources' => $this->resource->fetchAll());
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
                'controller' => 'admin-resource',
                'action'     => 'index',
            ));
        }
        
        $resource = $this->resource->get($id);
        if (empty($resource)) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-resource',
                'action'     => 'index',
            ));
        }
        
        return array('resource' => $resource);
    }
    
    public function editAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'login',
            ));
        }
        
        $form = new ResourceForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                if ($this->resource->get($id)) {
                    $data = $form->getValues();
                    unset($data['id']);
                    
                    $this->resource->update(
                        $data,
                        array('id' => $id)
                    );
                }
                
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-resource',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', false);
            if (!$id) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-resource',
                    'action'     => 'index',
                ));
            }
            
            $resource = $this->resource->get($id);
            if (empty($resource)) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-resource',
                    'action'     => 'index',
                ));
            }
            $form->populate($resource);
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
            $this->resource->delete($id);
        }
        
        return $this->redirect()->toRoute('default', array(
            'controller' => 'admin-resource',
            'action'     => 'index',
        ));
    }
}
