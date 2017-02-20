<?php

/**
 * @author ChangP
 * Model for question	
 */
class Application_Model_Question extends Zend_Db_Table_Abstract
{

	protected $_name = 'question';
	protected $_primary = 'id';
		
	public function getQuestionByLanguage($language=null)
	{
		if (empty($language)) {
			$language = 'US';
		}
		
		$select = $this->select();
		$select->from($this)
		->where('language = ?', $language);
		
		$result = $this->fetchAll($select);
		
		return $result;
	}
		
}
