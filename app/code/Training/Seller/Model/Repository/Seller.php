<?php
/**
 * Module Training/Seller
 */

namespace Training\Seller\Model\Repository;

use Magento\Framework\Api\SearchCriteriaInterface;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Api\Data\SellerInterfaceFactory;
use Training\Seller\Api\Data\SellerSearchResultsInterfaceFactory;
use Training\Seller\Api\SellerRepositoryInterface;
use Training\Seller\Model\Repository\Manager as RepositoryManager;
use Training\Seller\Model\Repository\ManagerFactory as RepositoryManagerFactory;
use Training\Seller\Model\ResourceModel\Seller as SellerResourceModel;
use Training\Seller\Model\ResourceModel\Seller\CollectionFactory as SellerCollectionFactory;

/**
 * Seller repository
 */
class Seller implements SellerRepositoryInterface
{

    /**
     * @var RepositoryManager $sellerRepositoryManager
     */
    protected $sellerRepositoryManager;

    /**
     * Seller constructor.
     * @param RepositoryManagerFatory $repositoryManagerFactory
     * @param SellerInterfaceFactory $objectFactory
     * @param SellerResourceModel $objectResource
     * @param SellerCollectionFactory $objectCollectionFactory
     * @param SellerSearchResultsInterfaceFactory $objectSearchResultsFactory
     */
    public function __construct(
        RepositoryManagerFactory $repositoryManagerFactory,
        SellerInterfaceFactory $objectFactory,
        SellerResourceModel $objectResource,
        SellerCollectionFactory $objectCollectionFactory,
        SellerSearchResultsInterfaceFactory $objectSearchResultsFactory
    )
    {
        $this->sellerRepositoryManager = $repositoryManagerFactory->create(
            [
                'objectFactory'              => $objectFactory,
                'objectResource'             => $objectResource,
                'objectCollectionFactory'    => $objectCollectionFactory,
                'objectSearchResultsFactory' => $objectSearchResultsFactory,
                'identifierFieldName'        => SellerInterface::FIELD_IDENTIFIER
            ]
        );
    }

    /**
     * Retrieve seller.
     *
     * @param int $objectId
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($objectId)
    {
        return $this->sellerRepositoryManager->getEntityById($objectId);
    }

    /**
     * Retrieve seller.
     *
     * @param string $objectIdentifier
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getByIdentifier($objectIdentifier)
    {
        return $this->sellerRepositoryManager->getEntityByIdentifier($objectIdentifier);
    }

    /**
     * Retrieve seller matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training\Seller\Api\Data\SellerSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->sellerRepositoryManager->getEntities($searchCriteria);
    }

    /**
     * Save seller.
     *
     * @param \Training\Seller\Api\Data\SellerInterface $seller
     * @return \Training\Seller\Api\Data\SellerInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(SellerInterface $object)
    {
        return $this->sellerRepositoryManager->saveEntity($object);
    }

    /**
     * Delete seller by Id.
     *
     * @param int $objectId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteById($objectId)
    {
        return $this->sellerRepositoryManager->deleteEntityById($objectId);
    }

    /**
     * Delete seller.
     *
     * @param string $objectIdentifier
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function deleteByIdentifier($objectIdentifier)
    {
        return $this->sellerRepositoryManager->deleteEntityByIdentifier($objectIdentifier);
    }
}