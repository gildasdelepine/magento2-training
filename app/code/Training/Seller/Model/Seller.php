<?php

namespace Training\Seller\Model;

use \Magento\Framework\Model\AbstractModel;
use \Magento\Framework\DataObject\IdentityInterface;
use \Training\Seller\Api\Data\SellerInterface;

class Seller extends AbstractModel implements IdentityInterface, SellerInterface
{

    /**
     * Training seller cache tag
     */
    const CACHE_TAG = 'tng_s';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;


    protected function _construct()
    {
        parent::_construct();
        $this->_init(ResourceModel\Seller::class);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    /**
     * Get seller_id
     *
     * @return int|null
     */
    public function getSellerId()
    {
        return (int) $this->getId();
    }

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return (string) $this->getData(self::FIELD_IDENTIFIER);
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return (string) $this->getData(self::FIELD_NAME);
    }

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        $value = $this->getData(self::FIELD_CREATED_AT);
        if ($value !== null) {
            $value = (string) $value;
        }
        return $value;
    }

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt()
    {
        $value = $this->getData(self::FIELD_UPDATED_AT);
        if ($value !== null) {
            $value = (string) $value;
        }

        return $value;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription()
    {
        $value = $this->getData(self::FIELD_DESCRIPTION);
        if ($value !== null) {
            $value = (string) $value;
        }

        return $value;
    }

    /**
     * Set seller_id
     *
     * @param int $value
     *
     * @return SellerInterface
     */
    public function setSellerId($value)
    {
        return $this->setId((int) $value);
    }

    /**
     * Set identifier
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setIdentifier($value)
    {
        return $this->setData(self::FIELD_IDENTIFIER, (string) $value);
    }

    /**
     * Set name
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setName($value)
    {
        return $this->setData(self::FIELD_NAME, (string) $value);
    }

    /**
     * Set created_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setCreatedAt($value)
    {
        return $this->setData(self::FIELD_CREATED_AT, (string) $value);
    }

    /**
     * Set updated_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setUpdatedAt($value)
    {
        return $this->setData(self::FIELD_UPDATED_AT, (string) $value);
    }

    /**
     * Set description
     *
     * @param string|null $value
     *
     * @return SellerInterface
     */
    public function setDescription($value)
    {
        if (!is_null($value)) {
            $value = (string) $value;
        }

        return $this->setData(self::FIELD_DESCRIPTION, $value);
    }

    /**
     * Set seller values from array
     *
     * @param array $data
     *
     * @return $this
     */
    public function populateFromArray(array $data)
    {
        $this->setIdentifier($data['identifier']);
        $this->setName($data['name']);
        if($data['description'] !== null) {
            $this->setDescription($data['description']);
        }


        return $this;
    }
}