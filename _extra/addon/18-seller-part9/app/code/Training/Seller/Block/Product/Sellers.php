<?php
/**
 * Magento 2 Training Project
 * Module Training/Seller
 */
namespace Training\Seller\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Training\Seller\Api\Data\SellerInterface;
use Training\Seller\Block\Seller\AbstractBlock;
use Training\Seller\Helper\Url as UrlHelper;

/**
 * Block Product Sellers
 *
 * @author    Laurent MINGUET <lamin@smile.fr>
 * @copyright 2018 Smile
 */
class Sellers extends AbstractBlock implements IdentityInterface
{
    /**
     * @param Context     $context
     * @param Registry    $registry
     * @param UrlHelper   $urlHelper
     * @param array       $data
     */
    public function __construct(
        Context     $context,
        Registry    $registry,
        UrlHelper   $urlHelper,
        array       $data = []
    ) {
        parent::__construct($context, $registry, $urlHelper, $data);

        $product = $this->getCurrentProduct();
        if ($product) {
            $this->setData('cache_key', 'product_view_tab_sellers_' . $product->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        $identities = [];

        /** @var IdentityInterface $product */
        $product = $this->getCurrentProduct();
        if ($product) {
            $identities = array_merge($identities, $product->getIdentities());
        }

        /** @var IdentityInterface[] $sellers */
        $sellers = $this->getProductSellers();
        foreach ($sellers as $seller) {
            $identities = array_merge($identities, $seller->getIdentities());
        }

        return $identities;
    }

    /**
     * Get the current product
     *
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get the sellers attached to the current product
     *
     * @return SellerInterface[]
     */
    public function getProductSellers()
    {
        return $this->getCurrentProduct()->getExtensionAttributes()->getSellers();
    }
}
