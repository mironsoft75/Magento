<?php
// CustomeModule\PluginExample\Helper\ProductQuantity.php

namespace CustomeModule\PluginExample\Helper;

use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class ProductQuantity
{
    protected $stockRegistry;

    public function __construct(
        StockRegistryInterface $stockRegistry
    ) {
        $this->stockRegistry = $stockRegistry;
    }

    // getProductQuantity() function: Is function se product ki quantity prapt karein.
    public function getProductQuantity($productId)
    {
        try {
            $stockItem = $this->stockRegistry->getStockItem($productId);
            return $stockItem->getQty();
        } catch (NoSuchEntityException $e) {
            // Product nahi mila, toh null return karein.
            return null;
        }
    }
}
