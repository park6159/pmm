<?php

/**
 * @author ChangP
 * Model for survey_variable	
 */
class Application_Model_SurveyVariable extends Zend_Db_Table_Abstract
{

	protected $_name = 'survey_variable';
	protected $_primary = 'id';
		
	public function getLabelByVariable($questionId, $optionId)
	{
		$select = $this->getAdapter()->select()
				->from(array('survey_variable'), array(
						'questionId' => 'qid',
						'valiable' => 'val',
						'option' => 'ui_result',
				));
		$select->where("qid = ?", $questionId);
		$select->where("val = ?", $optionId);
		$result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);

		return $result;
	}
		
}
