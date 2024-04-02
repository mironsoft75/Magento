<?php
 
namespace CustomeModule\OverrideModel\Model\Rewrite\Catalog;
 
class Product extends \Magento\Catalog\Model\Product
{    
    public function getCustomProductInfo()
    {
        return "This is a custom product information.";
    }

    public function getPrice()
    {
        // Add custom logic to modify the price before returning
        $originalPrice = parent::getPrice();
        $discountedPrice = $originalPrice + 200; // Assume a flat discount of 10
        return $discountedPrice;
    }
}
?>