<?php
/**
 * GiaPhuGroup Co., Ltd.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the GiaPhuGroup.com license that is
 * available through the world-wide-web at this URL:
 * https://www.giaphugroup.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    PHPCuong
 * @package     PHPCuong_CustomerCondition
 * @copyright   Copyright (c) 2018-2019 GiaPhuGroup Co., Ltd. All rights reserved. (http://www.giaphugroup.com/)
 * @license     https://www.giaphugroup.com/LICENSE.txt
 */

namespace PHPCuong\CustomerCondition\Model\Rule\Condition\Customer;

class Id extends \Magento\Rule\Model\Condition\AbstractCondition
{
    /**
     * @var \Magento\Customer\Api\CustomerMetadataInterface
     */
    protected $customerMetadata;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @param \Magento\Rule\Model\Condition\Context $context
     * @param \Magento\Customer\Api\CustomerMetadataInterface $customerMetadata
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Rule\Model\Condition\Context $context,
        \Magento\Customer\Api\CustomerMetadataInterface $customerMetadata,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerMetadata = $customerMetadata;
        $this->customerFactory = $customerFactory;
    }

    /**
     * Load attribute options
     *
     * @return $this
     */
    public function loadAttributeOptions()
    {
        $attributes = [
            'customer_id' => __('ID')
        ];

        $this->setAttributeOption($attributes);

        return $this;
    }

    /**
     * Get input type
     * Possible values are: string, numeric, date, select, multiselect, grid, boolean
     *
     * @return string
     */
    public function getInputType()
    {
        return 'text';
    }

    /**
     * Get value element type
     *
     * We have the value element types as select, text
     * @return string
     */
    public function getValueElementType()
    {
        return 'text';
    }

    /**
     * Get value select options
     *
     * @return array|mixed
     */
    public function getValueSelectOptions()
    {
        // For a text input, you usually don't need predefined options
        return [];
    }

    /**
     * Validate Customer Rule Condition
     *
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return bool
     */
    public function validate(\Magento\Framework\Model\AbstractModel $model)
    {
        // Get the customer id of the current customer
        $customerId = (int)$model->getCustomerId();
// Loading the customer information via the customer id
$customer = $this->customerFactory->create()->load($customerId);

        // Set the customer_id to the current customer id
        $model->setData('customer_id', $customer->getId());

        return parent::validate($model);
    }
}
