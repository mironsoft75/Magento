<?php

namespace CustomeModule\RestApiExample\Api;

use Magento\Framework\Exception\NoSuchEntityException;
/**
 * CustomeModule Api to  get Product by ID
 */

interface ProductRepositoryInterface
{
    /**
     * Get Products by $id
     *
     * 
     * @param int $id
     * @return CustomeModule\RestApiExample\Api\Data\ProductInterface
     * @throws NoSuchEntityException
     */

    public function getProductById($id);


}
