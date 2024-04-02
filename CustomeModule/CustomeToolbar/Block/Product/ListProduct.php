<?php
namespace CustomeModule\CustomeToolbar\Block\Product;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Model\Category;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Helper\Data as CatalogData;
use Magento\Catalog\Model\Product;
use Magento\Framework\Data\Helper\PostHelper;
use Magento\Framework\Url\Helper\Data as UrlHelper;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Store\Model\StoreManagerInterface;

class ListProduct extends Template
{
    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var Category
     */
    protected $category;

    /**
     * @var CatalogData
     */
    protected $catalogData;

    /**
     * @var PostHelper
     */
    protected $postDataHelper;

    /**
     * @var UrlHelper
     */
    protected $urlHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;

    /**
     * ListProduct constructor.
     *
     * @param Context $context
     * @param CollectionFactory $productCollectionFactory
     * @param Category $category
     * @param CatalogData $catalogData
     * @param PostHelper $postDataHelper
     * @param UrlHelper $urlHelper
     * @param StoreManagerInterface $storeManager
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $data
     */
    public function __construct(
        Context $context,
        CollectionFactory $productCollectionFactory,
        Category $category,
        CatalogData $catalogData,
        PostHelper $postDataHelper,
        UrlHelper $urlHelper,
        StoreManagerInterface $storeManager,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->category = $category;
        $this->catalogData = $catalogData;
        $this->postDataHelper = $postDataHelper;
        $this->urlHelper = $urlHelper;
        $this->storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;

        parent::__construct($context, $data);
    }

    /**
     * Retrieve product collection based on the category ID and sorting criteria.
     *
     * @return Collection
     */
    public function getProductCollection()
    {
        // Get the category ID where products should be loaded from
        $categoryId = 2; // Replace with your category ID

        // Load the category by ID
        $category = $this->categoryRepository->get($categoryId, $this->_storeManager->getStore()->getId());

        // Create a product collection for the category
        $collection = $this->productCollectionFactory->create();
        $collection->addCategoryFilter($category);
        $collection->addAttributeToSelect('*');

        // Add your custom sorting logic here (e.g., sorting by name or price)
        // Example: $collection->addAttributeToSort('name', 'asc');

        return $collection;
    }
}
