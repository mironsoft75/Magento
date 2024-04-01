<?php

namespace Icecube\CategoryUrlRewrite\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;


class DisableCategoryUrlRewrite implements ObserverInterface
{
    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;
       /**
     * @var UrlRewriteFactory
     */
    protected $urlRewriteFactory;

    /**
     * @var UrlRewriteCollectionFactory
     */
    protected $urlRewriteCollectionFactory;
    /**
     * Constructor
     *
     * @param ProductRepository $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        UrlRewriteFactory $urlRewriteFactory,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->urlRewriteFactory = $urlRewriteFactory;
        $this->urlRewriteCollectionFactory = $urlRewriteCollectionFactory;
    }

    /**
     * Execute observer
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $categoryId = $observer->getData('category')->getId();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('category_id', $categoryId)
            ->create();
        $productCollection = $this->productRepository->getList($searchCriteria);
        $associatedProductIds = [];
        foreach ($productCollection->getItems() as $product) {
            $associatedProductIds[] = $product->getId();
        }
        
        foreach ($associatedProductIds as $productId) {
            $targetPathPrefix = "catalog/product/view/id/$productId/category/";
            $urlRewriteCollection = $this->urlRewriteCollectionFactory->create()
            ->addFieldToFilter('entity_type', 'product')
            ->addFieldToFilter('entity_id', $productId)
            ->addFieldToFilter('target_path', ['like' => "$targetPathPrefix%"]);
            $urlRewriteCount = $urlRewriteCollection->getSize();
            foreach ($urlRewriteCollection as $urlRewrite) {
                $urlRewrite->delete();
            }
        }
    }
}
