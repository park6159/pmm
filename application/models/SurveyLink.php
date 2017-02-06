<?php

/**
 * @author ChangP
 * Model for surveyLink	
 */
class Application_Model_SurveyLink extends Zend_Db_Table_Abstract
{

	protected $_name = 'survey_link';
	protected $_primary = 'id';
	
	
	public function getServeyLinkData()
	{
		$select = $this->getAdapter()->select()
		->from(array('s' => 'survey_link'), array(
				'link_id' => 's.id',
				'campaign_name' => 's.campaign_name',
				'created_by' => 's.created_by',
				'date_created' => 's.date_created',
				'link' => 's.link',																						
		));
		$select->order(array('s.date_created DESC'));
	
		//error_log($select->assemble());
		$result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);
	
		return $result;
	}
	
	public function insertSurveyLinkData($campaignName, $creator)
	{
		$data = array(
			  'campaign_name' => $campaignName,
			  'created_by' => $creator,
			  'date_created' => date('Y-m-d H:i:s'),
			  'link' => $campaignName,
		);
		return $this->insert($data);
	}
		
}
