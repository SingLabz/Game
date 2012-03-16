<?php

namespace Game\Model;

use Zend\Db\Table\AbstractTable;

abstract class AbstractModel extends AbstractTable
{
    public function get ($id)
    {
        $id = intval($id);
        $row = $this->fetchRow('id='.$id);
        if ($row) {
            throw new Exception("Row not found");
        }
        return $row->toArray();
    }
    
    public function delete ($id)
    {
        $this->delete('id='.$id);
    }
    
}