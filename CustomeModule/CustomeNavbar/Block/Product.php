<?php

namespace CustomeModule\CustomeNavbar\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Product extends Template
{
    protected $productCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function getProductCollection()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('image'); // Fetch only images
        return $productCollection;
    }
    public function getProductImageUrl($product)
    {
        $image = $product->getImage(); // Get image filename
        $url = 'http://ankush.magento.com/media/catalog/product/' . $image; // Use the actual product image path
        return $url;
    }
    
}
