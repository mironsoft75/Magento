<?php
namespace PHPCuong\CustomerCondition\Model\Rule\Condition\Customer;
class Shippingcity extends \Magento\Rule\Model\Condition\AbstractCondition
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
            'shipping_city' => __('Shipping city')
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
        $city = $this->_checkoutSession->getQuote()->getShippingAddress()->getCity();
        $model->setData('shipping_city', $city);  // validation value
        return parent::validate($model);
    }
}