<?php
namespace ProdcutBreadcrumbs\FullPathBreadcrumbs\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\App\Request\Http;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\UrlRewrite\Model\UrlFinderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\UrlInterface;

class Crumbblock extends \Magento\Framework\View\Element\Template
{
    protected $_catalogData = null;
    protected $registry;
    protected $_request;
    protected $_categoryFactory;
    protected $urlFinder;
    protected $_storeManager;
    protected $categoryRepository;
    protected $urlBuilder;
    protected $subCategoryIds;

    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        Http $request,
        CollectionFactory $categoryFactory,
        UrlFinderInterface $urlFinder,
        StoreManagerInterface $storeManager,
        CategoryRepositoryInterface $categoryRepository,
        UrlInterface $urlBuilder,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->registry = $registry;
        $this->_request = $request;
        $this->_categoryFactory = $categoryFactory;
        $this->urlFinder = $urlFinder;
        $this->_storeManager = $storeManager;
        $this->categoryRepository = $categoryRepository;
        $this->urlBuilder = $urlBuilder;

        parent::__construct($context, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->getSubCategoryIds();
        return $this;
    }

    public function getSubCategoryIds()
    {
        $categories = $this->_categoryFactory->create();
        $categories->addAttributeToSelect('*');
        $subCategoryIds = [];

        foreach ($categories as $category) {
            $subCategoryIds[] = $category->getId();
        }

        $this->subCategoryIds = $subCategoryIds;
        return $this;
    }

    public function getSubCategoryUrls()
    {
        $subCategoryUrls = [];

        foreach ($this->subCategoryIds as $subCategoryId) {
            try {
                $category = $this->categoryRepository->get($subCategoryId);
                $categoryUrl = $this->urlBuilder->getUrl($category->getUrlPath());
                $subCategoryUrls[$subCategoryId] = $categoryUrl;
            } catch (\Exception $e) {
                $subCategoryUrls[$subCategoryId] = null;
            }
        }

        $url_without_last_slash = [];
        foreach ($subCategoryUrls as $value) {
            try {
                // Remove specified parameters from the URL and add ".html"
                $url_without_params = str_replace(["/custome_parameter", "/product_from_categorypage","/product_from_c"], "", $value);
                // $url_without_params = str_replace("/custome_parameter", "", str_replace("/product_from_categorypage", "", str_replace("/product_from_c", "", $value)));
                $url_without_last_slash[] = rtrim($url_without_params, '/') . ".html";
            } catch (\Exception $e) {
                // Handle exception if there's an error in URL processing
                $url_without_last_slash[] = null;
            }
        }

        try {
            // Check if the category URL matches the referer URL
            $isCategoryUrl = $this->isCategoryUrl($url_without_last_slash);
        } catch (\Exception $e) {
            // Handle exception if there's an error in checking category URL
            $isCategoryUrl = false;
        }

        return $isCategoryUrl;
    }

    public function isCategoryUrl($url_without_last_slash)
    
    {
        
     
        $refererUrl = $this->_request->getServer('HTTP_REFERER');
       
        $questionMarkPosition = strpos($refererUrl, "?");
        // If "?" exists, remove everything after it
        if ($questionMarkPosition !== false) {
            $refererUrl = substr($refererUrl, 0, $questionMarkPosition);
        }
        $refererUrl = str_replace(["/custome_parameter", "/product_from_categorypage","/product_from_c"], "", $refererUrl);
        foreach ($url_without_last_slash as $url) {
            if ($url == $refererUrl) {
                return true;  // Match found, return true
            }
        }

        return false;  // No match found, return false
    }

    public function getCrumbs()
    {
        $evercrumbs = [];

        $evercrumbs[] = [
            'label' => 'Home',
            'title' => 'Go to Home Page',
            'link' => $this->_storeManager->getStore()->getBaseUrl()
        ];

        $path = $this->_catalogData->getBreadcrumbPath();
        $homePageUrl = $this->_storeManager->getStore()->getBaseUrl();

        $product = $this->registry->registry('current_product');
        $categoryCollection = clone $product->getCategoryCollection();
        $categoryCollection->clear();
        $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_DESC)
            ->addAttributeToFilter('path', ['like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"]);
        // $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_ASC)->addAttributeToFilter('path', array('like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"));
        // $categoryCollection->addAttributeToSort('level', $categoryCollection::SORT_ORDER_ASC)
        // ->addAttributeToFilter('path', array('like' => "1/" . $this->_storeManager->getStore()->getRootCategoryId() . "/%"))
        // ->addAttributeToFilter('level', 3); // Adjust the level value as per your requirement
        $categoryCollection->setPageSize(1);
        $breadcrumbCategories = $categoryCollection->getFirstItem()->getParentCategories();

        foreach ($breadcrumbCategories as $category) {
            $evercrumbs[] = [
                'label' => $category->getName(),
                'title' => $category->getName(),
                'link' => $category->getUrl()
            ];
        }

        $evercrumbs[] = [
            'label' => $product->getName(),
            'title' => $product->getName(),
            'link' => ''
        ];

        return $evercrumbs;
    }
}
