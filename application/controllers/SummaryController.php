<?php

class SummaryController extends Zend_Controller_Action
{

    public function init()
    {
    	$this->_helper->layout()->setLayout('layout');
    }
    
    public function indexAction()
    {
        $debug = isset($_REQUEST["debug"]) ? $_REQUEST["debug"] : null;

        if (is_null($debug)) {
            $link = isset($_REQUEST["link"]) ? $_REQUEST["link"] : null;
            
            if ($link != null) {
                $survey = new Application_Model_Survey();
                $sData = $survey->getServeyByLink($link);

                if (!empty($sData->responseid)) {
                    $surveyId = $sData->responseid;
                    $q1Answer = $sData->q5;
                    $q2Answer = $sData->q7;
                    $q31Answer = $sData->q18_1;
                    $q32Answer = $sData->q18_2;
                    $q33Answer = $sData->q18_3;
                    $q34Answer = $sData->q18_4;
                    $q35Answer = $sData->q18_5;
                    $q41Answer = $sData->q1_1;
                    $q42Answer = $sData->q1_2;
                    $q43Answer = $sData->q1_3;
                    $q44Answer = $sData->q1_4;
                    $q45Answer = $sData->q1_5;
                    $first_name = $sData->first_name;
                    $last_name = $sData->last_name;
                    $email = $sData->email;
                    $company_name = $sData->company_name;
                    $job_title = $sData->job_title;
                    $phone = $sData->phone;
                    $state = $sData->state;
                    
                    $region = $sData->region;
                    $qs2 = $sData->qs2;
                    $qs4 = $sData->qs4;
                    $disclosure = $sData->disclosure;
                    $filter = null;
                }

                
            } else {

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
                $first_name = isset($_POST["first_name"]) ? $_POST["first_name"] : null;
                $last_name = isset($_POST["last_name"]) ? $_POST["last_name"] : null;
                $email = isset($_POST["email"]) ? $_POST["email"] : null;
                $company_name = isset($_POST["company_name"]) ? $_POST["company_name"] : null;
                $job_title = isset($_POST["job_title"]) ? $_POST["job_title"] : null;
                $phone = isset($_POST["phone"]) ? $_POST["phone"] : null;
                $state = isset($_POST["state"]) ? $_POST["state"] : null;
                
                $region = isset($_POST["region"]) ? $_POST["region"] : null;
                $qs2 = isset($_POST["business_model"]) ? $_POST["business_model"] : null;
                $qs4 = isset($_POST["company_size"]) ? $_POST["company_size"] : null;
                $disclosure = isset($_POST["disclosure"]) ? $_POST["disclosure"] : null;
                $filter = isset($_POST["filter"]) ? $_POST["filter"] : null;
            }

            
        } else {
            $surveyId = 1;            
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
            $first_name = isset($_REQUEST["first_name"]) ? $_REQUEST["first_name"] : null;
            $last_name = isset($_REQUEST["last_name"]) ? $_REQUEST["last_name"] : null;
            $email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : null;
            $company_name = isset($_REQUEST["company_name"]) ? $_REQUEST["company_name"] : null;
            $job_title = isset($_REQUEST["job_title"]) ? $_REQUEST["job_title"] : null;
            $phone = isset($_REQUEST["phone"]) ? $_REQUEST["phone"] : null;
            $state = isset($_REQUEST["state"]) ? $_REQUEST["state"] : null;            
            
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
        $TotalPercentile = 0;
        
        $survey = new Application_Model_Survey();
        
        $permenantKey = md5($surveyId.$q1Answer.$q2Answer.$q31Answer.$q32Answer.$q41Answer.$q42Answer.$first_name.$last_name.$email.$company_name.$job_title.$phone.$state);

        
        $survey->updateSurveyData($surveyId, $first_name, $last_name, $email, $company_name, 
        $job_title, $phone, $state, $disclosure, $permenantKey);
        
        
    	$resultData = $this->_q1Calculation($q1Answer, $filterField, $filterData);  	
    	
    	if (empty($resultData)) {
    		$filterField = null;
    		$filterData = null;
    		$resultData = $this->_q1Calculation($q1Answer, $filterField, $filterData);
    	}
    	
    	//error_log(print_r($resultData, true));
    	$ranks = $resultData['rank'];
    	$myGroup = $resultData['myGroup'];
    	$myGroupRange = $resultData['myGroupRange'];
    	$myRank = $resultData['myRank'];
    	$medianGroup = $resultData['medianGroup'];
    	$medianRank = $resultData['medianRank'];
    
    	if ($myGroup == $medianGroup) { //equal
    		$myPercent = 100;
    		$benchmarkAngle = 1;
    		$surveyAngle = 1;
    		
    		$benchmarkResult = 'You have ' . $q1Answer . ' number of customer interaction systems. ' . 
    		round(($myGroupRange[1] - $myGroupRange[0] + 1) / count($ranks) * 100) . 
    		'% of your peers have similar number of systems.';
    		
    		
    		$recommendation = "<br><br>Evaluate the customer journey to see if all relevant interaction channels are being 
    		leveraged to engage customers throughout the entire journey.<br><br>
    		Consider developing customer programs or mobile apps that helps to identify and capture	
    		customer behavioral or preference information in exchange for useful information or 
    		other services that customers would value.";
    		    			
    	} elseif ($myGroup > $medianGroup) { //above
    		$myPercent = 100 + ((($myRank - $medianRank) / count($ranks)) * 100);
    		$benchmarkAngle = (200 - $myPercent)/100;
    		$surveyAngle = 1;
    		
    		$benchmarkResult = 'You have ' . $q1Answer . ' number of customer interaction systems. ' .
    		round($resultData['myPercentile']) . 
    		'% of your peers have smaller number of systems.';
    		
    		$recommendation = "<br><br>Evalute the customer journey to see if the right mix of interaction channels are beling 
    		utilized to engage with customers throughout the entire journey. <br><br>
    		Consider innovative customer programs or mobile apps that helps to identify and capture	
    		in-depth customer behavioral information in exchange for useful information or 
    		other services that customers would value.";
    			
    	} else { //below
    		$myPercent = 100 - ((($medianRank - $myRank) / count($ranks)) * 100);
    		$benchmarkAngle = 1;
    		$surveyAngle = $myPercent/100;
    		
    		$benchmarkResult = 'You have ' . $q1Answer . ' number of customer interaction systems. ' .
    		round((count($ranks)-($myGroupRange[1]+1)) / count($ranks) * 100) . 
    		'% of your peers have greater number of systems.';
    		
    		$recommendation = "<br><br>Consider adding additional customer interaction channels such as appropriate social media channels 
    		or mobile apps to extend and enhance your customer engagements.<br><br>
    		Evaluate customer programs that helps to identify customers and capture behavior 
    		or preference information in exchange for useful information, loyalty points, or discounts that customers would value.";
    		
    	}

    	$TotalPercentile +=  $resultData['myPercentile'];
    	
    	$this->view->q1BenchmarkAngle = $benchmarkAngle;
    	$this->view->q1SurveyAngle = $surveyAngle;
    	$this->view->q1MyPercent = round($myPercent);
    	$this->view->q1Analysis = 'of Average';
    	$this->view->q1Analysis2 = 'Response';
    	$this->view->q1BenchmarkResult = $benchmarkResult;
    	$this->view->q1Recommendation = $recommendation;
    	
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
    	
    	error_log(print_r($resultData, true));
    	$surveyVariable = new Application_Model_SurveyVariable();
    	$mySelection = $surveyVariable->getLabelByVariable('q2',  $q2Answer);
    	    	
    	if ($myGroup == $medianGroup) { //avg
    		$myPercent = 100;
    		$benchmarkAngle = 1;
    		$surveyAngle = 1;
    		if ($myGroup == 0) { // no plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] . ". " . 
    		    round($groupPercent[1] +  $groupPercent[2] + $groupPercent[3]). 
    		    '% of your peers already have or have plans for a single customer database.';   

    		    $recommendation = "<br><br>Get ahead of your peers by prioritizing your efforts for a single customer database. 
    		    It's the first step in gaining deeper customer insights and enabling you to deliver personalized customer experiences. ";
    		} elseif ($myGroup == 1) { // have plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] .". " . 
    		    round($groupPercent[2] + $groupPercent[3]).
    		    '% of your peers are implementing or already have a single customer database.';
    		    
    		    $recommendation = "<br><br>Having a conslidated customer database will be the key in getting deeper customer insights.<br><br>
    		    Get ahead of your peers, don't try to tackle all data sources, prioritize implicit customer data sources 
    		    like online behavioral data and customer sentiment information. These implicit data sources can provide stronger 
    		    indication of customer interests and intent. ";
    		    
    		} else { //already or doing it
    		    $benchmarkResult = "You are building a single customer database or have already achieved it. " .
    		    round($groupPercent[2] +  $groupPercent[3]) ."% of your peers also are implementing or already have a single customer database.";
    		    $recommendation = "<br><br>Get a head of your peers by evaluating implicit data sources that will provide insights 
    		    into more immediate customer intent; such as unstructured data from customer emails, service ticket forms, 
    		    voice recordings.  Text analytics or sentiment analytics can evaluate these unstructured data sources 
    		    and provide you insights into customer sentiments and the key topics of interest. ";
    		    
    		}
    	} elseif ($myGroup > $medianGroup) { //above
    		$myPercent = 100 + ((($myRank - $medianRank) / count($ranks)) * 100);
    		$benchmarkAngle = (200 - $myPercent)/100;
    		$surveyAngle = 1;
    		if ($myGroup == 0) { // no plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] .". ";
    		    /*
    		    round($groupPercent[1] +  $groupPercent[2] + $groupPercent[3]).
    		    '% of your peers already have or have plans for a single customer database.';
    		    */
    		    $recommendation = "<br><br>Most of your peers ". round($groupPercent[0]) . "% have no plans for a single customer view<br><br>
    		    Move ahead of your peers by prioritizing your efforts for a single customer database. 
    		    It's the first step in gaining deeper customer insights and enabling you to deliver personalized customer experiences.";
    		} elseif ($myGroup == 1) { // have plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] .". " . 
    		    round($groupPercent[2] + $groupPercent[3]).
    		    '% of your peers are implementing or already have a single customer database.';
    		    
    		    $recommendation = "<br><br>Move ahead of your peers by achieving a consolidated view of your customers.  
    		    Its the key step in gaining deeper customer insights and being able to 
    		    deliver individualized offers and recommendations.";
    		    
    		} else { //already or doing it
    		    $benchmarkResult = "You are on your way to building a single customer database or have already achieved it. " .
    		    		round($groupPercent[2] +  $groupPercent[3]) ."% of your peers also are implementing or already have a single customer database.";
    		    $recommendation = "<br><br>Stay ahead of your peers by evaluating implicit data sources that will provide insights into more 
    		    immediate customer intent; such as unstructured data from customer emails, service ticket forms, 
    		    voice recordings.  Text analytics or sentiment analytics can evaluate these unstructured data 
    		    sources and provide insights into customer sentiments and the key topics of interest.";    		    
    		    
    		}    		 
    	} else { //below
    		$myPercent = 100 - ((($medianRank - $myRank) / count($ranks)) * 100);
    		$benchmarkAngle = 1;
    		$surveyAngle = $myPercent/100;
    		if ($myGroup == 0) { // no plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] .". " . 
    		    round($groupPercent[1] +  $groupPercent[2] + $groupPercent[3]).
    		    '% of your peers already have or have plans for a single customer database.';  
    		    
    		    $recommendation = "<br><br>Prioritize consolidating customer information into a single consolidated view.  
    		    It's the first step in gaining deeper customer insights and enabling you to deliver personalized customer experiences. ";
    		} elseif ($myGroup == 1) { // have plan
    		    $benchmarkResult = 'You ' . $mySelection[0]['option'] .". " . 
    		    round($groupPercent[2] + $groupPercent[3]).
    		    '% of your peers are implementing or already have a single customer database.';

    		    $recommendation = "<br><br>Having a conslidated customer database is a foundation for gaining deeper customer insights.<br><br>
    		    Don't try to tackle all data sources, prioritize implicit customer data sources like online behavioral data 
    		    and customer sentiment information. These implicit data sources can provide stronger indication of customer interests and intent. ";
    		} else { //already or doing it
    		    $benchmarkResult = "You are on your way to building a single customer database or have already achieved it. " . 
    		    round($groupPercent[2] +  $groupPercent[3]) ."% of your peers also are implementing or already have a single customer database.";
    		    
    		    $recommendation = "<br><br>Consider implicit data sources that will provide insights into more immediate customer intent; 
    		    such as unstructured data from customer emails, service ticket forms, voice recordings.  
    		    Text analytics or sentiment analytics can evaluate these unstructured data sources and provide you 
    		    insights into customer sentiments and the key topics of interest.";
    		}    		 
    	}

    	$TotalPercentile +=  $resultData['myPercentile'];
    	
    	$this->view->q2BenchmarkAngle = $benchmarkAngle;
    	$this->view->q2SurveyAngle = $surveyAngle;
    	$this->view->q2MyPercent = round($myPercent);
    	$this->view->q2MyGroup = $myGroup;    	
    	$this->view->q2Analysis = 'of Average';
    	$this->view->q2Analysis2 = 'Response';
    	$this->view->q2BenchmarkResult = $benchmarkResult;
    	$this->view->q2Recommendation = $recommendation;

    	

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
    	
    	if (abs($mergeData['myRank'] - $mergeData['medianRank']) < 10) { 
    		$myPercent = 100;
    		$benchmarkAngle = 1;
    		$surveyAngle = 1;
    		 
    	} elseif ($mergeData['myGroup'] > $mergeData['medianGroup']) { 
    		$myPercent = 100 + ((($mergeData['myRank'] - $mergeData['medianRank']) / count($mergeData['rank'])) * 100);
    		$benchmarkAngle = (200 - $myPercent)/100;
    		$surveyAngle = 1;
    		 
    	} else { 
    		$myPercent = 100 - ((($mergeData['medianRank'] - $mergeData['myRank']) / count($mergeData['rank'])) * 100);
    		$benchmarkAngle = 1;
    		$surveyAngle = $myPercent/100;
    		 
    	}
    	
    	if ($mergeData['myRank']/count($mergeData['rank'])*100 < 40) { //below average
    		$analysisText = 'Your utilization of advanced analytics is below average compared to your peers. ';
    		$analysisText .= (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$analysisText .= ' of your peers are leveraging more level of advanced analytics.';
    	} elseif ($mergeData['myRank']/count($mergeData['rank'])*100 <  40 && $mergeData['myRank']/count($mergeData['rank'])*100 > 60) {
    		$analysisText = 'Your utilization of advanced analytics is on average compared to your peers. ';
    		$analysisText .= (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
    		$analysisText .= ' of your peers are leveraging more level of advanced analytics.';
    	} else {
    		$analysisText = 'Your utilization of advanced analytics is above average compared to your peers. ';
    		$analysisText .= round($mergeData['myRank']/count($mergeData['rank'])*100). '%';
    		$analysisText .= ' of your peers are leveraging less level of advanced analytics.';
    	}
    	  	
    	$benchmarkResult = $analysisText;
    	
    	$analysisTexts = array(
    			'already' => array(),
    			'consider' => array(),
    	);
    	
    	$recommendation = "";
    	
    	if ($resultDataQ31['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Dashboard';
    		$recommendation .= "<li><b>Dashboard</b> provides simple and quick insight into your operations 
    		and marketing performances all in one place.</li>";
    		
    	}
    	
    	if ($resultDataQ32['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Web Analytics';
    		$recommendation .= "<li><b>Web Analytics</b> will help to measure and analyze online traffic and customer 
    		behavior patterns to determine the best content for your website.</li>";    		
    	}
    	 
    	if ($resultDataQ33['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Text Analytics';
    		$recommendation .= "<li><b>Text Analytics</b> can convert unstructured data sources into customer's sentiments. 
    		Consider leveraging text analytics to decipher emails, online reviews, tweets, call center agent notes, and
    		other unstructured data sources into valuable customer insights.</li>";    		
    	}
    	
    	$predictiveAnalytics = 'Yes';
    	if ($resultDataQ34['myGroup'] == 0) {
    	    $predictiveAnalytics = 'No';
    		$analysisTexts['consider'][] = 'Predictive Analytics';
    		$recommendation .= "<li><b>Predictive analytics</b> can help to optimize your targeting and to determine the best products,
    		offers and the channel to connect with your audiences.</li>";    		
    	}
    	
    	if ($resultDataQ35['myGroup'] == 0) {
    		$analysisTexts['consider'][] = 'Location Analytics';
    		$recommendation .= "<li><b>Location Analytics</b> provides real-time location information, foot-traffic trends and patterns 
    		insights. Its ability to fill in an organization's analytical blind spot is making it a hot topic in big data.</li>";    		
    	}
    	 
    	if ($recommendation == "") {
    	    $recommendation .= "Look out for cognitive computing capabiilties to help make sense of 
    	    big data problems and enable them to turn it into actionable insight.";
    	} else {
    	    $recommendation = "<ul>". $recommendation . "</ul>";
    	}
    	
    	if (!empty($analysisTexts['consider'])) {
    		$benchmarkResult .= ' Consider investing  further into following analytics to gain more indepth customer insights.';
    	} else {
    	    $benchmarkResult = "You are focused on all level of analytic capabilties. "
    	    . (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)) . "% of your peers have similar levels of advance analytic capabilities. 
    	    Ensure that these insights are incorporated into optimizing customer engagement strategies.";
    	}

    	$TotalPercentile +=  $resultData['myPercentile'];
    	     	
    	$this->view->q3BenchmarkAngle = $benchmarkAngle;
    	$this->view->q3SurveyAngle = $surveyAngle;
    	$this->view->q3MyPercent = round($myPercent);
    	$this->view->q3Analysis = 'of Average';
    	$this->view->q3Analysis2 = 'Response';
    	$this->view->q3BenchmarkResult = $benchmarkResult;
    	$this->view->q3Recommendation = $recommendation;    	

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
   		   		

   		if (abs($mergeData['myRank'] - $mergeData['medianRank']) < 10) { // median group
   			$myPercent = 100;
   			$benchmarkAngle = 1;
   			$surveyAngle = 1;
   			 
   		} elseif ($mergeData['myGroup'] > $mergeData['medianGroup']) { // more than 100%
   			$myPercent = 100 + ((($mergeData['myRank'] - $mergeData['medianRank']) / count($mergeData['rank'])) * 100);
   			$benchmarkAngle = (200 - $myPercent)/100;
   			$surveyAngle = 1;
   			 
   		} else { // less than 100%
   			$myPercent = 100 - ((($mergeData['medianRank'] - $mergeData['myRank']) / count($mergeData['rank'])) * 100);
   			$benchmarkAngle = 1;
   			$surveyAngle = $myPercent/100;
   			 
   		}
   		 
   		if ($mergeData['myRank']/count($mergeData['rank'])*100 < 40) { //below average
   			$analysisText = 'Your ability to understand/respond in real time is below average compared to your peers. ';
   			$analysisText .= (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
   			$analysisText .= ' of your peers have better real-time customer engagement capabilities across channels.';
   		} elseif ($mergeData['myRank']/count($mergeData['rank'])*100 <  40 && $mergeData['myRank']/count($mergeData['rank'])*100 > 60) {
   			$analysisText = 'Your ability to understand/respond in real time is on average compared to your peers. ';
   			$analysisText .= (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)). '%';
   			$analysisText .= ' of your peers have better real-time customer engagement capabilities across channels.';
   		} else {
   			$analysisText = 'Your ability to understand/respond in real time is above average compared to your peers. ';
   			$analysisText .= round($mergeData['myRank']/count($mergeData['rank'])*100). '%';
   			$analysisText .= ' of your peers have better real-time customer engagement capabilities across channels.';
   		}
   		
   		$benchmarkResult = $analysisText;
   		 
   		$analysisTexts = array(
   				'already' => array(),
   				'consider' => array(),
   		);
   		 
   		$recommendation = "";
   		 
   		if ($resultDataQ41['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Email';
   			$recommendation .= "<li><b>Email</b> 3.57% is the overall industry benchmarket for email 
   			click through rates (<a href='http://blog.getresponse.com/the-state-of-email-marketing-by-industry.html' target='the-state-of-email-marketing-by-industry' target='state-of-email'>Source: Getresponse</a>).  Improve your overall email response rate with 
   			dynamic personalization that's based on real-time inishgts into customer's interests and needs.</li>";
   		}
   		 
   		if ($resultDataQ42['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Online/Web';
   			$recommendation .= "<li><b>Online/Web</b> <a href='https://econsultancy.com/blog/65866-how-do-product-recommendations-influence-buyer-behavior?utm_medium=email&utm_source=Econsultancy&utm_campaign=5112301_1527-daily-pulse-us-2014-12-08&dm_i=LQI,31KOD,GU70SK,AXS5E,1' target='utm_campaign'>Econsultancy report</a> reveals that 77% of online shopper admit to having 
   			made additional purchases based on personalized product recommendations.  Improve your web conversions by 
   			leveraging real-time customer intent to personalize online engagements.</li>";
   		}
   		
   		if ($resultDataQ43['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Mobile';
   			$recommendation .= "<li><b>Mobile</b> Don't get left behind, mobile is one the 
   			key investment areas for many organizations.<br>
   			<a href='http://www-01.ibm.com/common/ssi/cgi-bin/ssialias?subtype=FY&infotype=PM&htmlfid=GBF03065USEN&attachment=GBF03065USEN.PDF' target='infotype'>IBM research</a> shows that 85% of marketers indicated that mobile apps are one of the 
   			customer engagement initiatives companies are implementing within the next 12 months.</li>";
   		}
   		 
   		if ($resultDataQ44['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'Call Center';
   			$recommendation .= "<li><b>Call Center</b> <a href='http://customerexperienceboard.org/programs/4/context-commerce-customer-best-practices-to-exceed-expectations' target='exceed-expectations'>CMO Council research</a> shows that nearly half (47%) marketers 
   			indicate that when there is a problem, in digital channel engagements, 
   			they pick up the phone and want immediate human attention.</li>";
   		}
   		 
   		if ($resultDataQ45['myGroup'] == 0) {
   			$analysisTexts['consider'][] = 'In Store';
   			$recommendation .= "<li><b>In Store</b> Delivering great customer engagements is only good as 
   			the weakest link in customer interaction channels. Often times the in store experience 
   			lacks the same real-time insights to drive personalized interactions 
   			as digital channels. Invest in technologies and customer programs that enable you to identify customers in store. Consider 
   			loyalty programs or other programs that provides value exchange for customers to identify themselves, and gain 
   			behavioral insights.</li>";
   		}
   		
   		if ($recommendation == "") {
   		    /*
   			$recommendation .= "Look out for cognitive computing capabiilties to help make sense of
    	    big data problems and enable them to turn it into actionable insight.";
    	    */
   		} else {
   			$recommendation = "<ul>". $recommendation . "</ul>";
   		}
   		 
   		if (!empty($analysisTexts['consider'])) {
   			$benchmarkResult .= ' Consider leveraging these following channels to deliver real-time personalized customer engagements.';
   		} else {
   		    $myPercent = 112;
   			$benchmarkResult = "You are well on your way in delivering contextual customer experience across the key interaction channels. "  
   			. (100 - round($mergeData['myRank']/count($mergeData['rank'])*100)) . "% of your peers have similar real-time engagement capabilities across channels.";
   			
   		}
   		
   		$TotalPercentile +=  $resultData['myPercentile'];
   		 
   		$this->view->q4BenchmarkAngle = $benchmarkAngle;
   		$this->view->q4SurveyAngle = $surveyAngle;
   		$this->view->q4MyPercent = round($myPercent);
    	$this->view->q4Analysis = 'of Average';
    	$this->view->q4Analysis2 = 'Response';
   		$this->view->q4BenchmarkResult = $benchmarkResult;
   		$this->view->q4Recommendation = $recommendation;  
   		
   		$this->view->businessModelValue = $qs2;
   		$this->view->predictiveAnalytics = $predictiveAnalytics;
   		
   		$this->view->overallScore = round($TotalPercentile/4);
   		$this->view->company = $company_name;
   		$this->view->email = $email;
   		
   		$this->view->permenantKey = $permenantKey;
   		 		 		
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
        $myPercentile = 0;
        
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
        	if ($index <= $answer) {
        	    $myPercentile = $myPercentile + $groupPercent[$index];
        	}
        
        }
        
        return array(
        	'rank' => $ranks,
        	'medianRank' => $medianRank,
        	'medianGroup' => $medianGroup,
        	'myRank' => $myRank,
        	'myGroup' => $answer,
        	'myPercentile' => $myPercentile,
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






