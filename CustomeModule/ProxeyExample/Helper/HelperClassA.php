<?php
namespace CustomeModule\ProxeyExample\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;


class HelperClassA extends AbstractHelper 
{
       
    public function __construct(
    Context $context)
    {
        echo "start here";
       for ($i=1; $i<1000000000; $i++) { 
          
       }

        echo "End here";

        
          parent::__construct($context);
    }

    public function getResult(){
        return "This is getResultFuntion";
    }
}
?>