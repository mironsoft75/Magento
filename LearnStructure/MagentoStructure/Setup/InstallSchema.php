<?php
namespace LearnStructure\MagentoStructure\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;


class InstallSchema implements InstallSchemaInterface
{
    
  public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
  {
      
    $learnmagento = $setup->getTable('Learn_magento');

    if($setup->getConnection()->isTableExists($learnmagento) != true) {

      $newTable = $setup->getConnection()
          ->newTable($learnmagento)
          ->addColumn(
              'id',
              Table::TYPE_INTEGER,
              null,
              ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
              'News ID'
          )
          ->addColumn(
              'name',
              Table::TYPE_TEXT,
              255,
              ['nullable' => false, 'default' => ''],
                'Title'
          )
          ->setComment("Learn magento");

      $setup->getConnection()->createTable($newTable);
    }
  }
}
?>
