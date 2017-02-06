<?php

/**
 * @author ChangP
 * Model for user conatains user information and login credentials	
 */
class Application_Model_User extends Zend_Db_Table_Abstract
{

	protected $_name = 'user';
	protected $_primary = 'id';

	/**
	 * @param String $name
	 * @param String $email
	 * @param Integer $groupId
	 * @param String $username
	 * @param String $password
	 * @return Ambigous <mixed, multitype:>
	 */
	public function addUser($name, $email, $usergroupId, $username, $password)
	{
		$data = array(
					'name' => $name,
					'email' => $email,
					'user_group_id' => $usergroupId,
					'username' => $username,
					'password' => $password,
				);
		
	    return $this->insert($data);
	}

	/**
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getAllUsers()
	{
    	$select = $this->getAdapter()->select()
                        ->from(array('u' => 'user'), array(
                            'userid' => 'u.id',
                            'username' => 'u.username',
                            'realname' => 'u.name',
                            'email' => 'u.email',
                        	'role' => 'ug.name',
                            'created' => 'u.date_created',
                            'edited' => 'u.date_edited',
                        ))
                        ->joinLeft(array('ug' => 'user_group'), 'ug.id = u.user_group_id')
                        ->order(array('u.id'));
        //error_log($select->assemble());
        $result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);

        return $result;
	}
		
	/**
	 * @param String $username
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getUserById($id)
	{
		$select = $this->select();
		 
		$select->from($this)
		->where('id = ?', $id);
		 
		$result = $this->fetchAll($select);
	
		return $result;
	}
	
	/**
	 * @param String $username
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function getUserByUsername($username)
	{
    	$select = $this->select();
    	
    	$select->from($this)
				->where('username = ?', $username);
    	
        $result = $this->fetchAll($select);
        
        return $result;
	}	
	
	/**
	 * @param String $username
	 * @param String $password
	 * @return Ambigous <Zend_Db_Table_Row_Abstract, NULL, unknown>
	 */
	public function authenticate($username, $password)
	{
		$select = $this->select();
		
		$select->from($this)
				->where('username = ?', $username)
				->where('password = MD5(?)', $password);

		$result = $this->fetchRow($select);
		
		return $result;
	}
	
}
