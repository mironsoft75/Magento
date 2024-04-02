<?php

namespace CustomeModule\RestApiExample\Api\Data;

interface ProductInterface
{

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getSku();

    /**
     * @param string $sku
     * @return $this
     */
    public function setSku($sku);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getPrice();

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * @return string[]
     */
    public function getImage();

    /**
     * @param string[] $productImageArray
     * @return $this
     */
    public function setImage($productImageArray);


    
    /**
     * @return int
     */
    public function getQuantity(): int;

    /**
     * @param int $quantity
     * @return $this
     */
    public function setQuantity($quantity);
    
}
