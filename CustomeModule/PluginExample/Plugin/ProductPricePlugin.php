<?php

namespace CustomeModule\PluginExample\Plugin;

use Magento\Catalog\Model\Product;
use Psr\Log\LoggerInterface;
use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;

class ProductPricePlugin
{

    protected $productRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    protected $stockRegistry;

    public function __construct(LoggerInterface $logger, StockRegistryInterface $stockRegistry,ProductRepositoryInterface $productRepository)
    {
        $this->logger = $logger;
        $this->stockRegistry = $stockRegistry;
        $this->productRepository = $productRepository;
    }
    





// price update function
    public function afterGetPrice(Product $product, $result)
    {

       // Step 2: Get a list of available methods for the product object
        // $methods = get_class_methods(get_class($product)); // ye function file ke sare function get kar leta he
        //     echo "<pre>";
        //     print_r($methods);
        //     echo "</pre>";
        //     die;
           

        // Get the product ID
        $productId = $product->getId();

        try {
            // Get the product quantity
            $stockItem = $this->stockRegistry->getStockItem($productId);
            $quantity = $stockItem->getQty();
            $stockStatus = $stockItem->getIsInStock() ? 'In Stock' : 'Out of Stock';
            // Check if quantity is less than 50
            if ($quantity > 300) {
                // Perform your custom logic here to modify the product price
                $modifiedPrice = $result * 0.9; // Decrease the price by 10%

                // Log the modification for debugging purposes
                $this->logger->info("Product Modification: Original Price = $result, Modified Price = $modifiedPrice");

        
                // Return the modified price
                return $modifiedPrice;
            }
        } catch (\Exception $e) {
            $this->logger->error("Error loading product ID: $productId - " . $e->getMessage());
        }

        // If the product quantity is 50 or more, return the original price using parent::afterGetPrice()
        return $result;
    }



    public function afterGetName(Product $product, $result)
    {
        $modifyProduct = 1;

        if ($product->getId() == $modifyProduct) {
            $modifiedName = 'New Product Name'; // Replace with the new name you want to set

            // Log the modification for debugging purposes
            $this->logger->info("Product Name Modification: Original Name = $result, Modified Name = $modifiedName");

            // Return the modified name
            return $modifiedName;
        }

        // If the product ID does not match, return the original name using parent::afterGetName()
        return $result;
    }
}

?>