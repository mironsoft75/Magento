<?php

namespace Icecube\CategoryUrlRewrite\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\UrlRewrite\Model\UrlRewriteFactory;
use Magento\UrlRewrite\Model\ResourceModel\UrlRewriteCollectionFactory;
use Magento\Catalog\Model\Product;

class DisableProductUrlRewrite implements ObserverInterface
{
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
     * @param UrlRewriteFactory $urlRewriteFactory
     * @param UrlRewriteCollectionFactory $urlRewriteCollectionFactory
     */
    public function __construct(
        UrlRewriteFactory $urlRewriteFactory,
        UrlRewriteCollectionFactory $urlRewriteCollectionFactory
    ) {
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
            $productId = $observer->getData('product')->getId();
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
