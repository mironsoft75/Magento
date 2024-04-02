<?php
namespace LearnStructure\MagentoStructure\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class MagentoForm extends AbstractDb
{
    protected $_idFieldName = 'id'; // Set your primary key field name here

    protected function _construct()
    {
        $this->_init('Learn_magento', 'id');
    }

}
