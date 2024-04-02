<?php
namespace CustomeModule\DataShow\Controller\Index;

use Magento\Framework\App\Action\Context;
use CustomeModule\DataShow\Model\DataFactory;

class Save extends \Magento\Framework\App\Action\Action
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
            if (!empty($formData)) {
                try {
                    // Load the Data model if the record already exists
                    if (isset($formData['editId']) && !empty($formData['editId'])) {
                        $dataModel = $this->dataFactory->create()->load($formData['editId']);
                    } else {
                        $dataModel = $this->dataFactory->create();
                    }
    
                    // Set data from the form fields
                    $dataModel->setData('title', $formData['title']);
                    $dataModel->setData('StudentName', $formData['student_name']);
                    $dataModel->setData('description', $formData['description']);
                    $dataModel->setData('status', $formData['status']);
                    $dataModel->setData('test', $formData['test']);
                    $dataModel->setData('created_at', date('Y-m-d H:i:s')); // Set current date and time
                    $dataModel->setData('updated_at', date('Y-m-d H:i:s')); // Set current date and time
    
                    // Save the data
                    $dataModel->save();
    
                    // Add success message and redirect to the listing page
                    $this->messageManager->addSuccessMessage(__('Data saved successfully.'));
                    $this->_redirect('DataShow/index/index');

                


                } catch (\Exception $e) {
                    // Add error message and redirect back to the form page
                    $this->messageManager->addErrorMessage(__('Error saving data. Please try again.'));
                    $this->_redirect('*/*/index');
                }
            }
        } else {
            // Redirect to some other page if accessed directly without POST data
            $this->_redirect('noroute');
        }
    }
    
}
