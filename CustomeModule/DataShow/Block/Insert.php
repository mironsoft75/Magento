<?php
namespace CustomeModule\DataShow\Block;

use Magento\Framework\View\Element\Template;

class Insert extends Template
{
    protected $_pageFactory;

    public function __construct(
        Template\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->_pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function getInsertPage()
    {
        return $this->_pageFactory->create();
    }

    public function getFormAction()
    {
        return $this->getUrl('*/*/save', ['_secure' => true]);
    }
}

?>