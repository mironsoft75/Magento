<?php
namespace Chapagain\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Controller\Result\JsonFactory;

class Ajaxload extends Action
{
    protected $pageFactory;
    protected $categoryFactory;
    protected $productCollectionFactory;
    protected $resultJsonFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CategoryFactory $categoryFactory,
        CollectionFactory $productCollectionFactory,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
        $this->categoryFactory = $categoryFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $categoryId = 15; // Category ID 15
        $category = $this->categoryFactory->create()->load($categoryId);
        $products = $this->productCollectionFactory->create()
            ->addCategoryFilter($category)
            ->addAttributeToSelect(['name', 'description','price' , 'short_description']);

        $html = '<ul>';
        foreach ($products as $product) {
             // Thumbnail Image URL
            $html .= '<li>';
            $html .= '<strong>Name:</strong> ' . $product->getName() . '<br>';
            $html .= '<strong>Description:</strong> ' . $product->getDescription();
            $html .= '<strong>Price:</strong> ' . $product->getPrice();
            $html .= '</li>';
        }
        $html .= '</ul>';

        $result = $this->resultJsonFactory->create();
        return $result->setData(['html' => $html]);
    }
}

