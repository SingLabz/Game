<?php

namespace Game\Model;

use Zend\Db\Table\Select;

class Base extends AbstractModel
{
    protected $_name = 'bases';
    
    public function fetchAllWithJoin ()
    {
        $select  = new Select($this);
        $select->from($this->_name);
        $select->setIntegrityCheck(false);
        $select->join('users', 'users.id=bases.user_id');
        
        return $this->fetchAll($select);
    }
   
}