<?php
declare(strict_types=1);

namespace CustomeModule\News\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;



class DeliveryMessage implements ArgumentInterface
{

   public function getMessage() : string {
    return "This is the view modual of the product";
   }

}

?>