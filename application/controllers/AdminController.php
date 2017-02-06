<?php

class AdminController extends Zend_Controller_Action
{
	protected $_storage;

	public function preDispatch()
	{
	    $authNamespace = new Zend_Session_Namespace('Dashboard');

        if (isset($authNamespace->timeout) && time() > $authNamespace->timeout) {
            Zend_Auth::getInstance()->clearIdentity();
        } else {
        //extend session
        $authNamespace->timeout = time() + Dashboard_Controller_Plugin_SessionHandler::LOGIN_SESSION_TIME;
        }

	}
	
	
	
	public function init()
	{

		$this->_helper->layout()->setLayout('json');
		$this->_storage = Zend_Auth::getInstance()->getIdentity();
	}


    /**
     * Rendering js layout only
     */
    public function indexAction()
    {
                
    	$this->_helper->layout()->setLayout('adminlayout');
    }

    /**
     * Return Session information to frontend
     * storage reset requires re-login.
     */
    public function getappdataAction()
    {
    	$this->_helper->layout()->setLayout('json');
    	 
    	if (empty($this->_storage)) {
    		$success = false;
    	} else {
    		$success = true;
    	}
    
    	$this->view->data =  array(
    			'success' => $success,
    			'appData' => $this->_storage,
    	);
    }
    
	public function adminuserdataAction()
	{
	    $this->_helper->layout()->setLayout('json');
	    	    
	    $user = new Application_Model_User();
	    $userData = $user->getAllUsers();	

	    $resultData = array();
	    
	    foreach($userData as $userInfo) {
	    	$resultData[] = array(
	    			'userid' => $userInfo['userid'],
	    			'username' => $userInfo['username'],
	    			'name' => $userInfo['realname'],
	    			'email' => $userInfo['email'],
	    			'role' => $userInfo['role'],
	    			'created' => $userInfo['created'],
	    			'edited' => $userInfo['edited'],
	    	);
	    }
	    
	    $this->view->data = array('results' => $resultData);
	}
	
	public function admingroupdataAction()
	{
		$this->_helper->layout()->setLayout('json');
	
		$userGroup = new Application_Model_UserGroup();
		$userGroupData = $userGroup->getAllUserGroup();
	
		$resultData = array();
		 
		foreach($userGroupData as $userGroupInfo) {
			$resultData[] = array(
					'groupid' => $userGroupInfo->id,
					'name' => $userGroupInfo->name,
					'description' => $userGroupInfo->description,
					'created' => $userGroupInfo->date_created,
					'edited' => $userGroupInfo->date_edited,						
			);
		}
		 
		$this->view->data = array('results' => $resultData);
	}	
	

	public function addnewadminuserAction() {
		if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['usergroupid']) && isset($_POST['username']) && isset($_POST['password'])) {
			$this->_helper->layout()->setLayout('json');

			$user = new Application_Model_User();
			$user->addUser(
					$_POST['name'],
					$_POST['email'],
					$_POST['usergroupid'],
					$_POST['username'],
					md5($_POST['password'])
			);
		}
	}





	public function updateadminuserdataAction()
	{
		$this->_helper->layout()->setLayout('json');

		$modRecords = isset($_REQUEST['modRecords']) ? $_REQUEST['modRecords'] : null;

		if (!empty($modRecords)) {
			$dataToUpdate = json_decode($modRecords);
			$user = new Application_Model_User();

			foreach($dataToUpdate as $editData) {

				$n = $user->updateUser(
						$editData[0],
						$editData[1],
						$editData[2],
						$editData[3],
						$editData[4]);
			}
		}

		$this->view->data = array( 'success' => true);
	}
	
	
	public function removeuserdataAction() {
		if(isset($_POST['userid'])) {
			$this->_helper->layout()->setLayout('json');
	
			$user = new Application_Model_User();
			$user->removeUser($_POST['userid']);
		}
		$this->view->data = array( 'success' => true);
	}
	
	public function forgetpasswordAction() {
		
	}
	
	public function resetuserpasswordmailAction() {
		
		$email = isset($_POST['email']) ? $_POST['email'] : null;
		
		$resultData = array();
		
		$config = new Zend_Config_Ini(APPLICATION_PATH. '/configs/application.ini', APPLICATION_ENV);
			
		$fromEmail = $config->resources->mail->defaultFrom->email;
		$fromName = $config->resources->mail->defaultFrom->name;

		$user = new Application_Model_User();
		$userData = $user->getUserByEmail($email);
		
		foreach ($userData as $userInfo) {
			$emailBody = 'Dear ' . $userInfo->name . ',<br><br>Please use the following link to reset your password<br><br>';
			$emailBody = $emailBody . '<a href="' . $_SERVER['HTTP_HOST']  . '/admin/resetuserpasswordform?id=' . $userInfo->id . '&password=' . $userInfo->password . '" target="_blank">Click to reset your password</a>';
			$emailBody = $emailBody . '<br><br>Please contact PM Dashboard admin, if you have any question about this request.<br><br> PM Dashboard.';
				
			$mail = new Zend_Mail();
			$mail->setFrom($fromEmail, $fromName);
			$mail->setBodyHtml($emailBody);
			$mail->addTo($userInfo->email, $userInfo->name);
			$mail->setSubject('PM-DashBoard: Password Reset Request');
			$mail->send();
		}
		
	}
	
	public function resetuserpasswordformAction() {
	
	}
	
	public function resetuserpasswordAction() {
		
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		$password = isset($_POST['password']) ? $_POST['password'] : null;
		$newPassword = isset($_POST['newPassword']) ? $_POST['newPassword'] : null;
		
		$isAuthorizedToResetPassword = false;
		$userId = null;
		
		if (isset($id) && isset($password)) {
			
			$user = new Application_Model_User();
			$userData = $user->getUserById($id);
			
			foreach ($userData as $userInfo) {
				if ($userInfo -> password == $password) {
					$userId = $userInfo -> id;
					$isAuthorizedToResetPassword = true;
					break;
				}
			}
		}

		if ($isAuthorizedToResetPassword && isset($userId) && isset($newPassword)) {
			$n = $user->resetUserPassword($userId, $newPassword);
			$this->view->data = array( 'success' => true);
		} else {
			$this->view->data = array( 'success' => false);
		}
	
	}
	
}
