<?php
namespace Icecube\OrderReminder\Model\OrderDetail;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Store\Model\ScopeInterface;
use Icecube\OrderReminder\Helper\Data as IcecubeOrderHelper;

/**
 * Class OldOrder
 * @package Icecube\OrderReminder\Model\OrderDetail
 */
class OldOrder
{
   /**
     * @var IcecubeOrderHelper
     */
    protected $IcecubeOrderHelper;

    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * OldOrder constructor.
     *
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param ScopeConfigInterface $scopeConfig
     * @param DateTime $dateTime
     */
    public function __construct(
        OrderCollectionFactory $orderCollectionFactory,
        ScopeConfigInterface $scopeConfig,
        DateTime $dateTime,
        IcecubeOrderHelper $IcecubeOrderHelper,
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory; // Initializing Order Collection Factory
        $this->scopeConfig = $scopeConfig; // Initializing Scope Config
        $this->dateTime = $dateTime; // Initializing DateTime
        $this->IcecubeOrderHelper = $IcecubeOrderHelper;
    }

    /**
     * Get all orders with products created in the last 15 days.
     *
     * @return array
     */
    public function getAllOrdersWithProducts()
    {
        $response = [
            'status' => 'error',
            'message' => ''
        ];
        if ($this->IcecubeOrderHelper->isModuleEnabled()) {
            $numberOfDays = $this->IcecubeOrderHelper->getNumberOfDays();
        }else{
            $response['message'] = 'Error: Icecube_OrderReminder Module Not enable.';
            return $response;   
        }
         
        $currentDate = date('Y-m-d'); // current date
        $specificDate = date('Y-m-d', strtotime("-$numberOfDays days"));        
        $orderCollection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('created_at', ['gteq' => $specificDate . ' 00:00:00'])
            ->addFieldToFilter('created_at', ['lteq' => $currentDate . ' 23:59:59']);

              // Check if any orders are found
            if (!$orderCollection->getSize()) {
                $response['message'] = 'Error: Please enter a valid number of days, there are  ' .$orderCollection->getSize().'  orders to process ' ;
                return $response; 
            }

            $ordersByCustomer = [];
            foreach ($orderCollection as $order) {
                $customerId = $order->getCustomerId() ?: 'guest'; // If customer ID is null, consider it as a guest order
                if (!isset($ordersByCustomer[$customerId]) || $order->getCreatedAt() > $ordersByCustomer[$customerId]->getCreatedAt()) {
                    $ordersByCustomer[$customerId] = $order;
                }
        }

        $results = [];
        foreach ($ordersByCustomer as $order) {
            $result = [
                'Order_ID' => $order->getIncrementId(),
                'Customer_ID' => $order->getCustomerId() ?: 'guest', // If customer ID is null, consider it as a guest order
                'Customer_Email' => $order->getCustomerEmail(),
                'Customer_Firstname' => $order->getCustomerFirstname(),
                'Customer_Lastname' => $order->getCustomerLastname(),
                'Grand_Total' => $order->getGrandTotal(),
                'Store_ID' => $order->getStoreId(),
            ];
            $results[] = $result;
        }
       
        // Return the results
            $response['status'] = 'success';
            $response['message'] = $results;

       return $response; 
    }
}
