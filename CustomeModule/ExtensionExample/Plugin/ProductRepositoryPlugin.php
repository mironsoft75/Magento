<?php

namespace CustomeModule\ExtensionExample\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;

class ProductRepositoryPlugin
{
    public function afterGet(ProductRepositoryInterface $subject, $result, $sku)
{
    $extensionAttributes = $result->getExtensionAttributes();
    if ($extensionAttributes === null) {
        $extensionAttributes = $this->extensionFactory->create();
    }

    $extensionAttributes->setCustomData("This is a extension attribute");
    $extensionAttributes->setAnotherData("This is second attribute");
    $extensionAttributes->setThirdData("This is third attrubute");
    $result->setExtensionAttributes($extensionAttributes);

    return $result;
}


}