<?php

class AnalysisController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout()->setLayout('layout');
    }
    
    public function indexAction()
    {
        $testData = array();
        
        $debug = isset($_REQUEST["debug"]) ? $_REQUEST["debug"] : null;
        $camp = isset($_REQUEST["code"]) ? $_REQUEST["code"] : null;
        if (is_null($debug)) {
            $surveyId = isset($_POST["q0"]) ? $_POST["q0"] : null;
            $q1Answer = isset($_POST["q1"]) ? $_POST["q1"] : null;
            $q2Answer = isset($_POST["q2"]) ? $_POST["q2"]-1 : null;
            $q31Answer = isset($_POST["q3_1"]) ? $_POST["q3_1"]-1 : null;
            $q32Answer = isset($_POST["q3_2"]) ? $_POST["q3_2"]-1 : null;
            $q33Answer = isset($_POST["q3_3"]) ? $_POST["q3_3"]-1 : null;
            $q34Answer = isset($_POST["q3_4"]) ? $_POST["q3_4"]-1 : null;
            $q35Answer = isset($_POST["q3_5"]) ? $_POST["q3_5"]-1 : null;
            $q41Answer = isset($_POST["q4_1"]) ? $_POST["q4_1"]-1 : null;
            $q42Answer = isset($_POST["q4_2"]) ? $_POST["q4_2"]-1 : null;
            $q43Answer = isset($_POST["q4_3"]) ? $_POST["q4_3"]-1 : null;
            $q44Answer = isset($_POST["q4_4"]) ? $_POST["q4_4"]-1 : null;
            $q45Answer = isset($_POST["q4_5"]) ? $_POST["q4_5"]-1 : null;
            
            $region = isset($_POST["region"]) ? $_POST["region"] : null;
            $qs2 = isset($_POST["business_model"]) ? $_POST["business_model"] : null;
            $qs4 = isset($_POST["company_size"]) ? $_POST["company_size"] : null;
            
            $filter = isset($_POST["filter"]) ? $_POST["filter"] : null;
            
        } else {
            $q1Answer = isset($_REQUEST["q1"]) ? $_REQUEST["q1"] : null;
            $q2Answer = isset($_REQUEST["q2"]) ? $_REQUEST["q2"]-1 : null;
            $q31Answer = isset($_REQUEST["q3_1"]) ? $_REQUEST["q3_1"]-1 : null;
            $q32Answer = isset($_REQUEST["q3_2"]) ? $_REQUEST["q3_2"]-1 : null;
            $q33Answer = isset($_REQUEST["q3_3"]) ? $_REQUEST["q3_3"]-1 : null;
            $q34Answer = isset($_REQUEST["q3_4"]) ? $_REQUEST["q3_4"]-1 : null;
            $q35Answer = isset($_REQUEST["q3_5"]) ? $_REQUEST["q3_5"]-1 : null;
            $q41Answer = isset($_REQUEST["q4_1"]) ? $_REQUEST["q4_1"]-1 : null;
            $q42Answer = isset($_REQUEST["q4_2"]) ? $_REQUEST["q4_2"]-1 : null;
            $q43Answer = isset($_REQUEST["q4_3"]) ? $_REQUEST["q4_3"]-1 : null;
            $q44Answer = isset($_REQUEST["q4_4"]) ? $_REQUEST["q4_4"]-1 : null;
            $q45Answer = isset($_REQUEST["q4_5"]) ? $_REQUEST["q4_5"]-1 : null;
            
            $region = isset($_REQUEST["region"]) ? $_REQUEST["region"] : null;
            $qs2 = isset($_REQUEST["business_model"]) ? $_REQUEST["business_model"] : null;
            $qs4 = isset($_REQUEST["company_size"]) ? $_REQUEST["company_size"] : null;
        }

    
        if (is_null($q1Answer) || is_null($q2Answer) || is_null($q31Answer) || is_null($q32Answer) || 
        is_null($q33Answer) || is_null($q34Answer) || is_null($q35Answer) || is_null($q41Answer) || 
        is_null($q42Answer) || is_null($q43Answer) || is_null($q44Answer) || is_null($q45Answer)) {
            $this->_redirect('/');
        }
        
        if (!empty($filter)) {
            $filterInfo = explode('_' , $filter);
            $filterField = $filterInfo[0];
            $filterData = $filterInfo[1];
        } else {
            $filterField = null;
            $filterData = null;
        }

        if (is_null($surveyId)) {
            $survey = new Application_Model_Survey();
            
            $surveyId = $survey->insertSurveyData($_SERVER['REMOTE_ADDR'], $region, $qs2, $qs4,
            		$q41Answer, $q42Answer, $q43Answer, $q44Answer, $q45Answer,
            		$q1Answer, $q2Answer, $q31Answer, $q32Answer,
            		$q33Answer, $q34Answer, $q35Answer, $camp);
        }

        
        
    	$resultData = $this->_q1Calculation($q1Answer, $filterField, $filterData);  	
    	
    	if (empty($resultData)) {
    	    $filterField = null;
    	    $filterData = null;
    	    $resultData = $this->_q1Calculation($q1Answer, $filterField, $filterData);
    	}
    	$outputHTML1 = "<p><table border=1><tr><td colspan=3>Question #1</td></tr>";
    	$outputHTML1 .= "<tr><td>Group</td><td>Count</td><td>Percent</td></tr>";    	
    	$outputHTML1 .= "<tr><td>0(0)</td><td>".$resultData['sampleData'][0]."</td><td>".round($resultData['groupPercent'][0])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>1(1-10)</td><td>".$resultData['sampleData'][1]."</td><td>".round($resultData['groupPercent'][1])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>2(11-20)</td><td>".$resultData['sampleData'][2]."</td><td>".round($resultData['groupPercent'][2])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>3(21-30)</td><td>".$resultData['sampleData'][3]."</td><td>".round($resultData['groupPercent'][3])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>4(31-40)</td><td>".$resultData['sampleData'][4]."</td><td>".round($resultData['groupPercent'][4])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>5(41-50)</td><td>".$resultData['sampleData'][5]."</td><td>".round($resultData['groupPercent'][5])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>5(50+)</td><td>".$resultData['sampleData'][6]."</td><td>".round($resultData['groupPercent'][6])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>Total</td><td>".($resultData['sampleData'][0]+$resultData['sampleData'][1]+$resultData['sampleData'][2]+$resultData['sampleData'][3]+$resultData['sampleData'][4]+$resultData['sampleData'][5]+$resultData['sampleData'][6])."</td><td>".round($resultData['groupPercent'][0]+$resultData['groupPercent'][1]+$resultData['groupPercent'][2]+$resultData['groupPercent'][3]+$resultData['groupPercent'][4]+$resultData['groupPercent'][5]+$resultData['groupPercent'][6])."%</td></tr>";
    	$outputHTML1 .= "<tr><td>&nbsp;</td><td>Group</td><td>Index</td></tr>";
    	$outputHTML1 .= "<tr><td>You</td><td>".$resultData['myGroup']."</td><td>".$resultData['myRank']."</td></tr>";
    	$outputHTML1 .= "<tr><td>Median</td><td>".$resultData['medianGroup']."</td><td>".$resultData['medianRank']."</td></tr>";
    	$outputHTML1 .= "</table>";
    	
    	
    	
    	$ranks = $resultData['rank'];
    	$myGroup = $resultData['myGroup'];
    	$myGroupRange = $resultData['myGroupRange'];
    	$myRank = $resultData['myRank'];
    	$medianGroup = $resultData['medianGroup'];
    	$medianRank = $resultData['medianRank'];
    
    	// 0 to .247*t
    	if ($myGroup == $medianGroup) { // median group
    		$myPercent = 100;
    		$benchmarkAngle = .247;
    		$surveyAngle = .247;
    		
    		$this->view->q1Analysis2 = round(($myGroupRange[1] - $myGroupRange[0] + 1) / count($ranks) * 100) . '%';
    		$this->view->q1Analysis3 = 'of your peers have similar number of systems.';		
    			
    	} elseif ($myGroup > $medianGroup) { // more than 100%
    		$myPercent = 100 + ((($myRank - $medianRank) / count($ranks)) * 100);
    		$benchmarkAngle = .247 * (200 - $myPercent)/100;
    		$surveyAngle = .247;
    		
    		$this->view->q1Analysis2 = 100 - round((count($ranks)-($myGroupRange[1]+1)) / count($ranks) * 100) . '%';
    		$this->view->q1Analysis3 = 'of your peers have smaller number of systems.';    
    					
    	} else { // less than 100%
    		$myPercent = 100 - ((($medianRank - $myRank) / count($ranks)) * 100);
    		$benchmarkAngle = .247;
    		$surveyAngle = .247 * $myPercent/100;
    		$this->view->q1Analysis2 = round((count($ranks)-($myGroupRange[1]+1)) / count($ranks) * 100) . '%';
    		$this->view->q1Analysis3 = 'of your peers have greater number of systems.';    		 
    	}

    	$this->view->q1BenchmarkAngle = $benchmarkAngle;
    	$this->view->q1SurveyAngle = $surveyAngle;
    	$this->view->q1MyPercent = round($myPercent);
    	 
    	$this->view->q1Analysis1 = "Based on your response of $q1Answer number of customer interaction systems,";
    	
    	error_log('medianRank is '. $medianRank);
    	error_log('medianGroup is '. $medianGroup);
    	error_log('myRank is '. $myRank);
    	error_log('myIndex is '. $myGroup);
    	error_log('myPercent is '. $myPercent);
    	error_log('benchmarkAngle is '. $benchmarkAngle);
    	error_log('surveyAngle is '. $surveyAngle);
    	//error_log(print_r($q5Samples,true));
    	
    	//////////////////////////////////////////////////////////////////////////
    	// [entered value] is your number of systems.  [xx%] of your peers have greater number of systems.
    	// END OF Q1
    	//////////////////////////////////////////////////////////////////////////
    	
    	$resultData = $this->_q2Calculation($q2Answer, $filterField, $filterData);
    	
    	$ranks = $resultData['rank'];
    	$myGroup = $resultData['myGroup'];
    	$myGroupRange = $resultData['myGroupRange'];    	
    	$myRank = $resultData['myRank'];
    	$medianGroup = $resultData['medianGroup'];
    	$medianRank = $resultData['medianRank'];
    	$groupPercent = $resultData['groupPercent'];
    	
    	$outputHTML2 = "<p><table border=1><tr><td colspan=3>Question #2</td></tr>";
    	$outputHTML2 .= "<tr><td>Group</td><td>Count</td><td>Percent</td></tr>";
    	$outputHTML2 .= "<tr><td>0(No Plan)</td><td>".$resultData['sampleData'][0]."</td><td>".round($resultData['groupPercent'][0])."%</td></tr>";
    	$outputHTML2 .= "<tr><td>1(Planned)</td><td>".$resultData['sampleData'][1]."</td><td>".round($resultData['groupPercent'][1])."%</td></tr>";
    	$outputHTML2 .= "<tr><td>2(Implementing)</td><td>".$resultData['sampleData'][2]."</td><td>".round($resultData['groupPercent'][2])."%</td></tr>";
    	$outputHTML2 .= "<tr><td>3(Already)</td><td>".$resultData['sampleData'][3]."</td><td>".round($resultData['groupPercent'][3])."%</td></tr>";
    	$outputHTML2 .= "<tr><td>Total</td><td>".($resultData['sampleData'][0]+$resultData['sampleData'][1]+$resultData['sampleData'][2]+$resultData['sampleData'][3])."</td><td>".round($resultData['groupPercent'][0]+$resultData['groupPercent'][1]+$resultData['groupPercent'][2]+$resultData['groupPercent'][3])."%</td></tr>";
    	$outputHTML2 .= "<tr><td>&nbsp;</td><td>Group</td><td>Index</td></tr>";
    	$outputHTML2 .= "<tr><td>You</td><td>".$resultData['myGroup']."</td><td>".$resultData['myRank']."</td></tr>";
    	$outputHTML2 .= "<tr><td>Median</td><td>".$resultData['medianGroup']."</td><td>".$resultData['medianRank']."</td></tr>";
    	$outputHTML2 .= "</table>";    	
    	
    	// 0 no 1 plan 2, 3 already
    	// .25 to .497*t
    	if ($myGroup == $medianGroup) { // median group
    		$myPercent = 100;
    		$benchmarkAngle = .497;
    		$surveyAngle = .497;
    		 
    	} elseif ($myGroup > $medianGroup) { // more than 100%
    		$myPercent = 100 + ((($myRank - $medianRank) / count($ranks)) * 100);
    		$benchmarkAngle = .247 * (200 - $myPercent)/100 + .25;
    		$surveyAngle = .497;
    		 
    	} else { // less than 100%
    		$myPercent = 100 - ((($medianRank - $myRank) / count($ranks)) * 100);
    		$benchmarkAngle = .497;
    		$surveyAngle = .247 * $myPercent/100 + .25;
    	}

    	$this->view->q2BenchmarkAngle = $benchmarkAngle;
    	$this->view->q2SurveyAngle = $surveyAngle;
    	$this->view->q2MyPercent = round($myPercent);   

    	$surveyVariable = new Application_Model_SurveyVariable();
    	$mySelection = $surveyVariable->getLabelByVariable('q2',  $q2Answer);
    	
    	// No plan 1+2+3 %
    	if ($myGroup == 0) { // no plan
    	    $this->view->q2Analysis1 = 'You ' . $mySelection[0]['option'];
    	    $this->view->q2Analysis2 = round($groupPercent[1] +  $groupPercent[2] + $groupPercent[3]). '%';
    	    $this->view->q2Analysis3 = 'of your peers already have or have plans for a single customer database.';
    	} elseif ($myGroup == 1) { //plan 2+3 %
    	    $this->view->q2Analysis1 = 'You ' . $mySelection[0]['option'];
    	    $this->view->q2Analysis2 = round($groupPercent[2] + $groupPercent[3]) . '%';
    	    $this->view->q2Analysis3 = 'of your peers are implementing or already have a single customer database.';    	    
    	} else { // Already 2+3 %
    	    $this->view->q2Analysis1 = 'You ' . $mySelection[0]['option'];
    	    $this->view->q2Analysis2 = round($groupPercent[2] + $groupPercent[3]) . '%';
    	    $this->view->q2Analysis3 = 'of your peers are implementing or already have a single customer database.';    	    
    	}

    	//////////////////////////////////////////////////////////////////////////
    	//{Enter the answer value of this quesiton: "You don't have enough organizational support to start moving to a single customer database" or "You have not considered moving to a single customer database" or "You are uncertain about having a single customer database"}.  
    	//[xx%] of your peers already has or plans to implement a single customer database.
    	// END OF Q2
    	//////////////////////////////////////////////////////////////////////////  
    	
    	$resultDataQ31 = $this->_q3Calculation($q31Answer, 0, $filterField, $filterData);
    	$resultDataQ32 = $this->_q3Calculation($q32Answer, 1, $filterField, $filterData);
    	$resultDataQ33 = $this->_q3Calculation($q33Answer, 2, $filterField, $filterData);
    	$resultDataQ34 = $this->_q3Calculation($q34Answer, 3, $filterField, $filterData);
    	$resultDataQ35 = $this->_q3Calculation($q35Answer, 4, $filterField, $filterData);    	    	    	    	

    	$mergeData = $this->_calculateMergedData($resultDataQ31, $resultDataQ32, $resultDataQ33, $resultDataQ34, $resultDataQ35);
    	
    	$outputHTML3 = "<p><table border=1><tr><td colspan=3>Question #3</td></tr>";
    	$outputHTML3 .= "<tr><td>Group</td><td>Count</td><td>Percent</td></tr>";
    	$outputHTML3 .= "<tr><td>0(No Plan)</td><td>N/A</td><td>".round($mergeData['groupPercent'][0])."%</td></tr>";
    	$outputHTML3 .= "<tr><td>1(Planned)</td><td>N/A</td><td>".round($mergeData['groupPercent'][1])."%</td></tr>";
    	$outputHTML3 .= "<tr><td>2(Implemented)</td><td>N/A</td><td>".round($mergeData['groupPercent'][2])."%</td></tr>";
    	$outputHTML3 .= "<tr><td>Total</td><td>N/A<td>".round($mergeData['groupPercent'][0]+$mergeData['groupPercent'][1]+$mergeData['groupPercent'][2])."%</td></tr>";
    	$outputHTML3 .= "<tr><td>&nbsp;</td><td>Group</td><td>Index</td></tr>";
    	$outputHTML3 .= "<tr><td>You</td><td>".$mergeData['myGroup']."</td><td>".$mergeData['myRank']."</td></tr>";
    	$outputHTML3 .= "<tr><td>Median</td><td>".$mergeData['medianGroup']."</td><td>".$mergeData['medianRank']."</td></tr>";
    	$outputHTML3 .= "</table>";
    	
    	// .5 to .747*t
    	if (abs($mergeData['myRank'] - $mergeData['medianRank']) < 10) { // median group
    		$myPercent = 100;
    		$benchmarkAngle = .747;
    		$surveyAngle = .747;
    		 
    	} elseif ($mergeData['myGroup'] > $mergeData['medianGroup']) { // more than 100%
    		$myPercent = 100 + ((($mergeData['myRank'] - $mergeData['medianRank']) / count($mergeData['rank'])) * 100);
    		$benchmarkAngle = .247 * (200 - $myPercent)/100 + .5;
    		$surveyAngle = .747;
    		 
    	} else { // less than 100%
    		$myPercent = 100 - ((($mergeData['medianRank'] - $mergeData['myRank']) / count($mergeData['rank'])) * 100);
    		$benchmarkAngle = .747;
    		$surveyAngle = .247 * $myPercent/100 + .5;
    		 
    	}
    	
    	
    	$this->view->q3BenchmarkAngle = $benchmarkAngle;
    	$this->view->q3SurveyAngle = $surveyAngle;
    	$this->view->q3MyPercent = round($myPercent);

    	$analysisTexts = array(
    			'already' => array(),
    			'consider' => array(),
    	);
    	    	
    	if ($resultDataQ31['myGroup'] == 0) {
    	    $analysisTexts['consider'][] = 'Dashboard';
    	} else {
    	    $analysisTexts['already'][] = 'Dashboard';
    	}

    	if ($resultDataQ32['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Web Analytics';
    	} else {
    		$analysisTexts['already'][] = 'Web Analytics';
    	}
    	
    	if ($resultDataQ33['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Text Analytics';
    	} else {
    		$analysisTexts['already'][] = 'Text Analytics';
    	}

    	if ($resultDataQ34['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Predictive Analytics';
    	} else {
    		$analysisTexts['already'][] = 'Predictive Analytics';
    	}

    	if ($resultDataQ35['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Location Analytics';
    	} else {
    		$analysisTexts['already'][] = 'Location Analytics';
    	}    	
    	
    	if ($mergeData['myRank']/count($mergeData['rank'])*100 < 40) { //below average
    		$this->view->q3Analysis1_1 = 'Your utilization of advanced analytics is below average.';
    		//$this->view->q3Analysis1_2 = $mergeData['groupPercent'][1] + $mergeData['groupPercent'][2]. '%';
    		$this->view->q3Analysis1_2 = (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$this->view->q3Analysis1_3 = 'of your peers are leveraging more advanced analytics.';
    	} elseif ($mergeData['myRank']/count($mergeData['rank'])*100 <  40 && $mergeData['myRank']/count($mergeData['rank'])*100 > 60) {
    		$this->view->q3Analysis1_1 = 'Your utilization of advanced analytics is on average.';
    		$this->view->q3Analysis1_2 = (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$this->view->q3Analysis1_3 = 'of your peers are leveraging more advanced analytics.';
    	} else {
    		$this->view->q3Analysis1_1 = 'Your utilization of advanced analytics is above average.';
    		$this->view->q3Analysis1_2 = round($mergeData['myRank']/count($mergeData['rank'])*100). '%';
    		$this->view->q3Analysis1_3 = 'of your peers are leveraging less advanced analytics.';
    	}

   		//////////////////////////////////////////////////////////////////////////
   		//{Enter the answer value of this quesiton: "You don't have enough organizational support to start moving to a single customer database" or "You have not considered moving to a single customer database" or "You are uncertain about having a single customer database"}.
   		//[xx%] of your peers already has or plans to implement a single customer database.
   		// END OF Q3
   		//////////////////////////////////////////////////////////////////////////

   		$resultDataQ41 = $this->_q4Calculation($q41Answer, 0, $filterField, $filterData);
   		$resultDataQ42 = $this->_q4Calculation($q42Answer, 1, $filterField, $filterData);
   		$resultDataQ43 = $this->_q4Calculation($q43Answer, 2, $filterField, $filterData);
   		$resultDataQ44 = $this->_q4Calculation($q44Answer, 3, $filterField, $filterData);
   		$resultDataQ45 = $this->_q4Calculation($q45Answer, 4, $filterField, $filterData);
   		
   		$mergeData = $this->_calculateMergedData($resultDataQ41, $resultDataQ42, $resultDataQ43, $resultDataQ44, $resultDataQ45);
   		
   		$outputHTML4 = "<p><table border=1><tr><td colspan=3>Question #3</td></tr>";
   		$outputHTML4 .= "<tr><td>Group</td><td>Count</td><td>Percent</td></tr>";
   		$outputHTML4 .= "<tr><td>0(No Plan)</td><td>N/A</td><td>".round($mergeData['groupPercent'][0])."%</td></tr>";
   		$outputHTML4 .= "<tr><td>1(Planned)</td><td>N/A</td><td>".round($mergeData['groupPercent'][1])."%</td></tr>";
   		$outputHTML4 .= "<tr><td>2(Implemented)</td><td>N/A</td><td>".round($mergeData['groupPercent'][2])."%</td></tr>";
   		$outputHTML4 .= "<tr><td>Total</td><td>N/A<td>".round($mergeData['groupPercent'][0]+$mergeData['groupPercent'][1]+$mergeData['groupPercent'][2])."%</td></tr>";
   		$outputHTML4 .= "<tr><td>&nbsp;</td><td>Group</td><td>Index</td></tr>";
   		$outputHTML4 .= "<tr><td>You</td><td>".$mergeData['myGroup']."</td><td>".$mergeData['myRank']."</td></tr>";
   		$outputHTML4 .= "<tr><td>Median</td><td>".$mergeData['medianGroup']."</td><td>".$mergeData['medianRank']."</td></tr>";
   		$outputHTML4 .= "</table>";
   		   		
   		// .75 to .997*t
   		if (abs($mergeData['myRank'] - $mergeData['medianRank']) < 10) { // median group
   			$myPercent = 100;
   			$benchmarkAngle = .997;
   			$surveyAngle = .997;
   			 
   		} elseif ($mergeData['myGroup'] > $mergeData['medianGroup']) { // more than 100%
   			$myPercent = 100 + ((($mergeData['myRank'] - $mergeData['medianRank']) / count($mergeData['rank'])) * 100);
   			//$benchmarkAngle = .497 * (200 - $myPercent)/100;
   			$benchmarkAngle = .247 * (200 - $myPercent)/100 + .75;
   			$surveyAngle = .997;
   			 
   		} else { // less than 100%
   			$myPercent = 100 - ((($mergeData['medianRank'] - $mergeData['myRank']) / count($mergeData['rank'])) * 100);
   			$benchmarkAngle = .997;
   			//$surveyAngle = .497 * $myPercent/100;
   			$surveyAngle = .247 * $myPercent/100 + .75;
   			 
   		}
   		 
   		$this->view->q4BenchmarkAngle = $benchmarkAngle;
   		$this->view->q4SurveyAngle = $surveyAngle;
   		$this->view->q4MyPercent = round($myPercent);
   		
   		$analysisTexts = array(
   				'already' => array(),
   				'plan'=> array(),
   				'consider' => array(),
   		);
   		
   		if ($resultDataQ41['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Email';
   		} elseif($resultDataQ41['myGroup'] == 1) {
   			$analysisTexts['plan'][] = 'Email';
   		} else {
   		    $analysisTexts['already'][] = 'Email';
   		}
   		
   		if ($resultDataQ42['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Online/Web';
   		} elseif($resultDataQ42['myGroup'] == 1) {
   			$analysisTexts['plan'][] = 'Online/Web';
   		} else {
   		    $analysisTexts['already'][] = 'Online/Web';
   		}
   		 
   		if ($resultDataQ43['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Mobile';
   		} elseif($resultDataQ43['myGroup'] == 1) {
   			$analysisTexts['plan'][] = 'Mobile';
   		} else {
   		    $analysisTexts['already'][] = 'Mobile';
   		}
   		
   		if ($resultDataQ44['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Call Center';
   		} elseif($resultDataQ44['myGroup'] == 1) {
   			$analysisTexts['plan'][] = 'Call Center';
   		} else {
   		    $analysisTexts['already'][] = 'Call Center';
   		}
   		
   		if ($resultDataQ45['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'In Store';
   		} elseif($resultDataQ45['myGroup'] == 1) {
   			$analysisTexts['plan'][] = 'In Store';
   		} else {
   		    $analysisTexts['already'][] = 'In Store';
   		}
   		 
        if ($mergeData['myRank']/count($mergeData['rank'])*100 < 40) { //below average
    		$this->view->q4Analysis1_1 = 'Your ability to understand/respond in real time is below average.';
    		//$this->view->q3Analysis1_2 = $mergeData['groupPercent'][1] + $mergeData['groupPercent'][2]. '%';
    		$this->view->q4Analysis1_2 = (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$this->view->q4Analysis1_3 = 'of your peers have better real-time customer engagement capabilities across more interaction channels.';
    	} elseif ($mergeData['myRank']/count($mergeData['rank'])*100 <  40 && $mergeData['myRank']/count($mergeData['rank'])*100 > 60) {
    		$this->view->q4Analysis1_1 = 'Your ability to understand/respond in real time is on average.';
    		$this->view->q4Analysis1_2 = (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$this->view->q4Analysis1_3 = 'of your peers have better real-time customer engagement capabilities across more interaction channels.';
    	} else {
    		$this->view->q4Analysis1_1 = 'Your ability to understand/respond in real time is above average.';
    		$this->view->q4Analysis1_2 = round($mergeData['myRank']/count($mergeData['rank'])*100). '%';
    		$this->view->q4Analysis1_3 = 'of your peers have better real-time customer engagement capabilities across more interaction channels.';
    	}
   		
   		//////////////////////////////////////////////////////////////////////////
   		//{Enter the answer value of this quesiton: "You don't have enough organizational support to start moving to a single customer database" or "You have not considered moving to a single customer database" or "You are uncertain about having a single customer database"}.
   		//[xx%] of your peers already has or plans to implement a single customer database.
   		// END OF Q4
   		//////////////////////////////////////////////////////////////////////////   

   		
   		$this->view->surveyId = $surveyId;
   		$this->view->q1Answer = $q1Answer;
   		$this->view->q2Answer = $q2Answer+1;
   		$this->view->q31Answer = $q31Answer+1;
   		$this->view->q32Answer = $q32Answer+1;
   		$this->view->q33Answer = $q33Answer+1;
   		$this->view->q34Answer = $q34Answer+1;
   		$this->view->q35Answer = $q35Answer+1;
   		$this->view->q41Answer = $q41Answer+1;
   		$this->view->q42Answer = $q42Answer+1;
   		$this->view->q43Answer = $q43Answer+1;
   		$this->view->q44Answer = $q44Answer+1;
   		$this->view->q45Answer = $q45Answer+1;
   		
   		$filterLabels = array(
   						"B2B" => "Busniess-to-business (B2B)",
				   		"B2C" => "Business-to-consumer (B2C)",
				   		"Both" => "Both B2B and B2C",
				   		"1 - 499" => "1 - 499 employees",
				   		"500 - 4999" => "500 - 4999 employees",
				   		"5000 or more" => "5000 or more employees",
				   		"us" => "North America",
				   		"emea" => "EMEA",
				   		"apac" => "APAC",   		   		
   					);
   		
   		$filterValues = array(
   				"B2B" => "1",
   				"B2C" => "2",
   				"Both" => "3",
   				//"1 - 499" => "1,2",
   				"1 - 499" => "3",
   				"500 - 4999" => "3,4",
   				"5000 or more" => "5,6",
   				"us" => "1",
   				"emea" => "2",
   				"apac" => "3",
   		);

   		
   		$this->view->region = $region;
   		$this->view->business_model = $qs2;
   		$this->view->company_size = $qs4;   		
   		$this->view->regionLabel = $filterLabels[$region];
   		$this->view->regionValue = $filterValues[$region];
   		$this->view->businessModelLabel = $filterLabels[$qs2];
   		$this->view->businessModelValue = $filterValues[$qs2];
   		$this->view->companySizeLabel = $filterLabels[$qs4];
   		$this->view->companySizeValue = $filterValues[$qs4];
   		$this->view->currentFilter = empty($filterField) ? '' : $filterField.'_'.$filterData;
   		$this->view->debug = $debug;
   		$this->view->log1 = $outputHTML1;
   		$this->view->log2 = $outputHTML2;
   		$this->view->log3 = $outputHTML3;
   		$this->view->log4 = $outputHTML4;
    }    
    
    
    
    protected function _q1Calculation($answer, $filterField, $filterData)
    {
        $sampleData= array();
        
        if ($answer == 0) {
            $myAnswer = 0;
        } elseif ($answer > 0 && $answer < 11) {
            $myAnswer = 1;
        } elseif ($answer > 10 && $answer < 21) {
            $myAnswer = 2;
        } elseif ($answer > 20 && $answer < 31) {
            $myAnswer = 3;
        } elseif ($answer > 30 && $answer < 41) {
            $myAnswer = 4;
        } elseif ($answer > 40 && $answer < 50) {
            $myAnswer = 5;
        } else {
            $myAnswer = 6;
        }
        
        $sample = new Application_Model_Sample();

        // Merge q5_1, q5_2, q5_3 in the same bucket, $sampleData.
        $q51Data = $sample->getCountByGroup('q5_1', $filterField, $filterData);
        foreach ($q51Data as $q51Info) {
        	if (isset($sampleData[$q51Info['answer']])) {
        		$sampleData[$q51Info['answer']] += $q51Info['total_count'];
        	} else {
        		$sampleData[$q51Info['answer']] = $q51Info['total_count'];
        	}
        }
        
        $q52Data = $sample->getCountByGroup('q5_2', $filterField, $filterData);
        foreach ($q52Data as $q52Info) {
        	if (isset($sampleData[$q52Info['answer']])) {
        		$sampleData[$q52Info['answer']] += $q52Info['total_count'];
        	} else {
        		$sampleData[$q52Info['answer']] = $q52Info['total_count'];
        	}
        }
        
        $q53Data = $sample->getCountByGroup('q5_3', $filterField, $filterData);
        foreach ($q53Data as $q53Info) {
        	if (isset($sampleData[$q53Info['answer']])) {
        		$sampleData[$q53Info['answer']] += $q53Info['total_count'];
        	} else {
        		$sampleData[$q53Info['answer']] = $q53Info['total_count'];
        	}
        }        
        
        return $this->_analyzeSampleData($sampleData, $myAnswer);
    }
    
    /*	Re-arrange samples into 4 buckets
     * 
     *  Bucket 3 [Already implemented a single customer database 1
     *	Bucket 2 [Currently implementing plans to create a single customer database 2
     *	Bucket 1 [Plans to implement in the next 12 month 3
     *	Bucket 0 [Don't have enough organizational support to do so 4
     *	         [Current system is ok 5 NO
     *           [Have not considered moving to a single customer database  6
     *	         [Others 7
     *	         [Don't know 98 NO
     */
    protected function _q2Calculation($answer, $filterField, $filterData)
    {
    	$sampleData= array(0,0,0,0);
    	$sample = new Application_Model_Sample();
    
    	$q7Data = $sample->getCountByGroup('q7', $filterField, $filterData);
    	foreach ($q7Data as $q7Info) {
    		if ($q7Info['answer'] == 4 || $q7Info['answer'] == 5 || 
    		$q7Info['answer'] == 6 || $q7Info['answer'] == 7 || $q7Info['answer'] == 98) {
    			$sampleData[0] += $q7Info['total_count'];
    		} elseif ($q7Info['answer'] == 3) {
    			$sampleData[1] = $q7Info['total_count'];
    		} elseif ($q7Info['answer'] == 2) {
    		    $sampleData[2] = $q7Info['total_count'];
    		} elseif ($q7Info['answer'] == 1) {
    		    $sampleData[3] = $q7Info['total_count'];
    		}
    	}
    
    	if ($answer == 0) {
    	    $myAnswer = 3;
    	} elseif ($answer == 1) {
    	    $myAnswer = 2;    	    
    	} elseif ($answer == 2) {
    	    $myAnswer = 1;    	    
    	} else {
    	    $myAnswer = 0;    	    
    	}
    	
    	return $this->_analyzeSampleData($sampleData, $myAnswer);
    }

    /*	Re-arrange samples into 3 buckets
     *
    *	Bucket 2 [Implemented 4
    *	Bucket 1 [Plans to implement in the next 12 month 3
    *	Bucket 0 [Not Priority 2 NO
    *	         [Not Interested 1 NO
    *	         [Don't know 98 NO
    */    
    protected function _q3Calculation($answer, $rowIndex, $filterField, $filterData)
    {
        $questionVar = array('q18_1','q18_2','q18_3','q18_4','q18_5');
        
    	$sampleData= array(0,0,0);
    	$sample = new Application_Model_Sample();
    
    	$q18Data = $sample->getCountByGroup($questionVar[$rowIndex], $filterField, $filterData);
    	foreach ($q18Data as $q18Info) {
    		if ($q18Info['answer'] == 98 || $q18Info['answer'] == 1 ||
    				$q18Info['answer'] == 2) {
    			$sampleData[0] += $q18Info['total_count'];
    		} elseif ($q18Info['answer'] == 3) {
    			$sampleData[1] = $q18Info['total_count'];
    		} elseif ($q18Info['answer'] == 4) {
    			$sampleData[2] = $q18Info['total_count'];
    		}
    	}
    
    	if ($answer == 4) {
    		$myAnswer = 2;
    	} elseif ($answer == 3) {
    		$myAnswer = 1;
    	} else {
    		$myAnswer = 0;
    	}
    	 
    	return $this->_analyzeSampleData($sampleData, $myAnswer);
    }
    
    /*	Re-arrange samples into 3 buckets
     *
    *	Bucket 2 [Implemented 1
    *			 [Limited 2
    *	Bucket 1 [Plans 3
    *	Bucket 0 [Not Priority 4 NO
    *	         [Don't know 98 NO
    */
    
    protected function _q4Calculation($answer, $rowIndex, $filterField, $filterData)
    {
    	$questionVar = array('q9_1','q9_2','q9_3','q9_4','q9_5');
    
    	$sampleData= array(0,0,0);
    	$sample = new Application_Model_Sample();
    
    	$q9Data = $sample->getCountByGroup($questionVar[$rowIndex], $filterField, $filterData);
    	foreach ($q9Data as $q9Info) {
    		if ($q9Info['answer'] == 4 || $q9Info['answer'] == 98) {
    			$sampleData[0] += $q9Info['total_count'];
    		} elseif ($q9Info['answer'] == 1 || $q9Info['answer'] == 2) {
    			$sampleData[2] += $q9Info['total_count'];
    		} else {
    			$sampleData[1] = $q9Info['total_count'];
    		}
    	}
    
    	if ($answer == 4 || $answer == 3) {
    		$myAnswer = 2;
    	} elseif ($answer == 2) {
    		$myAnswer = 1;
    	} else {
    		$myAnswer = 0;
    	}
    
    	return $this->_analyzeSampleData($sampleData, $myAnswer);
    }    

    
    /**
     * @param unknown_type $sampleData
     * return array of analysis result
     * ------------------------------------------- samples
     *       |               |
     *     myRank        medianRank   
     */
    private function _analyzeSampleData($sampleData, $answer)
    {
        if (empty($sampleData)) {
            return array();
        }
        $ranks = array(); // sorted flat simple array of sample data
        
        $myRank = 0;
        $myStart = 0;
        
        $currentRank = 0;
        foreach ($sampleData as $index => $sampleInfo) {
        	for ($i=0; $i<$sampleInfo; $i++) {
        		$ranks[] = $index;
        	}
        	
        	if ($index == $answer) {
        		$myRank = $currentRank + floor($sampleInfo/2);
        		$myRankStart = $currentRank;
        		$myRankEnd = $currentRank+$sampleInfo;
        	} else {
        		$currentRank += $sampleInfo;
        	}
        		
        }
        
        
        $medianGroup = $ranks[floor(count($ranks)/2)];
        $groupPercent = array();
        $currentRank = 0;
        foreach ($sampleData as $index => $sampleInfo) {
        	if ($index == $medianGroup) {
        		$medianRank = $currentRank + floor($sampleInfo/2);
        	} else {
        		$currentRank += $sampleInfo;
        	}
        	
        	$groupPercent[$index] = $sampleInfo/count($ranks) * 100;
        
        }
        
        return array(
        	'rank' => $ranks,
        	'medianRank' => $medianRank,
        	'medianGroup' => $medianGroup,
        	'myRank' => $myRank,
        	'myGroup' => $answer,
        	'myGroupRange' => array($myRankStart, $myRankEnd),
        	'groupPercent' => $groupPercent,
        	'sampleData' => $sampleData,
        );

    }
    /*
     *  $ranks = $resultData['rank'];
    	$myGroup = $resultData['myGroup'];
    	$myGroupRange = $resultData['myGroupRange'];    	
    	$myRank = $resultData['myRank'];
    	$medianGroup = $resultData['medianGroup'];
    	$medianRank = $resultData['medianRank'];
    	$groupPercent = $resultData['groupPercent'];
     */
    private function _calculateMergedData($resultDataQ31, $resultDataQ32, $resultDataQ33, $resultDataQ34, $resultDataQ35)
    {
        
        $groupPercent = array(
	        round(($resultDataQ31['groupPercent'][0] + $resultDataQ32['groupPercent'][0] + $resultDataQ33['groupPercent'][0] +
	        $resultDataQ34['groupPercent'][0] + $resultDataQ35['groupPercent'][0])/5),
	        round(($resultDataQ31['groupPercent'][1] + $resultDataQ32['groupPercent'][1] + $resultDataQ33['groupPercent'][1] +
	        $resultDataQ34['groupPercent'][1] + $resultDataQ35['groupPercent'][1])/5),
	        round(($resultDataQ31['groupPercent'][2] + $resultDataQ32['groupPercent'][2] + $resultDataQ33['groupPercent'][2] +
	        $resultDataQ34['groupPercent'][2] + $resultDataQ35['groupPercent'][2])/5),
        
        );
        
        return array(
        	'rank' => $resultDataQ31['rank'],
        	'myGroup' => round(($resultDataQ31['myGroup'] + $resultDataQ32['myGroup'] + $resultDataQ33['myGroup'] + 
        					$resultDataQ34['myGroup'] + $resultDataQ35['myGroup'])/5),
        	'myRank' => round(($resultDataQ31['myRank'] + $resultDataQ32['myRank'] + $resultDataQ33['myRank'] + 
        					$resultDataQ34['myRank'] + $resultDataQ35['myRank'])/5),
        	'medianGroup' => round(($resultDataQ31['medianGroup'] + $resultDataQ32['medianGroup'] + $resultDataQ33['medianGroup'] + 
        					$resultDataQ34['medianGroup'] + $resultDataQ35['medianGroup'])/5),
	        'medianRank' => round(($resultDataQ31['medianRank'] + $resultDataQ32['medianRank'] + $resultDataQ33['medianRank'] +
	        		$resultDataQ34['medianRank'] + $resultDataQ35['medianRank'])/5),
	        'groupPercent' => $groupPercent,
        );
    }

}







