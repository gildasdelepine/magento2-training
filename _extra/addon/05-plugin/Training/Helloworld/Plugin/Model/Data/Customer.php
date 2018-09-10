<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Plugin\Model\Data;

use Magento\Customer\Model\Data\Customer as ModelCustomer;

/**
 * Plugin Customer
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Customer
{
    /**
     * Modify the first name
     *
     * @param ModelCustomer $subject
     * @param string        $value
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSetFirstname(ModelCustomer $subject, $value)
    {
        $value = mb_convert_case($value, MB_CASE_TITLE);

        return [$value];
    }
}
