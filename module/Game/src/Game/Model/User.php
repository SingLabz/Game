<?php

namespace Game\Model;

use Zend\Db\Table\AbstractTable;

class User extends AbstractTable
{
    protected $_name = 'users';
    
    public function get ($id)
    {
        $id = intval($id);
        $row = $this->fetchRow('id='.$id);
        if ($row) {
            throw new Exception("Row not found");
        }
        return $row->toArray();
    }
    
    public function add ($artist, $title)
    {
        $this->insert(array(
            'artist' => $artist,
            'title' => $title,
        ));
    }
    
    public function update ($id, $artist, $title)
    {
        $this->update(
            array(
                'artist' => $artist,
                'title' => $title,
            ),
            'id='.$id
        );
    }
    
    public function delete ($id)
    {
        $this->delete('id='.$id);
    }
    
}