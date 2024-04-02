<?php

namespace CustomeModule\RestApiExample\Model;

use CustomeModule\RestApiExample\Api\ProductRepositoryInterface;
use CustomeModule\RestApiExample\Api\Data\ProductInterfaceFactory;
use CustomeModule\RestApiExample\Helper\ProductHelper;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 *  CustomModule API to get Product By ID
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductInterfaceFactory
     */
    private $productInterfaceFactory;

    /**
     * @var ProductHelper
     */
    private $productHelper;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * ProductRepository constructor.
     *
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param ProductInterfaceFactory $productInterfaceFactory
     * @param ProductHelper $productHelper
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        ProductInterfaceFactory $productInterfaceFactory,
        ProductHelper $productHelper
    ) {
        $this->productInterfaceFactory = $productInterfaceFactory;
        $this->productHelper = $productHelper;
        $this->productRepository = $productRepository;
    }

    /**
     * Get Product by its ID
     *
     * @param int $id
     * @return \CustomeModule\RestApiExample\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */
    public function getProductById($id): \CustomeModule\RestApiExample\Api\Data\ProductInterface
    {
        /**
         * @var \CustomeModule\RestApiExample\Api\Data\ProductInterface
         */
        $productInterface = $this->productInterfaceFactory->create();

        try {
            /**
             * @var \Magento\Catalog\Api\Data\ProductInterface
             */
            $product = $this->productRepository->getById($id);
            $productInterface->setId($product->getId());
            $productInterface->setSku($product->getSku());
            $productInterface->setName($product->getName());
            $productInterface->setDescription($product->getDescription() ? : ' ');
            $productInterface->setQuantity($product->getExtensionAttributes()->getStockItem()->getQty());
            $productInterface->setPrice($this->productHelper->formatPrice($product->getPrice()));
            $productInterface->setImage($this->productHelper->getProductImagesArray($product));

            return $productInterface;
        } catch (NoSuchEntityException $e) {
            throw NoSuchEntityException::singleField("id", $id);
        }
    }
}
