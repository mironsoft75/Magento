<?php
namespace Icecube\CategoryUrlRewrite\Model;
use Magento\Catalog\Model\Category;
class CategoryUrlPathGenerator extends \Magento\CatalogUrlRewrite\Model\CategoryUrlPathGenerator
{
     /**
     * Build category URL path
     *
     * @param \Magento\Catalog\Api\Data\CategoryInterface|\Magento\Framework\Model\AbstractModel $category
     * @param null|\Magento\Catalog\Api\Data\CategoryInterface|\Magento\Framework\Model\AbstractModel $parentCategory
     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getUrlPath($category, $parentCategory = null)
    {
        if ($category->getParentId() === Category::TREE_ROOT_ID) {
            return '';
        }

        $path = $category->getUrlPath();
        if ($path !== null && !$category->dataHasChangedFor('url_key') && !$category->dataHasChangedFor('parent_id')) {
            return $path;
        }

        $path = $category->getUrlKey();
        if ($path === false) {
            return $category->getUrlPath();
        }

        return $path;
    }

}
