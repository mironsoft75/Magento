<?php
namespace CustomeModule\DataShow\Controller\Index;

use Magento\Framework\App\Action\Context;
use CustomeModule\DataShow\Model\DataFactory;

class Edit extends \Magento\Framework\App\Action\Action
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
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPostValue();
            if (!empty($formData) && isset($formData['update_id'])) {
                try {
                    // Load the Data model
                    $dataModel = $this->dataFactory->create()->load($formData['update_id']);

                    // Check if the record exists
                    if ($dataModel->getId()) {
                        // Set data from the form fields
                        $dataModel->setData('title', $formData['update_title']);
                        $dataModel->setData('StudentName', $formData['update_student_name']);
                        $dataModel->setData('description', $formData['update_description']);
                        $dataModel->setData('status', $formData['update_status']);
                        $dataModel->setData('test', $formData['update_test']);
                        $dataModel->setData('updated_at', date('Y-m-d H:i:s')); // Set current date and time

                        // Save the data
                        $dataModel->save();

                        // Add success message
                        $this->messageManager->addSuccessMessage(__('Data updated successfully.'));

                     

                        // Redirect to the listing page
                        $this->_redirect('DataShow/index/index');
             
                    } else {
                        // Add error message and redirect back to the form page
                        $this->messageManager->addErrorMessage(__('Data not found.'));
                        $this->_redirect('*/*/index');
                    }
                } catch (\Exception $e) {
                    // Add error message and redirect back to the form page
                    $this->messageManager->addErrorMessage(__('Error updating data. Please try again.'));
                    $this->_redirect('*/*/index');
                }
            } else {
                // Redirect to some other page if accessed directly without POST data or update_id missing
                $this->_redirect('noroute');
            }
            } else {
                // Redirect to some other page if accessed directly without POST data
                $this->_redirect('noroute');
            }
    }
}
