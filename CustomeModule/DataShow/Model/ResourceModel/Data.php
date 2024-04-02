<?php
namespace CustomeModule\DataShow\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Data extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{



	public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
    ) {
        parent::__construct($context);
    }
	
	/**
     * Define main table
     */
	protected function _construct()
	{
		$this->_init('student_data', 'news_id');
	}

    


}
?>
