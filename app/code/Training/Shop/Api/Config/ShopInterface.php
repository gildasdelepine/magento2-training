<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Api\Config;

/**
 * Config Interface for shop.xml
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
interface ShopInterface
{
    /**
     * Get a shop by its code
     *
     * @param string $code
     *
     * @return array
     */
    public function getShop($code);

    /**
     * Get all registered shops
     *
     * @return array
     */
    public function getShops();
}
