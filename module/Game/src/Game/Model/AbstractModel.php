<?php

namespace Game\Model;

use Zend\Db\Table\AbstractTable,
    Zend\Db\Table\Exception;

abstract class AbstractModel extends AbstractTable
{
    public function get ($id)
    {
        $id = intval($id);
        $row = $this->fetchRow('id='.$id);
        
        if (!$row) {
            throw new Exception('User with id '.$id.' not found.', 100);
        }
        return $row->toArray();
    }
    
    public function delete ($id)
    {
        $this->delete('id='.$id);
    }
    
}