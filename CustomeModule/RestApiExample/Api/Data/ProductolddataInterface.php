<?php
// CustomeModule\RestApiExample\Api\Data\ProductolddataInterface.php

namespace CustomeModule\RestApiExample\Api\Data;

interface ProductolddataInterface
{
    /**
     * Get product ID
     *
     * @return int
     */
    public function getId();

    /**
     * Get product SKU
     *
     * @return string
     */
    public function getSku();

    /**
     * Get product name
     *
     * @return string
     */
    public function getName();

    /**
     * Get product description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Get product price
     *
     * @return string
     */
    public function getPrice();

    /**
     * Get product images
     *
     * @return string[]
     */
    public function getImages();

//     /**
//  * Get product manufacturer
//  *
//  * @return string
//  */
// public function getManufacturer();
}


?>