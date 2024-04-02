<?php
namespace CustomeModule\Student\Block;

Class Datanew extends \Magento\Framework\View\Element\Template
{
	protected $DataFactory;
	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\CustomeModule\Student\Model\DataFactory $DataFactory
	){
		parent::__construct($context);
		$this->DataFactory = $DataFactory;
	}
	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
	
	public function getListNews()
	{
      
        $data = $this->DataFactory->create();
        $dataCollection=$data->getCollection();

        return $dataCollection;
	}
	

	
	
}
?>
