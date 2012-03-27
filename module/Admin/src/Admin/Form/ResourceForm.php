<?php
namespace Admin\Form;
use Zend\Form\Form,
    Zend\Form\Element;

class ResourceForm extends Form
{
    public function init()
    {
        $this->setName('resource');
        
        $id = new Element\Hidden('id');
        $id->addFilter('Int');
        
        $name = new Element\Text('name');
        $name->setLabel('Name')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty');
        
        $description = new Element\Textarea('description');
        $description->setLabel('Description')
              ->setRequired(true)
              ->addValidator('NotEmpty');
        
        $submit = new Element\Submit('submit');
        $submit->setAttrib('id', 'submit_button')
               ->setLabel('Save');
        
        $this->addElements(array($id, $name, $description, $submit));
    }
}