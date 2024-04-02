<?php
namespace LearnStructure\MagentoStructure\Model\ResourceModel\MagentoForm;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
	
	protected $_eventPrefix = 'magento_form_collection';

    protected $_eventObject = 'magentoform_collection';
	
	/**
     * Define model & resource model
     */
	protected function _construct()
	{
		$this->_init('LearnStructure\MagentoStructure\Model\MagentoForm', 'LearnStructure\MagentoStructure\Model\ResourceModel\MagentoForm');
	}
}
?>
