<?php

namespace CustomeModule\RestApiExample\Model;

use CustomeModule\RestApiExample\Api\ProductolddataRepositoryInterface;
use CustomeModule\RestApiExample\Api\Data\ProductInterface;
use CustomeModule\RestApiExample\Api\Data\ProductolddataInterfaceFactory;
use Magento\Catalog\Api\ProductRepositoryInterface as MagentoProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use CustomeModule\RestApiExample\Helper\ProductHelper;
use Magento\Framework\Exception\NoSuchEntityException;


class ProductolddataRepository implements ProductolddataRepositoryInterface
{
    /**
     * @var MagentoProductRepositoryInterface
     */
    private $productRepository;


     /**
     * @var ProductHelper
     */
    private $productHelper;

       /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var ProductolddataInterfaceFactory
     */
    private $productolddataInterfaceFactory;


    /**
     * @var productExtensionFactory
     */
    protected $productExtensionFactory;

    /**
     * ProductolddataRepository constructor.
     *
     * @param MagentoProductRepositoryInterface $productRepository
     * @param ProductolddataInterfaceFactory $productolddataInterfaceFactory
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductHelper $productHelper
     */

    public function __construct(
      MagentoProductRepositoryInterface $productRepository,
        ProductolddataInterfaceFactory $productolddataInterfaceFactory,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductHelper $productHelper,
        \Magento\Catalog\Api\Data\ProductExtensionFactory $productExtensionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->productolddataInterfaceFactory = $productolddataInterfaceFactory;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productHelper = $productHelper;
        $this->productExtensionFactory = $productExtensionFactory;

    }



/**
     * Delete a product
     *
     * @param int $productId
     * @return bool|string
     */
    public function deleteProduct($productId)
    {
        try {
            // Product ID se product load karein
            $product = $this->productRepository->getById($productId);
            // Product delete karein
            $this->productRepository->delete($product);
            return json_encode(['success' => true, 'message' => "Product is deleted successfully. Product ID: $productId"]);
        } catch (NoSuchEntityException $e) {
            // Product with the provided ID does not exist
            return json_encode(['success' => false, 'message' => 'Product not found.']);
        } catch (\Exception $e) {
            // Exception handle karein
            return json_encode(['success' => false, 'message' => 'Error deleting product.']);
        }
    }


    /**
     * Get all products
     *
     * @return \CustomeModule\RestApiExample\Api\Data\ProductolddataInterface[]
     */

// update function
     public function updateProduct($productId, ProductInterface $data)
     {
         try {
             // Load the product by ID
             $product = $this->productRepository->getById($productId);
 
             // Update the product data with the provided data

             if (isset($data['name'])) {
                 $product->setName($data['name']);
             }
             
             if (isset($data['description'])) {
                 $product->setDescription($data['description']);
             }

             if (isset($data['sku'])) {
                $product->setSku($data['sku']);
            }

            if (isset($data['price'])) {
                $product->setPrice($data['price']);
            }

             // Update other fields as needed
 
             // Save the updated product
             $this->productRepository->save($product);
              
             // Return the updated product data
             return $this->productolddataInterfaceFactory->create([
                 'data' => [
                     'id' => $product->getId(),
                     'sku' => $product->getSku(),
                     'name' => $product->getName(),
                     'description' => $product->getDescription(),
                     'price' => $this->productHelper->formatPrice($product->getPrice()),
                     'images' => $this->productHelper->getProductImagesArray($product),
                 ],
             ]);
         } catch (\Exception $e) {
             // Handle any exceptions that occurred during update
             return null;
         }
     }

// Read function
    public function getAllProducts()
    {

        $products = [];
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $productCollection = $this->productRepository->getList($searchCriteria);
        foreach ($productCollection->getItems() as $product) {
            $productData = $product->getData();
            $products[] = $productData;
        }
        return $products;




        //   // Build search criteria
        //   $searchCriteria = $this->searchCriteriaBuilder->create();
        //       //   ->addFilter('price', 500, 'gt')
        //      //   ->addFilter('price', 1000, 'lt')

        //   // Get product list
        //   $products = $this->productRepository->getList($searchCriteria);
          
        // $productData = [];

        // foreach ($products->getItems() as $product) {
        //     $productData[] = $this->productolddataInterfaceFactory->create([
        //         'data' => [
        //             'id' => $product->getId(),
        //             'sku' => $product->getSku(),
        //             'name' => $product->getName(),
        //             'description' => $product->getDescription(),
        //             'price' => $this->productHelper->formatPrice($product->getPrice()),
        //             'images' => $this->productHelper->getProductImagesArray($product)
        //             // 'manufacturer' => $product->getManufacturer('manufacturer') // Get the manufacturer attribute value
        //         ],
        //     ]);
        // }

        //  // Convert data to JSON format
        // //  $jsonResponse = json_encode($productData);

        //  return $productData;
    }

    // Add your other helper functions here
    // ...






}
