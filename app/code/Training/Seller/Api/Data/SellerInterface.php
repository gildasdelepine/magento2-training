<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Api\Data;

/**
 * Seller Data Interface
 *
 * @api
 */
interface SellerInterface
{
    /**
     * Name of the TABLE
     */
    const TABLE_NAME    = 'training_seller';

    /**#@+
     * Constants for keys of data array.
     */
    const FIELD_SELLER_ID  = 'seller_id';
    const FIELD_IDENTIFIER = 'identifier';
    const FIELD_NAME       = 'name';
    const FIELD_CREATED_AT = 'created_at';
    const FIELD_UPDATED_AT = 'updated_at';
    /**#@-*/

    /**
     * Get seller_id
     *
     * @return int|null
     */
    public function getSellerId();

    /**
     * Get identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Get created_at
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Get updated_at
     *
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set seller_id
     *
     * @param int $value
     *
     * @return SellerInterface
     */
    public function setSellerId($value);

    /**
     * Set identifier
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setIdentifier($value);

    /**
     * Set name
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setName($value);

    /**
     * Set created_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setCreatedAt($value);

    /**
     * Set updated_at
     *
     * @param string $value
     *
     * @return SellerInterface
     */
    public function setUpdatedAt($value);
}
