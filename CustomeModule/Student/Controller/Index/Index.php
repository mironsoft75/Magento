<?php
namespace CustomeModule\Student\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $pageFactory;
	protected $DataFactory;

	
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
        \CustomeModule\Student\Model\DataFactory $dataFactory
        
        )
	{
		$this->pageFactory = $pageFactory;
		$this->DataFactory = $dataFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
        $data = $this->DataFactory->create();
        $dataCollection=$data->getCollection();
         
        // echo "<pre>";
        // print_r($dataCollection->getData());
        // echo "</pre>";
        return $this->pageFactory->create();
	}
}
?>
