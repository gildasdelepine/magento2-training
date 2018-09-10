<?php
/**
 * Magento 2 Training Project
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
 * Seller Repository
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Seller implements SellerRepositoryInterface
{
    /**
     * @var RepositoryManager
     */
    protected $sellerRepositoryManager;

    /**
     * @param RepositoryManagerFactory            $repositoryManagerFactory
     * @param SellerInterfaceFactory              $objectFactory
     * @param SellerResourceModel                 $objectResource
     * @param SellerSearchResultsInterfaceFactory $objectSearchResultsFactory
     * @param SellerCollectionFactory             $objectCollectionFactory
     */
    public function __construct(
        RepositoryManagerFactory            $repositoryManagerFactory,
        SellerInterfaceFactory              $objectFactory,
        SellerResourceModel                 $objectResource,
        SellerCollectionFactory             $objectCollectionFactory,
        SellerSearchResultsInterfaceFactory $objectSearchResultsFactory
    ) {
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
     * {@inheritdoc}
     */
    public function getById($objectId)
    {
        return $this->sellerRepositoryManager->getEntityById($objectId);
    }

    /**
     * {@inheritdoc}
     */
    public function getByIdentifier($objectIdentifier)
    {
        return $this->sellerRepositoryManager->getEntityByIdentifier($objectIdentifier);
    }

    /**
     * {@inheritdoc}
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this->sellerRepositoryManager->getEntities($searchCriteria);
    }

    /**
     * {@inheritdoc}
     */
    public function save(SellerInterface $object)
    {
        return $this->sellerRepositoryManager->saveEntity($object);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($objectId)
    {
        return $this->sellerRepositoryManager->deleteEntityById($objectId);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteByIdentifier($objectIdentifier)
    {
        return $this->sellerRepositoryManager->deleteEntityByIdentifier($objectIdentifier);
    }
}
