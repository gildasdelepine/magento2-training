<?php
namespace Training\Seller\Model\Product\Seller;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\EntityManager\Operation\ExtensionInterface;
use Training\Seller\Helper\Data as DataHelper;


class ReadHandler implements ExtensionInterface
{
    /**
     * @var DataHelper
     */
    protected $dataHelper;

    public function __construct(DataHelper $dataHelper)
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * Perform action on relation/extension attribute
     *
     * @param object $entity
     * @param array $arguments
     * @return object|bool
     */
    public function execute($product, $arguments = [])
    {
        /** @var ProductInterface $product */
        // get all the extension attributes
        $extension = $product->getExtensionAttributes();

        if ($extension->getSellers() !== null) {
            return $product;
        }

        // get the sellers linked to the product
        $sellers = $this->dataHelper->getProductSellers($product);

        // add them to the specific attribute "sellers"
        $extension->setSellers($sellers);

        // save it to the product
        $product->setExtensionAttributes($extension);

        return $product;
    }
}
