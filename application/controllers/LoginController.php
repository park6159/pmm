<?php
/*
 *	PM Dashboard LoginController.php
 */
class LoginController extends Zend_Controller_Action
{

	/*
	 * Initialize login related params
	 */
	public function init()
	{
		$this->_helper->layout()->setLayout('json');
	}


	public function indexAction()
	{
		$this->_helper->layout()->setLayout('layout');
	}


	/*
	 * autologoutAction
	 */
	public function autologoutAction()
	{
	}


	/*
	 * Ajaxy logout
	 */
	public function autoajaxlogoutAction()
	{
	}


	/*
	 * Logout prog
	 */
	public function logoutprocessAction()
	{
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$auth->clearIdentity();
		}
		$this->_redirect('/admin');
	}


    /*
     * User authentication through EWS.
     */
    public function loginprocessAction()
    {
        $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
        $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
               
        $auth = Zend_Auth::getInstance();

        $loginResult = array();
        $error_msg = '';
		
        // clear current session just in case user login with different account
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }

		$user = new Application_Model_User();
		$userData = $user->authenticate($username, $password);

		error_log(print_r($userData, true));
		
		if (!empty($userData->id)) {
		    
			$this->_startLoginSession(Dashboard_Controller_Plugin_SessionHandler::LOGIN_SESSION_TIME, $userData);
			
		    $loginResult = array( 'success' => true);
			
		} else {
		    if ($auth->hasIdentity()) {
                $auth->clearIdentity();
            }
            
		    $loginResult = array( 'success' => false, 'error' => 'Invalid Login');
		}

        $this->view->data = $loginResult;
    }
   
	private function _startLoginSession($expiration, $userData)
	{

		$registry = Zend_Registry::getInstance();

		$loginData = array(
						'userid' => $userData->id,
						'name' => $userData->name,
						'email' => $userData->email,
						'username' => $userData->username,
						);

		$auth = Zend_Auth::getInstance();
		$storage = new Zend_Auth_Storage_Session();
		$storage->write($loginData);
		$auth->setStorage($storage);
		$authNamespace = new Zend_Session_Namespace('Dashboard');
		$authNamespace->timeout = time() + $expiration;

	}


	public function getsessionAction()
	{
		$this->view->data = array('success'=>true, 'user'=>Zend_Auth::getInstance()->getIdentity());
	}
}
