<?php
/**
 * Magento 2 Training Project
 * Module Training/Shop
 */
namespace Training\Shop\Config;

use Magento\Framework\Config\CacheInterface;
use Magento\Framework\Config\Data as ConfigData;
use Training\Shop\Api\Config\ShopInterface;
use Training\Shop\Config\Shop\Reader as ShopReader;

/**
 * Class Config Access: Shop
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Shop extends ConfigData implements ShopInterface
{
    /**
     * @param ShopReader     $reader
     * @param CacheInterface $cache
     * @param string         $cacheId
     */
    public function __construct(
        ShopReader      $reader,
        CacheInterface  $cache,
        $cacheId = 'training_shop_config'
    ) {
        parent::__construct($reader, $cache, $cacheId);
    }

    /**
     * {@inheritdoc}
     */
    public function getShop($code)
    {
        return $this->get($code, []);
    }

    /**
     * {@inheritdoc}
     */
    public function getShops()
    {
        return $this->get();
    }
}
