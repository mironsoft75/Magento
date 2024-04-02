<?php
namespace CustomeModule\PluginExample\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class CustomProductCartCount implements ObserverInterface
{
    protected $customProductCartCountFactory;

    public function __construct(
        \CustomeModule\PluginExample\Model\CustomProductCartCountFactory $customProductCartCountFactory
    ) {
        $this->customProductCartCountFactory = $customProductCartCountFactory;
    }

    public function execute(Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        $productId = $product->getId();
        $sku = $product->getSku();
        $productName = $product->getName();
        $price = $product->getPrice();

        // Current date and time
        $currentTime = date('Y-m-d H:i:s');

     
        // Save the data to custom_product_cart_count table
        $customProductCartCount = $this->customProductCartCountFactory->create();
        $customProductCartCount->setData([
            'product_id' => $productId,
            'sku' => $sku,
            'product_name' => $productName,
            'price' => $price,
            'created_at' => $currentTime,
        ]);
        $customProductCartCount->save();
    }
}
