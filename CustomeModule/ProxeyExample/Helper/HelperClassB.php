<?php
namespace CustomeModule\ProxeyExample\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;


class HelperClassB extends HelperClassA
{
      
    
     
    public function __construct(
    Context $context)
    {
        echo "start B here";
       for ($i=1; $i<1000000000; $i++) { 
          
       }

        echo "End B here";

        
          parent::__construct($context);
    }

    public function getResult(){
        return "This  is HelperClass b Function";
    }
}
?>