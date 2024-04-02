<?php

namespace CustomeModule\RestApiExample\Model\Data;

use CustomeModule\RestApiExample\Api\Data\ProductolddataInterface;
use Magento\Framework\DataObject;

class Productolddata extends DataObject implements ProductolddataInterface
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_getData("id");
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id): ProductolddataInterface
    {
        return $this->setData("id", $id);
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->_getData("sku");
    }

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku($sku): ProductolddataInterface
    {
        return $this->setData("sku", $sku);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->_getData("name");
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name): ProductolddataInterface
    {
        return $this->setData("name", $name);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        $description = $this->_getData("description");
        return $description !== null ? (string) $description : '';
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description): ProductolddataInterface
    {
        return $this->setData("description", $description);
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->_getData("price");
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice($price): ProductolddataInterface
    {
        return $this->setData("price", $price);
    }

    /**
     * @return string[]
     */
    public function getImages(): array
    {
        return $this->_getData("images");
    }

    /**
     * @param string[] $productImageArray
     * @return $this
     */
    public function setImages($productImageArray): ProductolddataInterface
    {
        return $this->setData("images", $productImageArray);
    }

// /**
//  * @return string
//  */
// public function getManufacturer(): string
// {
//     return $this->_getData("manufacturer");
// }

// /**
//  * @param string $manufacturer
//  * @return $this
//  */
// public function setManufacturer($manufacturer): ProductolddataInterface
// {
//     return $this->setData("manufacturer", $manufacturer);
// }


    
}
