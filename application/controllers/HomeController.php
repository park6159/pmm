<?php

class HomeController extends Zend_Controller_Action
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
		/* Initialize action controller here */
		$this->_helper->layout()->setLayout('json');
		$this->_storage = Zend_Auth::getInstance()->getIdentity();
	}

	public function indexAction()
	{

	}

	public function homedataAction()
	{
	    if (!Zend_Auth::getInstance()->hasIdentity()) {
		    $this->view->data = array(
		    		'success' => false,
		    );
	    } else {


	        $estoreMonthlySales = new Application_Model_EstoreMonthlySales();
	        $estoreOrder = new Application_Model_EstoreOrder();
	        
	        $monthyStats = $estoreMonthlySales->monthlyStats();
	        
	        	
	        $resultData = array();
	        	
	        foreach ($monthyStats as $monthlyStatInfo) {
	        	$resultData[] = array(
	        			'month' => date('M Y', strtotime($monthlyStatInfo['month'])),
	        			'sales' => $monthlyStatInfo['monthly_total'],
	        			'order' => $monthlyStatInfo['monthly_qty'],
	        	);
	        }
	        
	        $mostSelling = array();
	        
	        $skuStats = $estoreMonthlySales->skuStats();
	        
	        foreach($skuStats as $skuStat) {
	        	$mostSelling[] = '<a href=# title="'.$skuStat['sku_name'].'"><strong>'.$skuStat['sku']. '</strong>'.$skuStat['monthly_qty'].'($'.number_format($skuStat['monthly_total'],2).')</a>';
	        }
	        
	        error_log(print_r($mostSelling, true));
	        
	        $salesTotal = $estoreMonthlySales->getSalesTotal();
	        $orderCount = $estoreOrder->getOrderCount();
	        
	        $this->view->data = array(
	        		'success' => true,
	        		'stats' => array(
	        				'total_order' => $orderCount[0]['total_count'],
	        				'total_sales' => "$".number_format($salesTotal[0]['price_total'], 2),
	        				'traffic' => '35,347',
	        		),
	        
	        		'notifications' => array(
	        				'<a href=#><strong>eStore Scheduled Release </strong>Jan 06, 2016</a>',
	        				'<a href=#><strong>eStore SEO Release </strong>Dec 22, 2016</a>',
	        				'<a href=#><strong>eStore Monthly Meeting </strong>Dec 10, 2015</a>',
	        				'<a href=#><strong>eStore Scheduled Release </strong>Dec 02, 2015</a>',
	        				'<a href=#><strong>eStore Monthly Meeting </strong>Oct 29, 2015</a>',
	        		),
	        		'most_selling' => $mostSelling,
	        		'recent_tasks' => array(
	        				'<a href="#"><strong>Req #9 by Chang Park</strong>2015-12-09 16:25:54</a>',
	        				'<a href="#"><strong>Req #8 by Chang Park</strong>2015-12-09 14:51:37</a>',
	        				'<a href="#"><strong>Req #7 by Chang Park</strong>2015-12-09 14:50:13</a>',
	        				'<a href="#"><strong>Req #6 by Chang Park</strong>2015-12-09 14:48:29</a>',
	        				'<a href="#"><strong>Req #4 by Chang Park</strong>2015-12-09 14:42:33</a>',
	        		),
	        
	        );
	    }
	    

	}
	
	public function salestrenddataAction() 
	{
	    $estoreMonthlySales = new Application_Model_EstoreMonthlySales();

	    $monthyStats = $estoreMonthlySales->monthlyStats();
	    
	    $resultData = array();
	    
	    foreach ($monthyStats as $monthlyStatInfo) {
	        $resultData[] = array(
	        		'month' => date('M Y', strtotime($monthlyStatInfo['month'])),
	        		'sales' => $monthlyStatInfo['monthly_total'],
	        		'order' => $monthlyStatInfo['monthly_qty'],
	        );
	    }  
	    
	    $this->view->data = array('results' => $resultData);
	}


}
