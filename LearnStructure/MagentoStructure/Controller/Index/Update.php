<?php
namespace LearnStructure\MagentoStructure\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use LearnStructure\MagentoStructure\Api\FormDataRepositoryInterface;
use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;
use Magento\Framework\Controller\ResultFactory;

class Update extends Action
{
    protected $formDataRepository;

    public function __construct(
        Context $context,
        FormDataRepositoryInterface $formDataRepository
    ) {
        parent::__construct($context);
        $this->formDataRepository = $formDataRepository;
    }

    public function execute()
    {
        $formData = $this->getRequest()->getPostValue();
      
        try {
            if (isset($formData['id'])) {
                $model = $this->formDataRepository->getById($formData['id']);
                
                if ($model->getId()) {
                    $model->setData($formData);
                    $this->formDataRepository->update($model);
                    $this->messageManager->addSuccessMessage(__("Record updated successfully."));
                } else {
                    $this->messageManager->addErrorMessage(__("Invalid record ID."));
                }
            } else {
                $this->messageManager->addErrorMessage(__("Invalid record ID."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't update the record. Please try again."));
        }
    
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }
    
}
