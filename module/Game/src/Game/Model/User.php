<?php
/**
 * @namespace
 */
namespace Game\Model;

use Zend\Authentication\Storage\Session,
    Zend\Db\Table\Select;

/**
 * Model for table 'users'
 * 
 * @author Kaur
 * @category   Game
 * @package    Game_Model
 * @subpackage Table
 */
class User extends AbstractModel
{
    /**
     * Table name
     *
     * @var string 
     */
    protected $_name = 'users';
    
    /**
     * Check if user is authenticated
     *
     * @return boolean 
     */
    public function checkAuth ()
    {
        $s = new Session();
        $data = $s->read();
        if (!empty($data) && isset($data['email'])) {
            return true;
        }
        return false;
    }
    
    /**
     * User login method
     *
     * @param string $username
     * @param string $password
     * @return boolean 
     */
    public function login ($username, $password)
    {
        $q = new Select($this);
        $q->where('email = ?', $username);
        $q->where('passw = ?', md5($password));
        
        $row = $this->fetchRow($q);
        if (!empty($row)) {
            $s = new Session();
            $s->write(array('email'=>$row->email, 'name'=>$row->first_name.' '.$row->last_name));
            return true;
        }
        $this->logout();
        return false;
    }
    
    /**
     * Log user out
     */
    public function logout () 
    {
        $s = new Session();
        $s->clear();
    }
}