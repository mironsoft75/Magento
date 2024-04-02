<?php
namespace CustomeModule\News\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;


class HelperClassA extends AbstractHelper 
{
      
    // protected $helperClassB;
    
    // public function __construct(
    //     \CustomeModule\News\Helper\HelperClassB $helperClassB,Context $context)
    // {
    //   $this->helperClassB=$helperClassB;
    //   parent :: __construct($context);
    // }


    // public function calculateResult(){
    //     return $this->helperClassB->getVariableA()." + ".$this->helperClassB->getVariableB()." = ". ($this->helperClassB->getVariableA()+$this->helperClassB->getVariableB());
    // }
	public function  calculateResult(\CustomeModule\News\Helper\HelperClassB $helpeClassB){
        return $helpeClassB->getVariableA()." + ".$helpeClassB->getVariableB()." = ". ($helpeClassB->getVariableA()+$helpeClassB->getVariableB());
    }
}
?>