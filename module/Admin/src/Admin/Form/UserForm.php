<?php
namespace Admin\Form;
use Zend\Form\Form,
    Zend\Form\Element;

class UserForm extends Form
{
    public function init()
    {
        $this->setName('user');
        
        $id = new Element\Hidden('id');
        $id->addFilter('Int');
        
        $fist_name = new Element\Text('first_name');
        $fist_name->setLabel('First name')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty');
        $last_name = new Element\Text('last_name');
        $last_name->setLabel('Last name')
              ->setRequired(true)
              ->addFilter('StripTags')
              ->addFilter('StringTrim')
              ->addValidator('NotEmpty');
        
        $email = new Element\Text('email');
        $email->setLabel('E-mail')
              ->setRequired(true)
              ->addValidator('EmailAddress')
              ->addValidator('NotEmpty');
        
        $passw = new Element\Password('new_passw');
        $passw->setLabel('New password');
        
        $submit = new Element\Submit('submit');
        $submit->setAttrib('id', 'submit_button')
               ->setLabel('Save');
        
        $this->addElements(array($id, $fist_name, $last_name, $email, $passw, $submit));
    }
}