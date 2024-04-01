<?php
namespace Icecube\OrderReminder\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Icecube\OrderReminder\Model\AddToCart\ProductAddCart;
use Magento\Customer\Model\Session;
use Magento\Framework\Controller\Result\RedirectFactory;

/**
 * Controller class responsible for adding products to the cart based on the reminder email link.
 */
class Addtocart extends Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var ProductAddCart
     */
    protected $ProductAddCart;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductAddCart $ProductAddCart
     * @param Session $customerSession
     * @param RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ProductAddCart $ProductAddCart,
        Session $customerSession,
        RedirectFactory $resultRedirectFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->ProductAddCart = $ProductAddCart;
        $this->customerSession = $customerSession;
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * Execute view action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
            $data = $this->getRequest()->getParam('data');
            $CustomerID = $this->getRequest()->getParam('Customer_Id');
             $secretKey = 'icecube_reminder_key';
             $details = $this->decryptData($data, $secretKey);
             $CustomerID = $this->decryptData($CustomerID, $secretKey);
                $addtocart = $this->ProductAddCart->ProductAddCart($details, $CustomerID);
                if ($addtocart) {
                    $this->messageManager->addNoticeMessage(__('Products Added In Cart Successfully'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    $resultRedirect->setPath('checkout/cart'); 
                    return $resultRedirect;
                } else {
                    $this->messageManager->addNoticeMessage(__('Products Not Add In Cart'));
                    $resultRedirect = $this->resultRedirectFactory->create();
                    $resultRedirect->setPath('checkout/cart'); 
                    return $resultRedirect;
                }  

                $resultPage = $this->resultPageFactory->create();
                return $resultPage;
    }

        // Decryption function
        function decryptData($encryptedData, $secretKey) {
            // Base64 decode the encrypted data
            $combinedData = base64_decode($encryptedData);

            // Separate IV and encrypted data
            $iv = substr($combinedData, 0, 16);
            $encryptedData = substr($combinedData, 16);
            $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $secretKey, 0, $iv);
            // Decrypt the data using AES-256-CBC algorithm
            return json_decode($decryptedData, true);
        }

    

}
