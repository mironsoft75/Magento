<?php
namespace CustomeModule\DataShow\Controller\Index;

use Magento\Framework\App\Action\Context;
use CustomeModule\DataShow\Model\DataFactory;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $dataFactory;

    public function __construct(
        Context $context,
        DataFactory $dataFactory
    ) {
        $this->dataFactory = $dataFactory;
        parent::__construct($context);
    }

    public function execute()
{
    $id = $this->getRequest()->getParam('id');
    if ($id) {
        try {
            // Load the Data model
            $dataModel = $this->dataFactory->create()->load($id);

            // Check if the record exists
            if ($dataModel->getId()) {
                // Delete the data
                $dataModel->delete();
                // Add success message
                $this->messageManager->addSuccessMessage(__('Data deleted successfully.'));

                $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
                $cacheManager = $objectManager->create('\Magento\Framework\App\CacheInterface');
                $cacheManager->clean([\Magento\Framework\App\Cache\Type\Config::TYPE_IDENTIFIER]);

            } else {
                // Add error message if the record does not exist
                $this->messageManager->addErrorMessage(__('Data not found.'));
            }
        } catch (\Exception $e) {
            // Add error message if there is an exception
            $this->messageManager->addErrorMessage(__('Error deleting data. Please try again.'));
        }
    } else {
        // Add error message if the ID parameter is missing
        $this->messageManager->addErrorMessage(__('Invalid request. Please provide a valid ID.'));
    }

    // Redirect to the listing page
    $resultRedirect = $this->resultRedirectFactory->create();
    $resultRedirect->setPath('DataShow/index/index');
    return $resultRedirect;
}

}
