<?php
namespace CustomeModule\mymodule\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\App\ResourceConnection;

class Student extends Template
{
    protected $resourceConnection;

    public function __construct(
        Template\Context $context,
        ResourceConnection $resourceConnection,
        array $data = []
    ) {
        $this->resourceConnection = $resourceConnection;
        parent::__construct($context, $data);
    }

    public function getStudents()
    {
        $connection = $this->resourceConnection->getConnection();
        $tableName = $this->resourceConnection->getTableName('customemodule_student'); // Replace 'customemodule_student' with your table name

        $select = $connection->select()->from($tableName);

        return $connection->fetchAll($select);
    }
}
