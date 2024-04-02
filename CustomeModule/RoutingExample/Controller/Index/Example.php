<?php

namespace CustomeModule\RoutingExample\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Example extends Action
{
    protected $resultJsonFactory;

    public function __construct(Context $context, JsonFactory $resultJsonFactory)
    {
        $this->resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $response = ['message' => 'Hello from JSON response'];
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response);
    }
}