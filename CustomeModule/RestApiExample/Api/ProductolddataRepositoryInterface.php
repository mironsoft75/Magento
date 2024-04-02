<?php

namespace CustomeModule\RestApiExample\Api;

interface ProductolddataRepositoryInterface
{
    /**
     * Get all products
     *
     * @return \CustomeModule\RestApiExample\Api\Data\ProductolddataInterface[]
     */
    public function getAllProducts();



    
    /**
     * Update a product
     *
     * @param int $productId
     * @param array $data
     * @return \CustomeModule\RestApiExample\Api\Data\ProductolddataInterface|null
     */
    public function updateProduct($productId, \CustomeModule\RestApiExample\Api\Data\ProductInterface $data);


    
    /**
     * Delete a product
     *
     * @param int $productId
     * @return bool
     */
    public function deleteProduct($productId);



}
