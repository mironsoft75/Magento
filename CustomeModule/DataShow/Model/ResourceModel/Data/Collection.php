<?php
namespace CustomeModule\DataShow\Model\ResourceModel\Data;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'news_id';
	
	protected $_eventPrefix = 'news_data_collection';

    protected $_eventObject = 'data_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('CustomeModule\DataShow\Model\Data', 'CustomeModule\DataShow\Model\ResourceModel\Data');
	}
}
?>