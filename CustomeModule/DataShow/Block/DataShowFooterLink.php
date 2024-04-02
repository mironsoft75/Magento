<?php
namespace CustomeModule\DataShow\Block;

Class DataShowFooterLink extends \Magento\Framework\View\Element\Template
{

	
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context
	
	){
		parent::__construct($context);
		
	}
	

	
	public function getBaseUrl()
	{
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
?>
