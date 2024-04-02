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

namespace PHPCuong\CustomerCondition\Observer;

class CustomerConditionObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Execute observer.
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $additional = $observer->getAdditional();
        $conditions = (array) $additional->getConditions();

   
        // Merging the old conditions with our new conditions.
        $conditions = array_merge_recursive($conditions, [
            [
                'value'=> [
                    [
                        'value' => \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Gender::class,
                        'label' => __('Gender')
                    ],
                    [
                        'value' => \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\DateOfBirth::class,
                        'label' => __('Date of Birth')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Shippingcity::class,
                        'label'=> __('Shipping city')
                    ],
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Id::class,
                        'label'=> __('ID')
                    ],
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Email::class,
                        'label'=> __('Email')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Firstname::class,
                        'label'=> __('FirstName')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Lastname::class,
                        'label'=> __('LastName')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Middlename::class,
                        'label'=> __('MiddleName')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Prefix::class,
                        'label'=> __('Name Prefix')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Suffix::class,
                        'label'=> __('Name Suffix')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\Taxvat::class,
                        'label'=> __('Taxvat Number')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\CreatedAt::class,
                        'label'=> __('CreatedAt')
                    ],
                    
                    [
                        'value'=> \PHPCuong\CustomerCondition\Model\Rule\Condition\Customer\UpdatedAt::class,
                        'label'=> __('UpdatedAt')
                    ]


                  
                ],
                'label'=> __('Customer Condition')
            ]
        ]);

        $additional->setConditions($conditions);
        return $this;
    }
}
