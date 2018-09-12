<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * SellerSearchResults Data Interface
 *
 * @api
 */
interface SellerSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get seller list.
     *
     * @return \Training\Seller\Api\Data\sellerInterface[]
     */
    public function getItems();

    /**
     * Set seller list.
     *
     * @param \Training\Seller\Api\Data\SellerInterface[] $items
     *
     * @return SearchResultsInterface
     */
    public function setItems(array $items);
}