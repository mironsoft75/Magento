<?php
namespace Icecube\Export\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;

class ExportProducts
{
    protected $productCollectionFactory;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function getAllProducts()
    {
        $products = [];
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        foreach ($productCollection as $product) {
            $status = $product->getStatus();
            if ($status == 2) {
                $status = 0;
            } 
            $products[] = [
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'status' => $status,
                'price' => $product->getPrice(),
                'special_price' => $product->getSpecialPrice(),
                'special_price_from_date' => $product->getSpecialFromDate() ? date('Y-m-d', strtotime($product->getSpecialFromDate())) : '',
                'special_price_to_date' => $product->getSpecialToDate() ? date('Y-m-d', strtotime($product->getSpecialToDate())) : ''
            ];
        }
        return $products;
    }
}
