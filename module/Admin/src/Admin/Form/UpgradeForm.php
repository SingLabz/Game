<?php
namespace Admin\Form;
use Zend\Form\Form,
    Zend\Form\Element,
    Game\Model\System\Type;

class UpgradeForm extends Form
{
    protected $type;
    
    public function setType (Type $type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function init()
    {
        $this->setName('upgrade');
        
        $id = new Element\Hidden('id');
        $id->addFilter('Int');
        
        $name = new Element\Text('name');
        $name->setLabel('Name')
               ->setRequired(true)
               ->addFilter('StripTags')
               ->addFilter('StringTrim')
               ->addValidator('NotEmpty');
        
        $type = new Element\Select('type');
        $type->setLabel('Type')
              ->addMultiOptions($this->type->fetchSelect())
              ->setRequired(true)
              ->addValidator('NotEmpty');
        
        $description = new Element\Textarea('description');
        $description->setLabel('Description')
              ->setRequired(true)
              ->addValidator('NotEmpty');
        
        $submit = new Element\Submit('submit');
        $submit->setAttrib('id', 'submit_button')
               ->setLabel('Save');
        
        $this->addElements(array($id, $name, $type, $description, $submit));
    }
}