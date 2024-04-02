<?php

namespace CustomeModule\RestApiExample\Model\Data;

use CustomeModule\RestApiExample\Api\Data\ProductInterface;
use Magento\Framework\DataObject;

class Product extends DataObject implements ProductInterface
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
    public function setId($id): ProductInterface
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
    public function setSku($sku): ProductInterface
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
    public function setName($name): ProductInterface
    {
        return $this->setData("name", $name);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->_getData("description");
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description): ProductInterface
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
    public function setPrice($price): ProductInterface
    {
        return $this->setData("price", $price);
    }

    /**
     * @return string[]
     */
    public function getImage(): array
    {
        return $this->_getData("images");
    }

    /**
     * @param string[] $productImageArray
     * @return $this
     */
    public function setImage($productImageArray): ProductInterface
    {
        return $this->setData("images", $productImageArray);
    }

       /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->_getData("quantity");
    }

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity)
    {
        return $this->setData("quantity", $quantity);
    }
}
