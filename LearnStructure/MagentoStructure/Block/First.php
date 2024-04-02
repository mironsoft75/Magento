<?php
// app/code/LearnStructure/MagentoStructure/Block/First.php
namespace LearnStructure\MagentoStructure\Block;

use Magento\Framework\View\Element\Template;
use LearnStructure\MagentoStructure\Model\MagentoFormFactory;
class First extends Template
{

    protected $magentoFormFactory;

    public function __construct(
        Template\Context $context,
        MagentoFormFactory $magentoFormFactory
    ) {
        parent::__construct($context);
        $this->magentoFormFactory = $magentoFormFactory;
    }
   
    public function getFormAction()
    {
        return $this->getUrl('magentostructure/index/save', ['_secure' => true]);
    }
    public function getUpdateFormAction(){
        return $this->getUrl('magentostructure/index/update', ['_secure' => true]);
    }
    public function getAllFormData()
    {
        $collection = $this->magentoFormFactory->create()->getCollection();
        return $collection;
    }

   

    public function getDeleteUrl($id)
    {
        return $this->getUrl('magentostructure/index/delete', ['id' => $id]);
    }

    public function getUpdateUrl($id)
    {
        return $this->getUrl('magentostructure/index/update', ['id' => $id]);
    }
    
}


?>  