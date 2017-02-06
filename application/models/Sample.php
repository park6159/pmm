<?php

/**
 * @author ChangP
 * Model for sample	
 */
class Application_Model_Sample extends Zend_Db_Table_Abstract
{

	protected $_name = 'sample';
	protected $_primary = 'responseid';
		
	public function getCountByGroup($groupField, $filterField=null, $filterData=null)
	{
		$select = $this->getAdapter()->select()
				->from(array('sample'), array(
						'answer' => "$groupField",
						'total_count' => new Zend_Db_Expr('COUNT(responseid)'),
				));
		$select->where("$groupField != ?", 98);
		if (!is_null($filterField)) {
		    if ($filterField == 'qs2') {
		        $select->where("$filterField IN ($filterData)");
		    } else {
		        $select->where("$filterField = ?", $filterData);
		    }
		    
		}
		$select->group($groupField);
		$result = $this->getAdapter()->fetchAll($select, NULL, Zend_Db::FETCH_ASSOC);

		return $result;
	}
		
}
