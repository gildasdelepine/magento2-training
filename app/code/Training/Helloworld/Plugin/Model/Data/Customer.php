<?php
/**
 * Plugin Customer Data
 */
namespace Training\Helloworld\Plugin\Model\Data;

use Magento\Customer\Model\Data\Customer as ModelCustomer;

class Customer
{
    /**
     * Modify the first name
     *
     * @param ModelCustomer $subject
     * @param string $value
     *
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeSetFirstname(ModelCustomer $subject, $value)
    {
        $value = mb_convert_case($value, MB_CASE_UPPER);
        return [$value];
    }
}