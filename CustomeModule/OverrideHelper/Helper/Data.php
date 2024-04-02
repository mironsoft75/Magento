<?php

namespace CustomeModule\OverrideHelper\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends \Magento\Catalog\Helper\Data
{
   
    public function getCustomMessage()
    {
       return "this is helper";
    }
}




