<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Model\ResourceModel\Seller;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Training\Seller\Api\Data\SellerInterface;

/**
 * Seller Collection
 */
class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(
            \Training\Seller\Model\Seller::class,
            \Training\Seller\Model\ResourceModel\Seller::class
        );
    }


    public function toOptionArray()
    {
        return $this->_toOptionArray(SellerInterface::FIELD_SELLER_ID, SellerInterface::FIELD_NAME);
    }
}
