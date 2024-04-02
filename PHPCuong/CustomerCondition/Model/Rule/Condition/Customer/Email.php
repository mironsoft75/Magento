<?php
namespace PHPCuong\CustomerCondition\Model\Rule\Condition\Customer;
class Email extends \Magento\Rule\Model\Condition\AbstractCondition
{

    protected $_checkoutSession;

    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Magento\Checkout\Model\Session $checkoutSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_checkoutSession = $checkoutSession;
    }

public function loadAttributeOptions()
    {
        $this->setAttributeOption([
            'customer_email' => __('Email')
        ]);
        return $this;
    }

    public function getInputType()
    {
       return 'select';  // input type for admin condition
    }

    public function getValueElementType()
    {
        return 'text';
    }

    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        $customer = $this->_checkoutSession->getQuote()->getCustomer();
            $getEmail = $customer->getEmail();

        $model->setData('customer_email', $getEmail);  // validation value
        return parent::validate($model);
    }
}