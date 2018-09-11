<?php
/**
 * Rewrite Product class
 */
namespace Training\Helloworld\Rewrite\Model;

use \Magento\Catalog\Model\Product as BaseProduct;

class Product extends BaseProduct
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return parent::getName() . ' (Hello World)';
    }
}