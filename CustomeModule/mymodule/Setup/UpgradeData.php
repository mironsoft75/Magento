<?php
namespace CustomeModule\mymodule\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\DB\Ddl\Table;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * Upgrade data for the module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '3.0.1', '<')) {
            $this->updateData($setup);
        }

        $setup->endSetup();
    }

    /**
     * Update data in the table
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    private function updateData(ModuleDataSetupInterface $setup)
    {
        $connection = $setup->getConnection();

        $tableName = $setup->getTable('student_data'); // Replace with your table name

        $data = [
            [
                'news_id' => 1, // Assuming primary key column name is 'news_id'
                'title' => 'Updated News Title 1',
                'StudentName' => 'Updated mohankarchandlala  1',
                'description' => 'Here is the updated news description 1',
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'news_id' => 2,
                'title' => 'Updated News Title 2',
                'StudentName' => 'Updated panna lal  2',
                'description' => 'Here is the updated news description 2',
                'status' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        foreach ($data as $item) {
            $where = ['news_id = ?' => $item['news_id']];
            $connection->update($tableName, $item, $where);
        }
    }
}
