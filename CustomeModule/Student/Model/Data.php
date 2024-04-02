<?php
namespace CustomeModule\Student\Model;


use Magento\Framework\Model\AbstractModel;

class Data extends AbstractModel 
{
	
	const CACHE_TAG = 'customemodule_Student';

	//Unique identifier for use within caching
	protected $_cacheTag = self::CACHE_TAG;

	protected function _construct()
	{
		$this->_init('CustomeModule\Student\Model\ResourceModel\Data');
	}

	public function getIdentities()
	{
		return [self::CACHE_TAG . '_' . $this->getId()];
	}

	public function getDefaultValues()
	{
		$values = [];
		return $values;
	}

}
