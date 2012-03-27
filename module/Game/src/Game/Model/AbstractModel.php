<?php

namespace Game\Model;

use Zend\Db\Table\AbstractTable,
    Zend\Db\Table\Exception,
    Zend\Db\Table\Select;

abstract class AbstractModel extends AbstractTable
{
    public function get ($id)
    {
        $id = intval($id);
        $row = $this->fetchRow('id = '.$id);
        
        if (!$row) {
            throw new Exception('User with id '.$id.' not found.', 100);
        }
        return $row->toArray();
    }
    
    public function delete ($id)
    {
        parent::delete('id = '.$id);
    }
    
}