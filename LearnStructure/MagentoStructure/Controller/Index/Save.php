<?php
namespace LearnStructure\MagentoStructure\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use LearnStructure\MagentoStructure\Api\FormDataRepositoryInterface;
use LearnStructure\MagentoStructure\Model\MagentoFormFactory;
use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    protected $formDataRepository;
    protected $formDataFactory;

    public function __construct(
        Context $context,
        FormDataRepositoryInterface $formDataRepository,
        MagentoFormFactory $formDataFactory
    ) {
        parent::__construct($context);
        $this->formDataRepository = $formDataRepository;
        $this->formDataFactory = $formDataFactory;
    }

    public function execute()
    {
        $formData = $this->getRequest()->getPostValue();

        try {
            $formDataObject = $this->formDataFactory->create();
            $formDataObject->setData($formData);
            $this->formDataRepository->save($formDataObject);

            // Add success message
            $this->messageManager->addSuccessMessage(__('Data saved successfully.'));
        } catch (\Exception $e) {
            // Add error message
            $this->messageManager->addErrorMessage(__('Error saving data. Please try again.'));
        }

        // Redirect to the same page
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
}
