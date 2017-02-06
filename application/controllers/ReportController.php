<?php

class ReportController extends Zend_Controller_Action
{
    protected $_storage;

    public function preDispatch() {

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
        $this->_helper->layout()->setLayout('app');
        $this->_storage = Zend_Auth::getInstance()->getIdentity();

    }

    /*
     * data for projectGroupGrid
     */
    public function surveyresultdataAction()
    {
        $this->_helper->layout()->setLayout('json');
        $data = array();

        //$campaignKeyName = $this->_getCampaignByKey();
        
        $q2Answers = array(
	        "Already implemented a single customer database",
	        "Currently implementing plans to create a single customer database",
	        "Plans to implement in the next 12 month",
	        "Don't have enough organizational support to do so",
	        "Have not considered moving to a single customer database",
	        "Don't know",
        );

        $q3Answers = array(
        		"Don't Know",
        		"Not Interested",
        		"Interested, but not a priority",
        		"Implementing in the next 12 mos",
        		"Implemented",
        );
        							
        $q4Answers = array(
        		"Don't Know",
        		"Don't have it, have no plans",
        		"Don't have it, but have plans",
        		"Have limited<br>capability",
        		"Full capability",
        );        
        								
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : null;
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : null;
         
        $survey = new Application_Model_Survey();
         
        $surveyData = $survey->getServeyData($start, $limit, 'date_created');
        
        //$resultData = $surveyData;
       
        foreach ($surveyData as $surveyInfo) {
        	$resultData[] = array(
        			'responseid' => $surveyInfo['responseid'],
        			'ip_source' => $surveyInfo['ip_source'],
        			'date_created' => $surveyInfo['date_created'],
        			'business_model' => $surveyInfo['business_model'],
        			'company_size' => $surveyInfo['company_size'],
		        	'region' => $surveyInfo['region'],
		        	'q1' => $surveyInfo['q1'],
		        	'q2' => $q2Answers[$surveyInfo['q2']],
		        	'q3_dashboard' => $q3Answers[$surveyInfo['q3_dashboard']],
		        	'q3_web' => $q3Answers[$surveyInfo['q3_web']],
		        	'q3_text' => $q3Answers[$surveyInfo['q3_text']],
		        	'q3_predictive' => $q3Answers[$surveyInfo['q3_predictive']],
		        	'q3_location' => $q3Answers[$surveyInfo['q3_location']],
		        	'q4_email' => $q4Answers[$surveyInfo['q4_email']],
		        	'q4_online' => $q4Answers[$surveyInfo['q4_online']],
		        	'q4_mobile' => $q4Answers[$surveyInfo['q4_mobile']],
		        	'q4_callcenter' => $q4Answers[$surveyInfo['q4_callcenter']],
		        	'q4_store' => $q4Answers[$surveyInfo['q4_store']],
		        	'first_name' => $surveyInfo['first_name'],
		        	'last_name' => $surveyInfo['last_name'],
        			'email' => $surveyInfo['email'],
		        	'company_name' => $surveyInfo['company_name'],
		        	'job_title' => $surveyInfo['job_title'],
		        	'phone' => $surveyInfo['phone'],
		        	'state' => $surveyInfo['state'],
        			'campaign_code' => $surveyInfo['key'],
        			'campaign_url' => !empty($surveyInfo['key']) ? 'http://www.personalizationbenchmark.com?code='.$surveyInfo['key'] : '',
        	 
        	);
        }
               
        $allSurvey = $survey->getAllSurveys();
        $this->view->data = array('results' => $resultData, 'totalCount' => count($allSurvey));
    }

	public function surveylinkdataAction()
	{
	    $this->_helper->layout()->setLayout('json');
	    
	    $resultData = array();
	    
	    $surveyLink = new Application_Model_SurveyLink();
         
        $surveyLinkData = $surveyLink->getServeyLinkData();
        
        //$resultData = $surveyData;
       
        foreach ($surveyLinkData as $surveyLinkInfo) {
        	$resultData[] = array(
        			'link_id' => $surveyLinkInfo['link_id'],
        			'campaign_name' => $surveyLinkInfo['campaign_name'],
        			'created_by' => $surveyLinkInfo['created_by'],
        			'date_created' => $surveyLinkInfo['date_created'],
        			'survey_url' => 'http://www.personalizationbenchmark.com?code='.$surveyLinkInfo['link'],
        	 
        	);
        }
        
        $this->view->data = array('results' => $resultData);
    }
    
    public function addnewlinkAction()
    {
        $this->_helper->layout()->setLayout('json');
         
        $campaignName = isset($_REQUEST['campaign_name']) ? $_REQUEST['campaign_name'] : null;
	    
        if (!empty($campaignName)) {
            $surveyLink = new Application_Model_SurveyLink();
            $surveyLink->insertSurveyLinkData($campaignName, $this->_storage['name']);
        }
        
        $this->view->data = array('success' => true);
    }

    
    /*
     * Download advanced entry in Excel format
     */
    public function downloadinexcelAction()
    {
        $this->_helper->layout()->setLayout('json');

        $resultData = array();
        
        $q2Answers = array(
        		"Already implemented a single customer database",
        		"Currently implementing plans to create a single customer database",
        		"Plans to implement in the next 12 month",
        		"Don't have enough organizational support to do so",
        		"Have not considered moving to a single customer database",
        		"Don't know",
        );
        
        $q3Answers = array(
        		"Don't Know",
        		"Not Interested",
        		"Interested, but not a priority",
        		"Implementing in the next 12 mos",
        		"Implemented",
        );
         
        $q4Answers = array(
        		"Don't Know",
        		"Don't have it, have no plans",
        		"Don't have it, but have plans",
        		"Have limited<br>capability",
        		"Full capability",
        );
        
        $survey = new Application_Model_Survey();
         
        $surveyData = $survey->getServeyData();
        
       
        foreach ($surveyData as $surveyInfo) {
        	$resultData[] = array(
        			'responseid' => $surveyInfo['responseid'],
        			'ip_source' => $surveyInfo['ip_source'],
        			'date_created' => $surveyInfo['date_created'],
        			'business_model' => $surveyInfo['business_model'],
        			'company_size' => $surveyInfo['company_size'],
		        	'region' => $surveyInfo['region'],
		        	'q1' => $surveyInfo['q1'],
		        	'q2' => !is_null($surveyInfo['q2']) ? $q2Answers[$surveyInfo['q2']] : '',
		        	'q3_dashboard' => !is_null($surveyInfo['q3_dashboard']) ? $q3Answers[$surveyInfo['q3_dashboard']] : '',
		        	'q3_web' => !is_null($surveyInfo['q3_web']) ? $q3Answers[$surveyInfo['q3_web']] : '',
		        	'q3_text' => !is_null($surveyInfo['q3_text']) ? $q3Answers[$surveyInfo['q3_text']] : '',
		        	'q3_predictive' => !is_null($surveyInfo['q3_predictive']) ? $q3Answers[$surveyInfo['q3_predictive']] : '',
		        	'q3_location' => !is_null($surveyInfo['q3_location']) ? $q3Answers[$surveyInfo['q3_location']] : '',
		        	'q4_email' => !is_null($surveyInfo['q4_email']) ? $q4Answers[$surveyInfo['q4_email']] : '',
		        	'q4_online' => !is_null($surveyInfo['q4_online']) ? $q4Answers[$surveyInfo['q4_online']] : '',
		        	'q4_mobile' => !is_null($surveyInfo['q4_mobile']) ? $q4Answers[$surveyInfo['q4_mobile']] : '',
		        	'q4_callcenter' => !is_null($surveyInfo['q4_callcenter']) ? $q4Answers[$surveyInfo['q4_callcenter']] : '',
		        	'q4_store' => !is_null($surveyInfo['q4_store']) ? $q4Answers[$surveyInfo['q4_store']] : '',
		        	'first_name' => $surveyInfo['first_name'],
		        	'last_name' => $surveyInfo['last_name'],
        			'email' => $surveyInfo['email'],
		        	'company_name' => $surveyInfo['company_name'],
		        	'job_title' => $surveyInfo['job_title'],
		        	'phone' => $surveyInfo['phone'],
		        	'state' => $surveyInfo['state'],
        			'key' => $surveyInfo['key'],
        			'key_url' => !empty($surveyInfo['key']) ? 'http://www.personalizationbenchmark.com?code='.$surveyInfo['key'] : '',
        	
        	);
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("SAP Hybris Survey");
        $objPHPExcel->getProperties()->setLastModifiedBy("SAP Hybris Survey");
        $objPHPExcel->getProperties()->setTitle("SAP Hybris Survey Report");
        $objPHPExcel->getProperties()->setSubject("SAP Hybris Survey Download Data");
        $objPHPExcel->getProperties()->setDescription("SAP Hybris Survey");

        $worksheet = $objPHPExcel->getActiveSheet();
        
        $excelHeaderArr = array(
	        'responseid' => 'ID',
	        'ip_source' => 'IP ADDRESS',
	        'date_created' => 'DATE',
	        'business_model' => 'BUSINESS MODEL',
	        'company_size' => 'COMPANY SIZE',
	        'region' => 'REGION',
	        'q1' => 'Q1 RESULT',
	        'q2' => 'Q2 RESULT',
	        'q3_dashboard' => 'Q3 DASHBOARD',
	        'q3_web' => 'Q3 WEB',
	        'q3_text' => 'Q3 TEXT',
	        'q3_predictive' => 'Q3 PREDICTIVE',
	        'q3_location' => 'Q3 LOCATION',
	        'q4_email' => 'Q4 EMAIL',
	        'q4_online' => 'Q4 ONLINE',
	        'q4_mobile' => 'Q4 MOBILE',
	        'q4_callcenter' => 'Q4 CALL CENTER',
	        'q4_store' => 'Q4 STORE',
	        'first_name' => 'FIRST NAME',
	        'last_name' => 'LAST NAME',
        	'email' => 'EMAIL ADDRESS',
	        'company_name' => 'COMPANY NAME',
	        'job_title' => 'JOB TITLE',
	        'phone' => 'PHONE',
	        'state' => 'STATE',
	        'key' => 'CAMPAIGN CODE',
        	'key_url' => 'CAMPAIGN URL',
        );
        
        $i = 0;
        foreach ($excelHeaderArr as $headerTitle) {
            $alphaPart = $this->_convertIndexToAlpha($i);
            $worksheet->getColumnDimension($alphaPart)->setWidth(20);
            $i++;
        }
        
        // Draw header part
        $objPHPExcel->setActiveSheetIndex(0);

        $i = 0;
        foreach ($excelHeaderArr as $dbField => $headerTitle) {
            $alphaPart = $this->_convertIndexToAlpha($i);
            $objPHPExcel->getActiveSheet()->SetCellValue($alphaPart.'1', $headerTitle);
            $i++;
        }
        
        // Draw data part
        $i = 2;
        foreach ($resultData as $entryInfo) {
            $j = 0;  
            foreach ($excelHeaderArr as $dbField => $fieldName) {
                $alphaPart = $this->_convertIndexToAlpha($j);
                $objPHPExcel->getActiveSheet()->SetCellValue($alphaPart.$i, isset($entryInfo[$dbField]) ?  $entryInfo[$dbField] : '');
                $j++;
            }
            $i++;
        }

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
        $this->view->excelcontent = $objWriter->save('php://output');
        $this->view->filename = 'SurveyData'.date('Y-m-d H:i:s');
    }
    
    private function _convertIndexToAlpha($index)
    {
    	$alphaArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I',
    			'J', 'K', 'L', 'M', 'N','O', 'P', 'Q', 'R',
    			'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    
    	if ($index < 26) {
    		return  $alphaArr[$index];
    	}
    
    	$firstDigit = floor($index / 26);
    	$secondDigit = $index % 26;
    
    	return $alphaArr[$firstDigit-1].$alphaArr[$secondDigit];
    
    }
}







