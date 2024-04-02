<?php
namespace CustomeModule\PluginExample\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;
use  CustomeModule\PluginExample\Model\Page\PageName;


class Student extends Template
{
    protected $resourceConnection;
    protected $PageName;


    public function __construct(
        Template\Context $context,
        ResourceConnection $resourceConnection,
        \CustomeModule\PluginExample\Model\Page\PageName $PageName,
        array $data = []
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->PageName = $PageName;
        parent::__construct($context, $data);
    }

    public function pagetitleobj(){
        return $this->PageName;
    }

    public function getStudents()
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('customemodule_student'); // Replace 'customemodule_student' with your table name

        $select = $connection->select()->from($tableName);

        return $connection->fetchAll($select);
    }
}

