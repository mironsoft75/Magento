<?php
namespace CustomeModule\CustomeNavbar\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Registry;

class CategoryNav extends Template
{
    protected $categoryFactory;
    protected $categoryCollectionFactory;
    protected $registry;

    public function __construct(
        Template\Context $context,
        CategoryFactory $categoryFactory,
        CollectionFactory $categoryCollectionFactory,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->categoryFactory = $categoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->registry = $registry;
    }

    public function getCategoryCollection()
    {
        $rootCategoryId = 2; // Change this to your root category ID
        $category = $this->categoryFactory->create()->load($rootCategoryId);
        $subCategories = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('*')
            ->addIdFilter($category->getChildren())
            ->addIsActiveFilter();
             // var_dump($subCategories->getData()); die;
        return $subCategories;
    }

    public function getBreadcrumbs()
    {
        $breadcrumbs = '';
        
        $category = $this->getCurrentCategory();
        while ($category && $category->getId() > 2) {
            $breadcrumbs = '<li class="item"><a href="' . $category->getUrl() . '">' . $category->getName() . '</a></li>' . $breadcrumbs;
            $category = $this->categoryFactory->create()->load($category->getParentId());
        }

        return $breadcrumbs;
    }

    protected function getCurrentCategory()
    {
        return $this->registry->registry('current_category');
    }
}
