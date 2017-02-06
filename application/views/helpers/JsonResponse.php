<?php   
/*
 * 
 * Helper to format view data into Json data
 * $view - view to draw.
 * $checkSession - if this is true check login session and include in data. 
 */
class Zend_View_Helper_JsonResponse extends Zend_View_Helper_Abstract  
{ 
  public function jsonResponse($view, $checkSession = false)
  {
    require_once("Zend/Json.php");
    
    if (!empty($view->data)) {
    	$response = $view->data;

    }

    if ($checkSession) {
    	$auth = Zend_Auth::getInstance();
	    
    	if ($auth->hasIdentity()) {
			$response['login'] = true;
		} else {
			$response['login'] = false;
		}
    }
    
    echo Zend_Json::encode($response);
  }
    
}
