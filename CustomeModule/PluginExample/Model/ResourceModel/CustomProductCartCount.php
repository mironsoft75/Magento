<?php
namespace CustomeModule\PluginExample\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomProductCartCount extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('custom_product_cart_count', 'entity_id');
    }
}
