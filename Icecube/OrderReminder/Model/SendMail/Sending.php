<?php
namespace Icecube\OrderReminder\Model\SendMail;

use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\TemplateTypesInterface;
use Magento\Framework\Mail\Template\FactoryInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Mail\TransportInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as OrderCollectionFactory;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Icecube\OrderReminder\Helper\Data as IcecubeOrderHelper;
use Magento\Framework\App\State;
/**
 * Sending class responsible for sending reminder emails to customers.
 */
class Sending
{
    protected $appState;
     /**
     * @var IcecubeOrderHelper
     */
    protected $IcecubeOrderHelper;
      /**
     * @var storeManager
     */
    protected $storeManager;

    /**
     * @var OrderCollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var FactoryInterface
     */
    protected $templateFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;



    /**
     * Sending constructor.
     *
     * @param OrderCollectionFactory $orderCollectionFactory
     * @param TransportBuilder $transportBuilder
     * @param FactoryInterface $templateFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param UrlInterface $urlBuilder
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        OrderCollectionFactory $orderCollectionFactory,
        TransportBuilder $transportBuilder,
        FactoryInterface $templateFactory,
        CustomerRepositoryInterface $customerRepository,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        IcecubeOrderHelper $IcecubeOrderHelper,
        State $appState,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->transportBuilder = $transportBuilder;
        $this->templateFactory = $templateFactory;
        $this->customerRepository = $customerRepository;
        $this->_urlBuilder = $urlBuilder;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->IcecubeOrderHelper = $IcecubeOrderHelper;
        $this->appState = $appState;

    }

    /**
     * Send reminder emails to customers based on their recent orders.
     *
     * @param array $OrderDetails - Array containing order details for each customer
     * @return string - Success message or error message
     */
    public function SendingMale($OrderDetails)
    {
        $this->appState->setAreaCode(\Magento\Framework\App\Area::AREA_FRONTEND);
        $response = [
            'status' => 'error',
            'message' => ''
        ];
        $successMessage =[];

        foreach ($OrderDetails as $OrderDetail) {
            try {
                $orderId = $OrderDetail['Order_ID'];
                $orderCollection = $this->orderCollectionFactory->create();
                $orderCollection->addFieldToFilter('increment_id', $orderId);
                $order = $orderCollection->getFirstItem();

                if ($order->getId()) {
                    // Get items from the order
                    $items = $order->getAllItems();
                    if (count($items) == 0) {
                        $response['message'] = 'Error: No items found in the order.';
                        return $response; 
                    }
                     
                    // Get product details with add-to-cart link
                    $productCustomerDetailsArray = [];
                    $productDetails =[];
                    $parentSkus = []; // To track parent products
                    $parentwithchild = [];
                    
                    foreach ($items as $item) {
                        $product = $this->productRepository->getById($item->getProductId());

                        if ($product->getTypeId() == 'bundle') {
                            // Check if it's a top-level bundle product (not an option)
                            if ($item->getParentItemId() == null) {
                                $productDetails[]=[
                                'Product_Name'=>$item->getName(),
                                'Quantity'=>$item->getQtyOrdered(),
                                'Price'=>$item->getPrice()
                               ]; 

                                // Track parent bundle SKU
                                $parentSkus[] = $item->getSku();
                            }
                        } elseif ($product->getTypeId() == 'configurable') {
                            $productDetails[]=[
                                'Product_Name'=>$item->getName(),
                                'Quantity'=>$item->getQtyOrdered(),
                                'Price'=>$item->getPrice()
                               ]; 
                            // Track parent configurable SKU
                            $parentSkus[] = $item->getSku();
                        } else {
                            // Check if it's a simple product and not a child of a tracked bundle
                            if ($item->getParentItemId() == null || !in_array($item->getParentItem()->getSku(), $parentSkus)) {
                                $productDetails[]=[
                                    'Product_Name'=>$item->getName(),
                                    'Quantity'=>$item->getQtyOrdered(),
                                    'Price'=>$item->getPrice()
                                   ]; 

                                $productCustomerDetailsArray[] = [
                                    'product_id' => $item->getProductId(),
                                ];
                            } else {
                                $parentwithchild[] = [
                                    'ParentProductSku' => $item->getParentItem()->getSku(),
                                    'ParentProdcutId' => $item->getParentItem()->getProductId(),
                                    'ChildProductSku' => $item->getProductId(),
                                ];
                            }
                        }
                    }
                } else {
                    $response['message'] = 'Error: ' . $orderId.'OrderId Not Fount In Order Collection' ;
                    return $response; 
                }
                
                // Same parentproductsku product add in one key ChildProductSku 
                $organizedArray = [];
                foreach ($parentwithchild as $item) {
                    $parentProductSku = $item['ParentProductSku'];
                    $childProductSku = $item['ChildProductSku'];
                    $parentProductID = $item['ParentProdcutId'];

                    // Check if the parentProductSku is already present in $organizedArray
                    if (!isset($organizedArray[$parentProductSku])) {
                        // If not, create a new entry with an array containing the childProductSku
                        $organizedArray[$parentProductSku] = [
                            'ParentProductSku' => $parentProductSku,
                            'product_id' => $parentProductID,
                            'ChildProductIds' => [$childProductSku],
                        ];
                    } else {
                        // If yes, append the childProductSku to the existing array
                        $organizedArray[$parentProductSku]['ChildProductIds'][] = $childProductSku;
                    }
                }
                // Convert the associative array values to a simple indexed array
                $organizedArray = array_values($organizedArray);
                //    array merge
                $combinedArray = array_merge($productCustomerDetailsArray, $organizedArray);
                 
                // Get customer email and name
                $customerEmail = $OrderDetail['Customer_Email'];
                $customerName = $OrderDetail['Customer_Firstname'] . ' ' . $OrderDetail['Customer_Lastname'];
                $secretKey = 'icecube_reminder_key';
                $encryptedData = $this->encryptData($combinedArray, $secretKey);
                $Customer_Id = $this->encryptData($OrderDetail['Customer_ID'], $secretKey);
                $baseUrl = $this->storeManager->getStore()->getBaseUrl();
                $controllerUrl =   $baseUrl.'reminder/index/addtocart'; //chenge your website name
                // Generate URL with parameters
                $urlWithParameters = $controllerUrl . '?' . http_build_query(['data' =>  $encryptedData,'Customer_Id'=>$Customer_Id]);


                
                
                if ($this->IcecubeOrderHelper->isModuleEnabled()) {
                    $senderName = $this->IcecubeOrderHelper->getSenderName();
                    $senderEmail = $this->IcecubeOrderHelper->getSenderEmail();
                }else{
                    $response['message'] = 'Error: Icecube_OrderReminder Module Not enable.';
                    return $response;   
                }
                // Add your email content and template logic here
                $templateOptions = [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $OrderDetail['Store_ID'],
                ];
            
                $templateVars = [
                    'customer_name' => $customerName,
                    'data' => $productDetails,
                    'Add_To_Cart' => $urlWithParameters,
                ];
                $from = ['email' => $senderEmail, 'name' =>  $senderName];
                $to = ['email' => $customerEmail, 'name' => $customerName];  
        
                $transport = $this->transportBuilder
                    ->setTemplateIdentifier("icecube_email_template")
                    ->setTemplateOptions($templateOptions)
                    ->setTemplateVars(['datavalues' => $templateVars])
                    ->setFrom($from)
                    ->addTo($to['email'], $to['name'])
                    ->getTransport();

                $transport->sendMessage();
                 // If the email is sent successfully
                $successMessage[]=$customerEmail;
            } catch (\Exception $e) {
                $response['message'] = 'Error: ' . $e->getMessage();
                return $response; 
            }
        }
        $response['status'] = 'success';
        $response['message'] = $successMessage;
        return $response; 
    }

      // Encryption function
      function encryptData($plainText, $secretKey)
       {
        $plainText = json_encode($plainText);
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedData = openssl_encrypt($plainText, 'aes-256-cbc', $secretKey, 0, $iv);
        $combinedData = $iv . $encryptedData;
        return base64_encode($combinedData);
      }


     

}
