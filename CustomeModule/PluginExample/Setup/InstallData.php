<?php

namespace CustomeModule\PluginExample\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    protected $date;
 
    public function __construct(
        \Magento\Framework\Stdlib\DateTime\DateTime $date
    ) {
        $this->date = $date;
    }
    
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $dataNewsRows = [
            [
                'product_id' => 1,
                'sku' => 'sku',
                'product_name' => 'first',
                'price' => 200
            ],
            [
                'product_id' => 3,
                'sku' => 'sku 3',
                'product_name' => 'Thired',
                'price' => 300
            ]
        ];
        
        foreach($dataNewsRows as $data) {
            $setup->getConnection()->insert($setup->getTable('custom_product_cart_count'), $data);
        }
    }
}
?>