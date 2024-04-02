<?php
namespace PHPCuong\CustomerCondition\Model\Rule\Condition\Customer;

class DateOfBirth extends \Magento\Rule\Model\Condition\AbstractCondition
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
            'customer_dob' => __('Date of Birth')
        ]);
        return $this;
    }

    public function getInputType()
    {
        return 'select';  // Assuming date is the correct input type for Date of Birth
    }

    public function getValueElementType()
    {
        return 'text';
    }

    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        $customerId = $this->_checkoutSession->getQuote()->getCustomerId();

        // Check if customer is logged in
        if ($customerId) {
            $customer = $this->_checkoutSession->getQuote()->getCustomer();
            $dob = $customer->getDob();

          
            // Assuming 'dob' is the attribute code for Date of Birth
            $model->setData('customer_dob', $dob);  // validation value
        }

        return parent::validate($model);
    }
}
