<?php
namespace CustomeModule\PluginExample\Model;

use Magento\Framework\Model\AbstractModel;

class CustomProductCartCount extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\CustomeModule\PluginExample\Model\ResourceModel\CustomProductCartCount::class);
    }
}
