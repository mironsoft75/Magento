<?php
namespace CustomeModule\VertualType\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Helper\AbstractHelper;


class HelperClassA extends AbstractHelper 
{
      
    protected $a;
     
    public function __construct(
    Context $context,$a=10)
    {
          $this->a=$a;
          parent::__construct($context);
    }

    public function getResult(){
        return $this->a;
    }
}
?>