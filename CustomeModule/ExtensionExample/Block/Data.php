<?php
namespace CustomeModule\ExtensionExample\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Data extends Template
{
    protected $productRepository;

    public function __construct(
        Template\Context $context,
        ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    public function getProductCustomData($sku)
    {
        $product = $this->productRepository->get($sku);
        $extensionAttributes = $product->getExtensionAttributes();
        
        if ($extensionAttributes === null) {
            return null;
        }
        
        $customData = $extensionAttributes->getCustomData();
        $anotherData = $extensionAttributes->getAnotherData(); 
        $thirdData = $extensionAttributes->getThirdData(); 


        $productData = [
            'name' => $product->getName(),
            'id' => $product->getId(),
            'price' => $product->getPrice(),
            'description' => $product->getDescription(),
            'custom_data' => $customData,
            'another_data' => $anotherData,
            'third_data' => $thirdData
        ];
        
        return $productData;

    
        

        // $product = $this->productRepository->get($sku);
        
        // // Get all product attributes
        // $productAttributes = $product->getData();
        
        // // Get custom data using your method
        // $customData = $this->getProductCustomData($sku);
        
        // // Get extension attributes
        // $extensionAttributes = $product->getExtensionAttributes();
        // if ($extensionAttributes !== null) {
        //     $extensionData = $extensionAttributes->getData();
        // } else {
        //     $extensionData = [];
        // }
        
        // // Combine all the data
        // $allProductData = [
        //     'product_attributes' => $productAttributes,
        //     'custom_data' => $customData,
        //     'extension_data' => $extensionData,
        // ];
        
        // return $productAttributes;
        
        

    }
}
