<?php

/**
 * @author ChangP
 * Model for survey	
 */
class Application_Model_Survey extends Zend_Db_Table_Abstract
{

	protected $_name = 'survey';
	protected $_primary = 'responseid';

	public function getServeyByLink($link)
	{
		$select = $this->select();
		$select->from($this)
				->where('permanent_url_key = ?', $link)
				->order('responseid DESC')
				->limit(1);
		
		$result = $this->fetchRow($select);
		return $result;
	}
	
	public function getServeyData($start=null, $limit=null, $orderBy=null)
	{
		$select = $this->getAdapter()->select()
		->from(array('s' => 'survey'), array(
				'responseid' => 's.responseid',
				'ip_source' => 's.ip_source',
				'date_created' => 's.date_created',
				'business_model' => 's.qs2',
				'company_size' => 's.qs4',
				'region' => 's.region',
				'q1' => 's.q5',
				'q2' => 's.q7',
				'q3_dashboard' => 's.q18_1',
				'q3_web' => 's.q18_2',
				'q3_text' => 's.q18_3',
				'q3_predictive' => 's.q18_4',
				'q3_location' => 's.q18_5',
				'q4_email' => 's.q1_1',
				'q4_online' => 's.q1_2',
				'q4_mobile' => 's.q1_3',
				'q4_callcenter' => 's.q1_4',
				'q4_store' => 's.q1_5',
				'first_name' => 's.first_name',
				'last_name' => 's.last_name',		
				'email' => 's.email',
				'company_name' => 's.company_name',
				'job_title' => 's.job_title',												
				'phone' => 's.phone',												
				'state' => 's.state',	
				'key' => 's.url_key',
		));
		$select->order(array('s.date_created DESC'));
		if (!empty($limit)) {
		    $select->limit($limit, $start);
		}
		
	
		//error_log($select->assemble());
		$result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);
	
		return $result;
	}
	
	public function getAllSurveys()
	{
		$select = $this->select();
		$select->from($this);
		$result = $this->fetchAll($select);
		return $result;
	}
	
	public function insertSurveyData($ipSource, $region, $qs2, $qs4, 
	$q11, $q12, $q13, $q14, $q15, 
	$q5, $q7, $q181, $q182, $q183, 
	$q184, $q185, $key)
	{
		$data = array(
			  'ip_source' => $ipSource,
			  'region' => $region,
			  'qs2' => $qs2,
			  'qs4' => $qs4,
			  'q1_1' => $q11,
			  'q1_2' => $q12,
			  'q1_3' => $q13,
			  'q1_4' => $q14,
			  'q1_5' => $q15,
			  'q5' => intval($q5),
			  'q7' => $q7,
			  'q18_1' => $q181,
			  'q18_2' => $q182,
			  'q18_3' => $q183,
			  'q18_4' => $q184,
			  'q18_5' => $q185,
			  'url_key' => $key,
		);
		return $this->insert($data);
	}
	
	public function updateSurveyData($surveyId, $first_name, $last_name, $email, $company_name,
			$job_title, $phone, $state, $disclosure, $permenantKey)
	{
		$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'company_name' => $company_name,
				'job_title' => $job_title,
				'phone' => $phone,
				'state' => $state,
				'disclosure' => $disclosure,
				'permanent_url_key' => $permenantKey,
		);
		
		$where = array($this->getAdapter()->quoteInto('responseid = ?', $surveyId));
		return $this->update($data, $where);
	}
	
	public function getCountByGroup($groupField, $filterField=null, $filterData=null)
	{
		$select = $this->getAdapter()->select()
				->from(array('sample'), array(
						'answer' => "$groupField",
						'total_count' => new Zend_Db_Expr('COUNT(responseid)'),
				));
		$select->where("$groupField != ?", 98);
		if (!is_null($filterField)) {
		    $select->where("$filterField = ?", $filterData);
		}
		$select->group($groupField);
		$result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);

		return $result;
	}
		
}
