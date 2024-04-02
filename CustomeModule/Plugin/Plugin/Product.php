<?php
// File: app/code/Custom/Module/Plugin/Product.php

namespace CustomeModule\Plugin\Plugin;

class Product
{
    /**
     * Add extra amount to the product price.
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param float $result
     * @return float
     */
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        // Add an extra amount to the product price
        $extraAmount = 50.00;
        return $result + $extraAmount;
    }
}
