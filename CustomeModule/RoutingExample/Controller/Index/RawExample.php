<?php
namespace CustomeModule\RoutingExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\RawFactory;

class RawExample extends Action
{
    protected $resultRawFactory;

    public function __construct(Context $context, RawFactory $resultRawFactory)
    {
        $this->resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $rawContent = '<h2>This is raw content response</h2>';
        $resultRaw = $this->resultRawFactory->create();
        return $resultRaw->setContents($rawContent);
    }
}
?>