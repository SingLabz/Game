<?php

namespace Game\Model;

use Zend\Db\Table\Select;

class Upgrade extends AbstractModel
{
    protected $_name = 'upgrades';
   
    public function fetchAllWithJoin ()
    {
        $select  = new Select($this);
        $select->from($this->_name);
        $select->setIntegrityCheck(false);
        $select->join('system_types', 'system_types.id=upgrades.type',array('type_name' => 'name'));
        
        return $this->fetchAll($select);
    }
    
    public function getWithJoin ($id)
    {
        $select  = new Select($this);
        $select->from($this->_name);
        $select->setIntegrityCheck(false);
        $select->join('system_types', 'system_types.id=upgrades.type',array('type_name' => 'name'));
        $select->where('upgrades.id = ?', intval($id));
        
        return $this->fetchRow($select);
    }
}