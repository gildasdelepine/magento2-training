<?php
/**
 * Magento 2 Training Project
 * Module Training/Helloworld
 */
namespace Training\Helloworld\Rewrite\Model;

use Magento\Catalog\Model\Product as BaseProduct;

/**
 * Rewrite \Magento\Catalog\Model\Product
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Product extends BaseProduct
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $value = parent::getName() . ' (Hello World)';
        
        return $value;
    }
}
