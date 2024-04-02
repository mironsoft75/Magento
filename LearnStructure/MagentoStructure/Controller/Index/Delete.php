<?php
namespace LearnStructure\MagentoStructure\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use LearnStructure\MagentoStructure\Api\FormDataRepositoryInterface;
use LearnStructure\MagentoStructure\Api\Data\FormDataInterface;
use LearnStructure\MagentoStructure\Model\MagentoFormFactory;
use Magento\Framework\Controller\ResultFactory; // Add this import

class Delete extends Action
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

   // LearnStructure\MagentoStructure\Controller\Index\Delete.php
public function execute()
{
    try {
        // Sabhi request parameters ko lekar aayein
        $data = $this->getRequest()->getParams();

        // Dekhein ki 'id' key $data mein mojood hai ya nahi
        if (isset($data['id'])) {
          
            $model = $this->formDataRepository->getById($data['id']);
           
            // Dekhein ki model successfully load ho raha hai ya nahi
            if ($model->getId()) {
              
                $this->formDataRepository->delete($model);
                $this->messageManager->addSuccessMessage(__("Record deleted successfully."));
            } else {
                $this->messageManager->addErrorMessage(__("Invalid record ID."));
            }
        } else {
            $this->messageManager->addErrorMessage(__("Invalid record ID."));
        }
    } catch (\Exception $e) {
        $this->messageManager->addErrorMessage($e, __("We can't delete the record. Please try again."));
    }

    $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
    $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    return $resultRedirect;
}

}
