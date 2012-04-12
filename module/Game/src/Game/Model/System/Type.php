<?php

namespace Game\Model\System;

use Game\Model\AbstractModel;

class Type extends AbstractModel
{
    protected $_name = 'system_types';
    
    public function fetchSelect () 
    {
        $res = array();
        
        $types = parent::fetchAll();
        foreach ($types as $type) {
            $res[$type['id']] = $type['name'];
        }
        
        return $res;
    }
   
}