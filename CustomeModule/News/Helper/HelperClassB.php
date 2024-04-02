<?php
namespace CustomeModule\News\Helper;

use Magento\Framework\App\Helper\AbstractHelper;


class HelperClassB extends AbstractHelper 
{
     protected $a;
     protected $b;

     public function setVariableA($a){
         return $this->a=$a;
     }

     public function setVariableB($b){
        return  $this->b=$b;
    }

    
    public function getVariableA(){
        return $this->a;
    }

    public function getVariableB(){
       return  $this->b;
   }
}
?>