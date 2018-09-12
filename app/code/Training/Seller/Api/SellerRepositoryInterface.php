<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Training\Seller\Api\Data\SellerInterface;

/**
 * Seller Repository interface.
 *
 * @api
 */
interface SellerRepositoryInterface
{
    /**
     * Retrieve seller.
     *
     * @param int $objectId
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($objectId);

    /**
     * Retrieve seller.
     *
     * @param string $objectIdentifier
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIdentifier($objectIdentifier);

    /**
     * Retrieve seller matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training\Seller\Api\Data\SellerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null);

    /**
     * Save seller.
     *
     * @param \Training\Seller\Api\Data\SellerInterface $seller
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(SellerInterface $seller);

    /**
     * Delete seller by Id.
     *
     * @param int $objectId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($objectId);

    /**
     * Delete seller.
     *
     * @param string $objectIdentifier
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier($objectIdentifier);
}
