<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Model\Repository;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface as CollectionProcessor;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\Collection\AbstractDb as AbstractCollection;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb as AbstractResourceModel;
use Magento\Framework\Phrase;

/**
 * Repository Manager
 *
 * @author    Laurent Minguet <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Manager
{
    /**
     * @var CollectionProcessor
     */
    protected $collectionProcessor;

    /**
     * @var mixed
     */
    protected $objectFactory;

    /**
     * @var AbstractResourceModel
     */
    protected $objectResource;

    /**
     * @var mixed
     */
    protected $objectCollectionFactory;

    /**
     * @var mixed
     */
    protected $objectSearchResultsFactory;

    /**
     * @var string|null
     */
    protected $identifierFieldName = null;

    /**
     * @var array
     */
    protected $cacheById = [];

    /**
     * @var array
     */
    protected $cacheByIdentifier = [];

    /**
     * @param CollectionProcessor   $collectionProcessor
     * @param mixed                 $objectFactory
     * @param AbstractResourceModel $objectResource
     * @param mixed                 $objectCollectionFactory
     * @param mixed                 $objectSearchResultsFactory
     * @param string|null           $identifierFieldName
     */
    public function __construct(
        CollectionProcessor $collectionProcessor,
        $objectFactory,
        AbstractResourceModel $objectResource,
        $objectCollectionFactory,
        $objectSearchResultsFactory,
        $identifierFieldName = null
    ) {
        $this->collectionProcessor = $collectionProcessor;

        $this->objectFactory              = $objectFactory;
        $this->objectResource             = $objectResource;
        $this->objectCollectionFactory    = $objectCollectionFactory;
        $this->objectSearchResultsFactory = $objectSearchResultsFactory;
        $this->identifierFieldName        = $identifierFieldName;
    }

    /**
     * Retrieve a entity by its ID
     *
     * @param int $objectId id of the entity
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings("PMD.StaticAccess")
     */
    public function getEntityById($objectId)
    {
        if (!isset($this->cacheById[$objectId])) {
            /** @var \Magento\Framework\Model\AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectId);

            if (!$object->getId()) {
                // object does not exist
                throw NoSuchEntityException::singleField('objectId', $objectId);
            }

            $this->cacheById[$object->getId()] = $object;

            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                $this->cacheByIdentifier[$objectIdentifier] = $object;
            }
        }

        return $this->cacheById[$objectId];
    }

    /**
     * Retrieve a entity by its identifier
     *
     * @param string $objectIdentifier identifier of the entity
     *
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @SuppressWarnings("PMD.StaticAccess")
     */
    public function getEntityByIdentifier($objectIdentifier)
    {
        if (is_null($this->identifierFieldName)) {
            throw new NoSuchEntityException('The identifier field name is not set');
        }

        if (!isset($this->cacheByIdentifier[$objectIdentifier])) {
            /** @var \Magento\Framework\Model\AbstractModel $object */
            $object = $this->objectFactory->create();
            $this->objectResource->load($object, $objectIdentifier, $this->identifierFieldName);

            if (!$object->getId()) {
                // object does not exist
                throw NoSuchEntityException::singleField('objectIdentifier', $objectIdentifier);
            }

            $this->cacheById[$object->getId()] = $object;
            $this->cacheByIdentifier[$objectIdentifier] = $object;
        }

        return $this->cacheByIdentifier[$objectIdentifier];
    }

    /**
     * Save entity
     *
     * @param mixed $object
     *
     * @return AbstractModel
     * @throws CouldNotSaveException
     */
    public function saveEntity($object)
    {
        /** @var AbstractModel $object */
        try {
            $this->objectResource->save($object);

            unset($this->cacheById[$object->getId()]);
            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->cacheByIdentifier[$objectIdentifier]);
            }
        } catch (\Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotSaveException($msg);
        }

        return $object;
    }

    /**
     * Delete entity
     *
     * @param AbstractModel $object
     *
     * @return boolean
     * @throws CouldNotDeleteException
     */
    public function deleteEntity(AbstractModel $object)
    {
        try {
            $this->objectResource->delete($object);

            unset($this->cacheById[$object->getId()]);
            if (!is_null($this->identifierFieldName)) {
                $objectIdentifier = $object->getData($this->identifierFieldName);
                unset($this->cacheByIdentifier[$objectIdentifier]);
            }
        } catch (\Exception $e) {
            $msg = new Phrase($e->getMessage());
            throw new CouldNotDeleteException($msg);
        }

        return true;
    }

    /**
     * Delete entity by id
     *
     * @param int $objectId
     *
     * @return boolean
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteEntityById($objectId)
    {
        return $this->deleteEntity($this->getEntityById($objectId));
    }

    /**
     * Delete entity by identifier
     *
     * @param string $objectIdentifier
     *
     * @return boolean
     * @throws NoSuchEntityException
     * @throws CouldNotDeleteException
     */
    public function deleteEntityByIdentifier($objectIdentifier)
    {
        return $this->deleteEntity($this->getEntityByIdentifier($objectIdentifier));
    }

    /**
     * Retrieve not eav entities which match a specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria search criteria
     *
     * @return \Magento\Framework\Api\SearchResults
     */
    public function getEntities(SearchCriteriaInterface $searchCriteria = null)
    {
        /** @var AbstractCollection $collection */
        $collection = $this->objectCollectionFactory->create();

        /** @var \Magento\Framework\Api\SearchResults $searchResults */
        $searchResults = $this->objectSearchResultsFactory->create();

        if ($searchCriteria) {
            $searchResults->setSearchCriteria($searchCriteria);
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        // load the collection
        $collection->load();

        // build the result
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());

        return $searchResults;
    }
}
