<?php
namespace Icecube\Export\Model;

use Magento\Framework\App\ResourceConnection;
use Magento\Customer\Model\CustomerFactory;

class ExportCustomers
{
    protected $resource;
    protected $connection;
    protected $_customerFactory;

    public function __construct(
        ResourceConnection $resource,
        CustomerFactory $customerFactory
    ) {
        $this->resource = $resource;
        $this->connection = $resource->getConnection();
        $this->_customerFactory = $customerFactory;
    }

    public function getAllCustomers()
    {
        $customers = [];
        $customerCollection = $this->getCustomerCollection();
        foreach ($customerCollection as $customer) {
            $customers[] = [
                'email' => $customer->getEmail(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'company' => $customer->getCompany()
            ];
        }
        return $customers;
    }

    protected function getCustomerCollection()
    {
        $collection = $this->_customerFactory->create()->getCollection()
            ->addAttributeToSelect("*")
            ->joinAttribute('company', 'customer_address/company', 'default_billing', null, 'left')
            ->load();
        return $collection;
    }
}
