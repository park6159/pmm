<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout()->setLayout('layout');
    }
    
    public function indexAction()
    {
    	$questionSet = array();
    	
    	$question = new Application_Model_Question();
    	$qData = $question->getQuestionByLanguage('US');
    	foreach ($qData as $qInfo) {
    		$questionSet[$qInfo->title] = $qInfo->wording;
    	}
    	
    	$this->view->qData = $questionSet;
    }

}







