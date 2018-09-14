<?php
/**
 * Module Training/Seller
 */
namespace Training\Seller\Block\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Training\Seller\Block\Seller\AbstractBlock;
use Training\Seller\Helper\Data as DataHelper;
use Training\Seller\Helper\Url as UrlHelper;
use Training\Seller\Model\Seller;

/**
 * Block View
 */
class Sellers extends AbstractBlock implements IdentityInterface
{
    /**
     * @var Seller[]
     */
    protected $sellers;

    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * @param Context     $context
     * @param Registry    $registry
     * @param UrlHelper   $urlHelper
     * @param DataHelper  $dataHelper
     * @param array       $data
     */
    public function __construct(
        Context     $context,
        Registry    $registry,
        UrlHelper   $urlHelper,
        DataHelper  $dataHelper,
        array       $data = []
    ) {
        $this->dataHelper = $dataHelper;

        parent::__construct($context, $registry, $urlHelper, $data);

        $product = $this->getCurrentProduct();
        if ($product) {
            // creation de la cle de cache pour chaque produit (dynamisee en fonction des produits).
            // 1 cache par page produit.
            $this->setData('cache_key', 'product_view_tab_sellers_' . $product->getId());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        // Carte d'identité dynamique.
        // Clé de cache mise à jour si des produits ou des sellers sont ajoutés/enlevés.
        $identities = [];

        $product = $this->getCurrentProduct();
        if ($product) {
            $identities = array_merge($identities, $product->getIdentities());
        }

        $sellers = $this->getProductSellers();
        foreach ($sellers as $seller) {
            $identities = array_merge($identities, $seller->getIdentities());
        }

        return $identities;
    }

    /**
     * Get the current seller
     *
     * @return Product
     */
    public function getCurrentProduct()
    {
        return $this->registry->registry('current_product');
    }

    /**
     * Get the list of the sellers linked to a product
     */
    public function getProductSellers()
    {
        if(is_null($this->sellers)) {
            $this->sellers = [];
            $product = $this->getCurrentProduct();
            if ($product) {
                $this->sellers = $this->dataHelper->getProductSellers($product);
            }
        }
        return $this->sellers;
    }
}
