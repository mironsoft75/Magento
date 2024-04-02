<?php
namespace PHPCuong\CustomerCondition\Model\Rule\Condition\Customer;

class CreatedAt extends \Magento\Rule\Model\Condition\AbstractCondition
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
            'customer_createdat' => __('CreatedAt')
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
            $getCreatedAt = $customer->getCreatedAt();

            // echo $getCreatedAt;
            // exit;

            // Assuming 'dob' is the attribute code for Date of Birth
            $model->setData('customer_createdat', $getCreatedAt);  // validation value
        }

        return parent::validate($model);
    }
}
