<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController,
    Game\Model\User,
    Admin\Form\UserForm;

class UserController extends ActionController
{
    protected $user;
    protected $messenger;
    
    public function init()
    {
        $this->messenger = new FlashMessenger();
    }
    
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
        
        return array('users' => $this->user->fetchAll());
    }
    
    public function viewAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toUrl('/admin-user/login');
        }
        
        $user_id = $this->getRequest()->query()->get('id', false);
        if (!$user_id) {
            return $this->redirect()->toUrl('/admin-user/index');
        }
        
        $user = $this->user->get($user_id);
        if (empty($user)) {
            return $this->redirect()->toUrl('/admin-user/index');
        }
        
        return array('user' => $user);
    }
    
    public function editAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toRoute('default', array(
                'controller' => 'admin-user',
                'action'     => 'index',
            ));
        }
        
        $form = new UserForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                if ($this->user->get($id)) {
                    $data = $form->getValues();
                    unset($data['id'], $data['new_passw']);
                    
                    $this->user->update(
                        $data,
                        array('id' => $id)
                    );
                    if ($form->getValue('new_passw')) {
                        $this->user->update(
                            array('passw' => md5($form->getValue('new_passw'))),
                            array('id' => $id)
                        );
                    }
                }
                
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-user',
                    'action'     => 'index',
                ));
            }
        } else {
            $id = $request->query()->get('id', false);
            if (!$id) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-user',
                    'action'     => 'index',
                ));
            }
            
            $user = $this->user->get($id);
            if (empty($user)) {
                return $this->redirect()->toRoute('default', array(
                    'controller' => 'admin-user',
                    'action'     => 'index',
                ));
            }
            $form->populate($user);
        }
        return array('form' => $form);
    }
    
    public function deleteAction()
    {
        if (!$this->user->checkAuth()) {
            return $this->redirect()->toUrl('/admin-user/login');
        }
        
        $id = $this->getRequest()->query()->get('id', false);
        if ($id) {
            $this->user->delete($id);
        }
        
        return $this->redirect()->toRoute('default', array(
            'controller' => 'admin-user',
            'action'     => 'index',
        ));
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
